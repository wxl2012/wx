<?php
/**
 * 订单控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace ucenter;

class Controller_Order extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    public function action_index(){
        $params = [

        ];

        $store = \Session::get('store');
        $items = \Model_Order::query()
            ->where(['buyer_id' => \Auth::get_user()->id])
            ->get();

        $params['items'] = $items;
        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/order/index");
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
                if(\Input::get('to_url', false)){
                    \Response::redirect(\Input::get('to_url'));
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
