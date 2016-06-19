<?php
/**
 * 菜品控制器
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

class Controller_Dish extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    /**
     * 菜品列表
     */
    public function action_index(){
        $this->template->content = \View::forge("{$this->theme}/dish/index");
    }

    /**
     * 查看菜品
     */
    public function action_view(){
        $this->template->content = \View::forge("{$this->theme}/dish/view");
    }
}
