<?php
/**
 * 默认控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace ucenter;

class Controller_Home extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    public function action_index(){
        die('index');
    }

    public function action_register(){

        if(\Input::method() == 'POST'){
            $data = \Input::post();

        }

        $params = [
            'title' => '用户注册'
        ];

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/register");
    }

    public function action_login(){
        $params = [
            'title' => '用户登录'
        ];

        if(\Input::method() == 'POST'){
            if(\Auth::login()){
                $to_url = \Input::get('to_url', false);
                if($to_url){
                    \Response::redirect($to_url);
                }
                die('登录成功');
            }
            die('登录失败');
        }

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/login");
    }

    public function action_forget_pwd(){
        $params = [
            'title' => '忘记密码'
        ];

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/forget");
    }
}
