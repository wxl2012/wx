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

        if(\Input::method() == 'POST'){
            $data = \Input::post();

        }

        $params = [
            'title' => '注册资料'
        ];

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
}
