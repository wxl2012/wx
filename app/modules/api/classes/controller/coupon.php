<?php
/**
 * 优惠券控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace api;

class Controller_Coupon extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    /**
     * 检测sn码
     */
    public function action_check_sn(){
        $coupon = \Model_PeopleCoupon::query()
            ->related('coupon')
            ->where([
                'user_id' => 0,
                'sn' => \Input::post('no', '')
            ])
            ->get_one();

        if( ! $coupon){
            return $this->response(['status' => 'err', 'msg' => '未找到优惠券', 'errcode' => 10], 200);
        }

        $not_allowed_date = explode(',', $coupon->coupon->not_allowed_date);
        if($coupon->status != 'NONE'){
            return $this->response(['status' => 'err', 'msg' => '优惠码已使用', 'errcode' => 10], 200);
        }else if($coupon->pwd != \Input::post('pwd', '')){
            return $this->response(['status' => 'err', 'msg' => '验证码错误', 'errcode' => 10], 200);
        }else if(($coupon->coupon->start && $coupon->coupon->start > time())
            || ($coupon->coupon->end && $coupon->coupon->end < time())
            ||  in_array(date('w'), $not_allowed_date)
            || in_array(date('Y-m-d'), $not_allowed_date)){
            return $this->response(['status' => 'err', 'msg' => '优惠不在可用时间段', 'errcode' => 10], 200);
        }else if($coupon->coupon->allowed_categories && ! in_array(\Input::post('category', ''), explode(',', $coupon->coupon->allowed_categories))){
            return $this->response(['status' => 'err', 'msg' => '优惠码不适用该订单', 'errcode' => 10], 200);
        }

        return $this->response(['status' => 'succ', 'msg' => '', 'errcode' => 0, 'data' => $coupon], 200);
    }
}
