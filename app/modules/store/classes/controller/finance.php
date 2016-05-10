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

    public function action_index(){
        die();
    }

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
                return;
            }

            //查询收款帐户
            $bank = \Model_PeopleBank::find(\Input::post('bank_id'));

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
    public function actiaon_bank(){
        $this->template->content = \View::forge("{$this->theme}/finance/bank");
    }

    /**
     * 商户充值
     */
    public function action_recharge(){
        $this->template->content = \View::forge("{$this->theme}/finance/recharge");
    }
}
