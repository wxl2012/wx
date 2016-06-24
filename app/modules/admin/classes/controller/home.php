<?php
/**
 * 后台管理基础控制器
 *
 * @package  app
 * @extends  Controller
 */
namespace admin;

class Controller_Home extends Controller_BaseController
{
    public function before(){
        parent::before();
    }

    public function action_index(){
        $this->template->content = \View::forge('ace/dashboard');
    }

    public function action_login(){

        if(\Auth::check()){
            $redirect = "/admin";
            if(isset($data['to_url'])){
                $redirect = $data['to_url'];
            }
            \Response::redirect($redirect);
        }

        \View::set_global(
            array('menu' => 'admin-home',
                'title' => '登录系统',
                'action' => 'login',
            )
        );

        if(\Input::method() == 'POST'){

            if(\Auth::login()){

                if(\Auth::get_user()->username == 'admin'){
                    \Response::redirect('/admin');
                }

                $employee = \Model_Employee::query()
                    ->where('parent_id', \Auth::get_user()->id)
                    ->get_one();

                if( ! $employee){
                    \Session::set_flash('msg', ['status' => 'err', 'msg' => '非法登录,多次尝试登录,您的帐户将被封锁!', 'title' => '警告', 'sub_title' => '非法登录', 'icon' => 'exclamation-circle', 'color' => '#d9534f']);
                    return $this->not_login_alert();
                }

                // 保存会话信息: 当前登录人员的身份、所属商户、微信公众号信息
                \Session::set('seller', $employee->seller);
                \Session::set('people', $employee->people);
                \Session::set('employee', $employee);


                // 查询当前商户默认公众号信息
                $accounts = \Model_WXAccount::query()
                    ->where(['seller_id' => $employee->seller->id])
                    ->get();
                $account = false;
                if(count($accounts) > 1){
                    foreach ($accounts as $item) {
                        if($account->is_default == 1){
                            $account = $item;
                            break;
                        }
                    }
                }else{
                    $account = current($accounts);
                }

                \Session::set('WXAccount', $account);
                
                //获取API访问令牌
                $result = \handler\common\UrlTool::request(\Config::get('base_url') . 'api/token.json?user_id=' . \Auth::get_user()->id);
                $token = json_decode($result->body);
                \Session::set('access_token', $token->access_token);

                $redirect = "/admin";
                if(isset($data['to_url'])){
                    $redirect = $data['to_url'];
                }
                \Response::redirect($redirect);
            }
            \Session::set_flash('msg', array('status' => 'err', 'msg' => '登录失败', 'errcode' => 20));
        }

        return \Response::forge(\View::forge("ace/login"));
    }

    public function action_logout(){
        \Auth::logout();
        \Session::destroy();
        \Response::redirect('/admin/login');
    }
}
