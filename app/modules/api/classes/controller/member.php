<?php
/**
 * 会员控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace api;

class Controller_Member extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    /**
     * 开始打印
     */
    public function action_index(){
        die('');
    }

    /**
     * 收货地址列表
     */
    public function action_address(){
        $items = \Model_PeopleAddress::query()
            ->where(['parent_id' => $this->user->id, 'is_delete' => 0])
            ->get();

        foreach ($items as $item){
            $item->country;
            $item->province;
            $item->city;
            $item->county;
        }
        return $this->response(['status' => 'succ', 'msg' => '', 'errcode' => 0, 'data' => $items], 200);
    }

    public function action_address_save(){

        $msg = ['status' => 'err', 'msg' => '', 'errcode' => 10];

        $data = \Input::post();
        $address = \Model_PeopleAddress::forge($data);
        $address->parent_id = \Auth::get_user()->id;

        if($address->save()){
            
            $address->country;
            $address->province;
            $address->city;
            $address->county;

            $msg = ['status' => 'succ', 'msg' => '', 'errcode' => 0, 'data' => $address];
        }

        return $this->response($msg, 200);
    }

    /**
     * 我的优惠券
     */
    public function action_coupons(){
        $coupons = \Model_PeopleCoupon::query()
            ->related('coupon')
            ->where([
                'user_id' => $this->user->id,
                'status' => 'NONE'
            ])
            ->where('coupon.start', '<', time())
            ->where('coupon.end', '>', time())
            ->where('coupon.quota', '>=', \Input::post('fee'))
            ->where('coupon.not_allowed_date', 'NOT IN', [date('w'), date('Y-m-d')])
            ->get();

        //限制门类并转数组
        $items = [];
        foreach($coupons as $coupon){
            foreach(\Input::post('category_ids') as $item){
                if($coupon->coupon->allowed_categories == '' || in_array($item, explode(',', $coupon->coupon->allowed_categories))){
                    array_push($items, $coupon->to_array());
                    break;
                }
            }
        }

        return $this->response(['status' => 'succ', 'msg' => '', 'errcode' => 0, 'data' => $items], 200);
    }
}
