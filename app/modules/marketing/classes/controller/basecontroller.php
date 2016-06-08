<?php
/**
 * 基础控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace marketing;

abstract class Controller_BaseController extends \Controller_BaseController {

    public $template = 'default/template';
    public $theme = 'default';

    //活动数据对象
    protected $marketing;

    public function before(){
        parent::before();
    }

    /**
     * 验证活动合法性
     */
    protected function valid_marketing(){

    }

    /**
     * 验证用户合法性
     */
    protected function valid_user(){

    }

    /**
     * 记录参与信息
     */
    protected function save_record(){
        //redis中记录参与信息
    }

    /**
     * 同步redis及数据库数据
     */
    protected function syn_data(){}
}
