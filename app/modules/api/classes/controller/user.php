<?php
/**
 * 我的控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace api;

class Controller_User extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    /**
     * 我的收款方式
     */
    public function action_banks(){
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

    /**
     * 我的默认收款方式
     */
    public function action_bank_default(){
        $bank = \Model_PeopleBank::query()
            ->where([
                'parent_id' => $this->user->id,
                'is_default' => 1
            ])
            ->get_one();

        if( ! $bank){
            return $this->response(['status' => 'err', 'msg' => '未找到默认收款方式', 'errcode' => 10], 200);
        }

        $bank->bank;

        return $this->response(['status' => 'succ', 'msg' => '', 'errcode' => 0, 'data' => $bank], 200);
    }

    /**
     * 申请提现
     *
     * @return string
     */
    public function action_cashback_apply()
    {
        if(\Input::method() == 'POST'){
            $msg = ['status' => 'err', 'msg' => '', 'errcode' => 10];

            $member = \Model_Member::query()
                ->where(['parent_id' => $this->user->id, 'seller_id' => $this->seller->id])
                ->get_one();

            if($member->money < floatval(\Input::post('money'))){
                $msg['msg'] = '余额不足!';
                $this->response($msg, 200);
                return;
            }

            //判断是否有处理中的申请
            $count = \Model_CashbackApply::query()
                ->where([
                    'parent_id' => $this->user->id,
                    'money' => \Input::post('money')
                ])
                ->where('status', 'IN', ['WAIT', 'ALLOW'])
                ->count();
            if($count > 0){
                $msg['msg'] = '您还有未处理的申请!';
                $this->response($msg, 200);
                return;
            }

            //查询收款帐户
            $bank = \Model_PeopleBank::find(\Input::post('account_id'));

            //添加提现审核记录
            $apply = \Model_CashbackApply::forge();
            $apply->set([
                'money' => \Input::post('money'),
                'parent_id' => $this->user->id,
                'status' => 'WAIT',
                'name' => $bank->account_name,
                'account' => $bank->account,
                'bank_id' => $bank->bank->id
            ]);

            if($apply->save()){
                $msg = ['status' => 'succ', 'msg' => '申请已提交,请耐心等待审核!', 'errcode' => 0];
            }

            $this->response($msg, 200);
        }
    }
}
