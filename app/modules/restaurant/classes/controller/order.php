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

/**
 * 本控制器主要用于：
 * 1.
 * @package  app
 * @extends  Controller
 */

namespace restaurant;

class Controller_Order extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    /**
     * 我的订单
     */
    public function action_index(){
        $this->template->content = \View::forge("{$this->theme}/order/index");
    }

    /**
     * 查看订单详情
     */
    public function action_view(){
        $this->template->content = \View::forge("{$this->theme}/order/view");
    }
}
