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
 * 微信手机端基础控制器
 *
 * 主要用于实现必要公共功能
 *
 * @package  app
 * @extends  Controller
 */
abstract class Controller_WXController extends BaseController
{
	public function before(){
    	parent::before();
    }
}
