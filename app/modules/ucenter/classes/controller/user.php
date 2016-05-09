<?php
/**
 * 用户控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace ucenter;

class Controller_User extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    public function action_index(){

        if(\Input::method() == 'POST'){
            $data = \Input::post();
        }

        $params = [
            'title' => '我的资料'
        ];

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/user/index");
    }

    public function action_init(){

        $params = [
            'title' => '注册资料'
        ];

        $people = \Model_People::query()
            ->where('parent_id', \Auth::get_user()->id)
            ->get_one();

        if($people->phone){
            \Session::set_flash('msg', ['status' => 'err', 'msg' => '您已注册过帐户! 请勿重复注册!', 'title' => '温馨提示']);
            return $this->show_message();
        }

        if(\Input::method() == 'POST'){
            $msg = ['status' => 'err', 'msg' => '', 'errcode' => 10];
            $data = \Input::post();

            $this->change_user();

            if($data['birthday']){
                $data['birthday'] = strtotime($data['birthday']);
            }

            $people->set($data);
            if($people->save()){
                $msg = ['status' => 'succ', 'msg' => '', 'errcode' => 0];
            }

            if(\Input::is_ajax()){
                die(json_encode($msg));
            }
        }

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/user/init");
    }

    public function action_bind(){

        if(\Input::method() == 'POST'){
            $data = \Input::post();

        }

        $params = [
            'title' => '绑定微信'
        ];

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/user/bind");
    }

    public function action_change_pwd(){

        if(\Input::method() == 'POST'){
            $data = \Input::post();

        }

        $params = [
            'title' => '修改密码'
        ];

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/user/change_pwd");
    }

    /**
     * 修改用户信息
     *
     */
    private function change_user(){

        $rule = \Validation::forge('init_user');
        $rule->add_callable('\handler\validation\MyRules');
        $rule->add_field('username', '用户名', 'required|trim|min_length[5]|max_length[30]|unique[users.username]');
        $rule->add_field('password', '密码', 'required|trim|min_length[6]');

        if( ! $rule->run()){
            $errors = [];
            foreach ($rule->error() as $key => $value) {
                /*$error[$key] = (string)$value;
                array_push($errors, $error);*/
                array_push($errors, (string)$value);
            }

            die(json_encode(['status' => 'err', 'msg' => '表单验证错误', 'errcode' => 10, 'data' => $errors]));
        }

        //修改密码
        $password = \Auth::reset_password(\Auth::get_user()->username);
        if( ! \Auth::change_password($password, \Input::post('password'))){
            die(json_encode(['status' => 'err', 'msg' => '密码修改失败', 'errcode' => 10]));
        }

        //修改登录名
        \DB::update('users')->set(['username' => \Input::post('username')])->where('id', \Auth::get_user()->id)->execute();
    }
}
