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
    }

    public function action_index(){
        die();
    }

    public function action_register(){
        $params = [
            'title' => '注册成为职员'
        ];

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
