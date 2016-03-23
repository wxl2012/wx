<?php
/**
 * 商城订单控制器
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

class Controller_Mall extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    public function action_cashback($id = 0){
        $this->order = \Model_Order::find($id);
        if( ! $this->order){
            die('订单不存在');
        }

        if( ! $this->cashback()){
            die('分红时遇到问题:' . $this->result_message);
        }
        die('分红成功');
    }
}
