<?php
/**
 * 会员财务控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace ucenter;

class Controller_Finance extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    /**
     * 我的支付收入明细
     */
    public function action_index(){
        die('index');
    }

    /**
     * 申请提现
     */
    public function action_cashback(){
        $params = [
            'title' => '申请提现'
        ];

        $params['item'] = \Model_Member::query()
            ->where(['user_id' => \Auth::get_user()->id, 'seller_id' => \Session::get('seller')->id])
            ->get_one();

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

        $params['items'] = \Model_CashbackApply::query()
            ->where('parent_id', \Auth::get_user()->id)
            ->get();

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/finance/cashback_records");
    }

    /**
     * 收款方式列表
     */
    public function action_banks(){

        $params = [
            'title' => '我的收款方式'
        ];

        $params['items'] = \Model_PeopleBank::query()
                ->where('parent_id', \Auth::get_user()->id)
                ->get();

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/finance/banks");
    }

    /**
     * 收款方式详情
     */
    public function action_bank(){

        if(\Input::method() == 'POST'){
            $msg = ['status' => 'err', 'msg' => '', 'errcode' => 10];
            $data = \Input::post();
            $data['parent_id'] = \Auth::get_user()->id;
            $data['bank_id'] = in_array($data['payment_type'], [1, 2]) ? $data['payment_type'] : $data['bank_id'];

            $count = \Model_PeopleBank::query()
                ->where([
                    'parent_id' => \Auth::get_user()->id,
                    'account' => $data['account'],
                    'bank_id' => $data['bank_id']
                ])
                ->count();

            if($count > 0){
                $msg = ['status' => 'err', 'msg' => '帐户已存在!', 'errcode' => 0];
                die(json_encode($msg));
            }

            $bank = \Model_PeopleBank::forge();
            $bank->set($data);
            if($bank->save()){
                $bank->bank;
                $msg = ['status' => 'succ', 'msg' => '', 'errcode' => 0, 'data' => $bank->to_array()];
            }

            if(\Input::is_ajax()){
                die(json_encode($msg));
            }
            \Session::set_flash('msg', $msg);
        }

        $this->template->content = \View::forge("{$this->theme}/finance/bank");
    }

    /**
     * 商户充值
     */
    public function action_recharge(){
        $this->template->content = \View::forge("{$this->theme}/finance/recharge");
    }
}
