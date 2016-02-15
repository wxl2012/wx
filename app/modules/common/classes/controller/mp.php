<?php
/**
 * 微信公众号常用方法控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

/**
 * 本控制器主要用于：
 * 1.
 * @package  app
 * @extends  Controller
 */

namespace common;

class Controller_Mp extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    public function action_jssdk(){
        return \Response::forge(\View::forge("{$this->theme}/mp/jssdk"));
    }
}
