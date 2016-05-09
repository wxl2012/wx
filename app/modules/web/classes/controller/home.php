<?php
/**
 * 默认控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace web;

class Controller_Home extends Controller_BaseController {

    public $template = 'default/template';
    public $theme = 'default';

    public function before(){
        parent::before();
    }
    
    public function action_index(){}

    /**
     * 总览
     */
    public function action_dashboard(){
        
    }

    /**
     * 今日财报
     */
    public function action_dashboard_day(){

    }
}
