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
