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
 * 模  块: 书法名字数据库模块
 * 
 * 基础控制器
 *
 * @package  app
 * @extends  Controller
 */
namespace calligrapher;

abstract class Controller_BaseController extends \Controller_BaseController
{
    public $template = 'default/template';
    public $theme = 'default';
    protected $result_message = false;

    public function before(){
        parent::before();
    }
}
