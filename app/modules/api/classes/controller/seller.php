<?php
/**
 * 商家控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace api;

class Controller_Seller extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    /**
     * 获取支付方式
     */
    public function action_payments(){
        $address = \Model_Payment::query()
            ->where(['status' => 'ENABLE', 'seller_id' => \Session::get('seller')->id])
            ->get();

        $items = [];
        foreach($address as $item){
            array_push($items, $item->to_array());
        }

        die(json_encode(['status' => 'succ', 'msg' => '', 'errcode' => 0, 'data' => $items]));
    }
}
