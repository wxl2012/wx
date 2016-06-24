<?php
/**
 * 拍卖模块基础控制器
 *
 * @package    auction
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

/**
 * @package  app
 * @extends  \Controller_BaseController
 */

namespace auction;

abstract class Controller_BaseController extends \Controller_BaseController {

    public $template = 'default/template';
    public $theme = 'default';

    public function before(){
        parent::before();
    }
}
