<?php
/**
 * 拍品管理控制器
 *
 * @package  app
 * @extends  Controller
 */
namespace admin;

class Controller_Auction_Lot extends Controller_BaseController
{
    public function before(){
        parent::before();

        \View::set_global(['controller_name' => '拍品管理']);
    }

    /**
     * 投票列表
     */
    public function action_index(){
        $params = array(
            'title' => '拍品管理',
            'menu' => 'lot-index',
            'action_name' => '拍品列表——拍品管理'
        );

        $params['items'] = \Model_Lot::query()
            ->where(['account_id' => \Session::get('WXAccount')->id])
            ->get();

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/auction/index");
    }

    /**
     * 拍品信息保存
     * @param int $id
     * @throws \Exception
     * @throws \FuelException
     */
    public function action_save($id = 0){
        if(\Input::method() == 'POST'){
            $msg = ['status' => 'err', 'msg' => '', 'errcode' => 10];
            $data = \Input::post();
            $data['begin_at'] = $data['begin_at'] ? strtotime($data['begin_at']) : 0;
            $data['end_at'] = $data['end_at'] ? strtotime($data['end_at']) : 0;

            $lot = \Model_Lot::find($id);
            if( ! $lot){
                $lot = \Model_Lot::forge();
            }
            $lot->set($data);

            if($lot->save()){
                $msg = ['status' => 'succ', 'msg' => '', 'errcode' => 0, 'data' => $lot->to_array()];
            }

            if(\Input::is_ajax()){
                die(json_encode($msg));
            }
            \Session::set_flash('msg', $msg);
        }

        $params = [];

        $params['item'] = \Model_Lot::find($id);
        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/auction/details");
    }

    /**
     * 结束拍品活动
     * @param int $id
     * @throws \Exception
     * @throws \FuelException
     */
    public function action_end($id = 0){
        if(\Input::method() == 'POST'){
            $msg = ['status' => 'err', 'msg' => '', 'errcode' => 10];

            $record = \Model_PlaceBidRecord::query()
                ->where([
                    'lot_id' => $id
                ])
                ->order_by(['bid' => 'DESC'])
                ->get_one();

            $order = \Model_Order::find($record->order_id);
            $order->order_status = 'FINISH';

            if($order->save()){
                $msg = ['status' => 'succ', 'msg' => '', 'errcode' => 0];
            }

            if(\Input::is_ajax()){
                die(json_encode($msg));
            }
            \Session::set_flash('msg', $msg);
        }

        $params = [];

        $params['item'] = \Model_Lot::find($id);
        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/auction/details");
    }
}
