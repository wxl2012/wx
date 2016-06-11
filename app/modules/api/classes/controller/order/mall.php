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

class Controller_Order_Mall extends Controller_Order {

    public function before(){
        parent::before();
        //\Session::set('seller', \Model_Seller::find(1));
    }

    public function action_create(){
        if(\Input::method() == 'POST'){
            $msg = [
                'msg' => '',
                'errcode' => 0,
                'status' => 'succ'
            ];
            //检测必要的订单信息

            $data = \Input::post();
            //生成订单明细
            $details = [];
            foreach($data['dishes'] as $item){
                $goods = \Model_Goods::find($item['id']);
                $detail = [
                    'goods_id' => $goods->id,
                    'price' => $goods->sale_price ? $goods->sale_price : $goods->price,
                    'num' => $item['num']
                ];
                array_push($details, $detail);
            }
            $this->load_details($details);

            if(isset($data['coupons'])){
                //生成优惠信息
                $this->load_preferential($data['coupons']);
            }

            if( ! $this->save($data)){
                $msg = [
                    'msg' => $this->result_message,
                    'errcode' => 20,
                    'status' => 'err'
                ];
            }

            if(\Input::is_ajax()){
                die(json_encode($msg));
            }
        }
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
