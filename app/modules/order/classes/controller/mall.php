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
            foreach($data['goods'] as $id){
                $item = \Model_Trolley::find_one_by('goods_id', $id);
                array_push($details, $item->to_array());
            }
            $this->load_details($details);
            //生成优惠信息
            $this->load_preferential($data['coupons']);
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

        $params = [
            'title' => ''
        ];

        $params['trolley_ids'] = [1, 2, 3];

        \View::set_global($params);
        $this->template->title = '创建订单';
        $this->template->content = \View::forge("{$this->theme}/create");
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
