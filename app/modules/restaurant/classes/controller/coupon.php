<?php
/**
 * 优惠券控制器
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

class Controller_Coupon extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    /**
     * 我的优惠券
     */
    public function action_index(){
        $params = [
            'title' => '我的优惠券'
        ];

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/coupon/index");
    }

    /**
     * 查看优惠券详情
     */
    public function action_view(){
        $params = [
            'title' => '优惠券详情'
        ];

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/coupon/view");
    }
}
