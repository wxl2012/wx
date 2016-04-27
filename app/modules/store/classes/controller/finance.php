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

    public function action_cashback(){
        $params = [
            'title' => '申请提现'
        ];
        
        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/finance/cashback");
    }

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
}
