<?php
/**
 * 雇员订单控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace store;

class Controller_Employee extends Controller_BaseController {

    public function before(){
        parent::before();
        if( ! \Auth::check()){
            $url = \Uri::current();
            $params = \Uri::build_query_string(\Input::get());
            \Response::redirect("/ucenter/login?to_url={$url}?{$params}");
        }
    }

    public function action_index(){
        die();
    }

    public function action_register(){
        $params = [
            'title' => '注册成为职员'
        ];
        $params['user'] = \Model_User::find(\Auth::get_user()->id);
        $params['seller'] = \Model_Seller::find(\Input::get('seller_id'));

        $employee = \Model_Employee::query()->where(['user_id' => $params['user']->id, 'seller_id' => $params['seller']->id])->get_one();
        if($employee){
            \Session::set_flash('msg', ['msg' => "您已是{$params['seller']->name}的职员, 请勿重复注册!"]);
            return $this->show_message();
        }
        
        if(\Input::method() == 'POST'){

            $data = \Input::post();

            //保存雇员信息
            if( ! $employee){
                $employee = \Model_Employee::forge();
                $employee->set($data);
                $employee->save();
            }

            //修改资料
            $people = \Model_People::query()->where('parent_id', $params['user']->id)->get_one();
            $people->first_name = $data['first_name'];
            $people->last_name = $data['last_name'];
            $people->gender = $data['gender'];
            $people->age = $data['age'];
            $people->save();
        }

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/employee/register");
    }

    public function action_qrcode(){
        $params = [
            'title' => '扫码成为职员',
            'seller' => \Model_Seller::find(1)
        ];

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/employee/register_qrcode");
    }
}
