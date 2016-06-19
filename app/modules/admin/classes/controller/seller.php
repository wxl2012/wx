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
 * 商户管理控制器
 *
 * @package  app
 * @extends  Controller
 */
namespace admin;

class Controller_Seller extends Controller_BaseController
{
    public function before(){
        parent::before();
    }

    public function action_index(){
        $this->template->content = \View::forge("{$this->theme}/dashboard");
    }

    public function action_register(){
        return \Response::forge(\View::forge("{$this->theme}/seller/register"));
    }
}
