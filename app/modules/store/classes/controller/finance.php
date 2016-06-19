<?php
/**
 * 店铺订单控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace store;

class Controller_Finance extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    /**
     * 我的收支记录
     */
    public function action_index(){
        die();
    }

    /**
     * 我的结算记录
     *
     * @param bool $status 结算状态
     */
    public function action_settlement($status = false){}

    /**
     * 申请提现
     */
    public function action_cashback(){
        $params = [
            'title' => '申请提现'
        ];

        if(\Input::method() == 'POST'){
            $msg = ['status' => 'err', 'msg' => '', 'errcode' => 10];

            //判断是否有处理中的申请
            $count = \Model_CashbackApply::query()
                ->where([
                    'parent_id' => \Auth::get_user()->id,
                    'money' => \Input::post('money')
                ])
                ->where('status', 'IN', ['WAIT', 'ALLOW'])
                ->count();
            if($count > 0){
                $msg['msg'] = '您还有未处理的申请!';
                if(\Input::is_ajax()){
                    die(json_encode($msg));
                }
                \Session::set_flash('msg', $msg);
                return $this->show_message();
            }

            //查询收款帐户
            $bank = \Model_PeopleBank::find(\Input::post('account_id'));

            //添加提现审核记录
            $apply = \Model_CashbackApply::forge();
            $apply->set([
                'money' => \Input::post('money'),
                'parent_id' => \Auth::get_user()->id,
                'status' => 'WAIT',
                'name' => $bank->name,
                'account' => $bank->account,
                'bank_id' => $bank->bank->id
            ]);

            if(! $apply->save()){
                $msg = ['status' => 'succ', 'msg' => '', 'errcode' => 0];
            }

            if(\Input::is_ajax()){
                die(json_encode($msg));
            }
        }
        
        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/finance/cashback");
    }

    /**
     * 提现记录
     */
    public function action_cashback_records(){

        $params = [
            'title' => '提现记录'
        ];

        $store = \Session::get('store');
        $items = \Model_Order::query()
            ->where(['store_id' => $store->id, 'cashback_status' => 0])
            ->where('order_status', 'IN', ['FINISH', 'SELLER_SHIPPED', 'SECTION_FINISH'])
            ->get();

        $params['items'] = $items;

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/finance/cashback_records");
    }

    /**
     * 收款方式列表
     */
    public function action_banks(){
        $this->template->content = \View::forge("{$this->theme}/finance/banks");
    }

    /**
     * 收款方式详情
     */
    public function action_bank(){
        $this->template->content = \View::forge("{$this->theme}/finance/bank");
    }

    /**
     * 商户充值
     */
    public function action_recharge(){
        if(\Input::method() == 'POST'){
            $msg = [
                'status' => 'err',
                'msg' => '充值失败',
                'errcode' => 10
            ];

            $data = \Input::post();
            $data = [
                'order_no' => \Model_Order::get_order_on(),
                'order_name' => "商户充值{$data['money']}元",
                'order_body' => "商户充值{$data['money']}元",
                'total_fee' => $data['money'],
                'original_fee' => $data['money'],
                'buyer_id' => \Auth::get_user()->id,
                'from_id' => 1,
                'remark1' => \Session::get('employee')->id,
                'order_status' => 'WAIT_PAYMENT',
                'payment_id' => 0
            ];
            $order = \Model_Order::forge($data);
            if($order->save()){
                $msg['status'] = 'succ';
                $msg['msg'] = '充值成功';
                $msg['data'] = $order->to_array();
            }

            if(\Input::is_ajax()){
                die(json_encode($msg));
            }
            \Session::set_flash('msg', $msg);
        }
        $this->template->content = \View::forge("{$this->theme}/finance/recharge");
    }
}
