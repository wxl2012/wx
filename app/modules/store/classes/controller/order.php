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

class Controller_Order extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    public function action_index(){
        $params = [

        ];

        $store = \Session::get('store');
        $items = \Model_Order::query()
            ->where(['store_id' => $store->id])
            ->get();

        $params['items'] = $items;
        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/order/index");
    }

    public function action_dashboard(){
        $params = [

        ];

        $store = \Session::get('store');
        $items = \Model_Order::query()
            ->where(['store_id' => $store->id])
            ->get();

        $params['items'] = $items;
        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/order/dashboard");
    }

    public function action_cashback(){

        $params = [

        ];

        $store = \Session::get('store');
        $items = \Model_Order::query()
            ->where(['store_id' => $store->id, 'cashback_status' => 0])
            ->where('order_status', 'IN', ['FINISH', 'SELLER_SHIPPED', 'SECTION_FINISH'])
            ->get();

        $params['items'] = $items;

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/order/cashback");
    }

    public function action_cashback_members(){
        $params = [

        ];

        $params['items'] = \Model_MemberRecommendRelation::childMembers(\Auth::get_user()->id);
        /*foreach ($members as $member){
            echo "{$member->member_id}[{$member->depth}级]: " . count($member->member->orders) . '单<br>';
            foreach ($member->member->orders as $order) {
                echo '付款金额:' . ($order->original_fee) . '应分总额:' . ($order->original_fee * 0.1 * 0.5);
            }
        }*/

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/order/members");
    }

    public function action_view(){
        $this->template->content = \View::forge("{$this->theme}/order/view");
    }
}
