<?php
/**
 * 购物车控制器
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

namespace restaurant;

class Controller_Trolley extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    /**
     * 购物车清单
     */
    public function action_index(){
        $this->template->content = \View::forge("{$this->theme}/trolley/index");
    }
}
