<?php
/**
 * 订单基础控制器
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

namespace order;

abstract class Controller_BaseController extends \Controller_BaseController {

    public $template = 'default/template';
    public $theme = 'default';

    public function before(){
        parent::before();
    }

    /**
     * 生成订单号
     */
    protected function generate_order_no(){

    }


    /**
     * 保存订单
     * @param $data 订单数据
     */
    protected function save($data){

    }

    /**
     * 删除订单
     *
     * @param $id 订单ID
     */
    protected function delete($id){

    }

    /**
     * 发货
     *
     * @param $id
     */
    protected function delivery($id){

    }
}
