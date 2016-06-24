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
            $data['start_at'] = $data['start_at'] ? strtotime($data['start_at']) : 0;
            $data['end_at'] = $data['end_at'] ? strtotime($data['end_at']) : 0;
            $data['account_id'] = \Session::get('WXAccount')->id;
            $data['seller_id'] = \Session::get('WXAccount')->seller_id;
            $data['type'] = 'VOTE';
            $market = \Model_Marketing::find($id);
            if( ! $market){
                $market = \Model_Marketing::forge();
            }
            $market->set($data);

            if($market->save()){
                $limit = \Model_MarketingLimit::forge(['involved_total_num' => 1, 'marketing_id' => $market->id]);
                $limit->save();
                $msg = ['status' => 'succ', 'msg' => '', 'errcode' => 0, 'data' => $market->to_array()];
            }

            if(\Input::is_ajax()){
                die(json_encode($msg));
            }
            \Session::set_flash('msg', $msg);
        }
    }
}
