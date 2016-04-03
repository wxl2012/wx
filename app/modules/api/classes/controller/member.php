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
        $address = \Model_PeopleAddress::query()
            ->where(['parent_id' => \Auth::get_user()->id, 'is_delete' => 0])
            ->get();

        $items = [];
        foreach($address as $item){
            array_push($items, $item->to_array());
        }

        die(json_encode(['status' => 'err', 'msg' => '', 'errcode' => 0, 'data' => $items]));
    }

    /**
     * 我的优惠券
     */
    public function action_coupons(){
        $coupons = \Model_PeopleCoupon::query()
            ->related('coupon')
            ->where([
                'user_id' => \Auth::get_user()->id,
                'status' => 'NONE'
            ])
            ->where('coupon.start', '<', time())
            ->where('coupon.end', '>', time())
            ->where('quota', '>=', \Input::post('fee'))
            ->where('not_allowed_date', 'NOT IN', [date('w'), date('Y-m-d')])
            ->get();

        //限制门类并转数组
        $items = [];
        foreach($coupons as $coupon){
            foreach(\Input::post('category_ids') as $item){
                if($coupon->allowed_categories == '' || in_array($item, explode(',', $coupon->allowed_categories))){
                    array_push($items, $coupon->to_array());
                    break;
                }
            }
        }

        die(json_encode(['status' => 'succ', 'msg' => '', 'errcode' => 0, 'data' => $items]));
    }
}
