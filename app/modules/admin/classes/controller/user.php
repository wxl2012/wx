<?php
/**
 * 基于FuelPHP的微信第三方程序库
 *
 * @package    Fuel
 * @version    1.7
 * @author     Ray zyr.wxl@gmail.com
 * @license    MIT License
 * @copyright  2015 PMonkey Team
 * @link       http://mnzone.cn
 */

/**
 * 后台用户帐户控制器
 *
 * @package  app
 * @extends  Controller
 */
namespace admin;

class Controller_User extends Controller_BaseController
{
    public function before(){
        parent::before();
    }

    public function action_index(){
        $this->template->content = \View::forge("{$this->theme}/dashboard");
    }

    public function action_change_pwd(){

        if(\Input::method() == 'POST'){
            $msg = ['status' => 'err', 'msg' => '', 'errcode' => 10];

            $data = \Input::post();
            
            try{
                $flag = \Auth::change_password($data['password'], $data['new_password']);
                if($flag){
                    $msg = ['status' => 'succ', 'msg' => '', 'errcode' => 0];
                }
            }catch (\Auth\SimpleUserUpdateException $e){
                var_dump($e);
            }

            if(\Input::is_ajax()){
                die(json_encode($msg));
            }

            \Session::set_flash('msg', $msg);
        }

        $params = [
            'title' => '修改密码'
        ];

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/user/change_pwd");
    }
}
