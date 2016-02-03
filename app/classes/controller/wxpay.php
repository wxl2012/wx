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
 * 微信支付控制器
 *
 * 主要实现红包发放功能
 *
 * @package  app
 * @extends  Controller
 */
class Controller_WXPayController extends WXController
{
	public function before(){
    	parent::before();
    }

    public function action_index(){
    	die('this is WXController');
    }
}
