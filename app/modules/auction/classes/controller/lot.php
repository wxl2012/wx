<?php
/**
 * 拍品控制器
 *
 * @package    auction
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace auction;

class Controller_Lot extends Controller_BaseController{

    /**
     * 拍品列表
     */
    public function action_index(){
        $params = [
            'title' => '我关注的'
        ];

        $params['items'] = \Model_Lot::query()->get();

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/lot/index");
    }

    /**
     * 推荐、精选
     */
    public function action_recommend(){
        $params = [
            'title' => '精选拍品'
        ];

        $params['items'] = \Model_Lot::query()->get();

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/lot/index");
    }

    /**
     * 拍品详情
     *
     * @param int $id 拍品ID
     */
    public function action_view($id = 0){

        $params = [
            'title' => '精选拍品'
        ];

        $params['item'] = \Model_Lot::find($id);

        \View::set_global($params);

        $this->template->content = \View::forge("{$this->theme}/lot/view");
    }

    /**
     * 出价
     * @param int $id 拍品ID
     */
    public function action_bid($id = 0){
        if(\Input::method() == 'POST'){
            $msg = ['status' => 'err', 'msg' => '', 'errcode' => 10];

            $order_no = \Model_Order::get_order_on();
            $data = [
                'order_no' => $order_no,
                'order_type' => 'AUCTION',
                'buyer_id' => \Auth::get_user()->id,
                'from_id' => \Session::get('seller')->id,
                'total_fee' => \Input::post('bid'),
                'original_fee' => \Input::post('bid'),
            ];

            $order = \Model_Order::forge($data);
            $order->details = [
                \Model_OrderDetail::forge([
                    'goods_id' => $id,
                    'num' => 1,
                    'price' => \Input::post('bid')
                ])
            ];

            if($order->save()){
                $msg = ['status' => 'succ', 'msg' => '', 'errcode' => 0];
            }

            if(\Input::is_ajax()){
                die(json_encode($msg));
            }

            \Session::set_flash('msg', $msg);
        }

    }
}