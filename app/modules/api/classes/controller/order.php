<?php
/**
 * 菜品控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace api;

abstract class Controller_Order extends Controller_BaseController {

    protected $order = false;

    public function before(){
        parent::before();
    }

    /**
     * 生成订单号
     */
    protected function generate_order_no(){
        //日期+地区码+用户ID
        /*$areas = [
            '11' => '北京市',
            '12' => '天津市',
            '13' => '河北省'
        ];*/
        $areas = [
            '11' => 100000,
            '12' => 300000,
            '13' => 300001
        ];
        $date = date('YmdHis');
        $user_id = \Auth::check() ? \Auth::get_user()->id : '00000';
        return "{$date}{$areas['11']}{$user_id}";
    }


    /**
     * 保存订单
     * @param $data 订单数据
     */
    protected function save($data){
        if( ! $this->order){
            $this->order = \Model_Order::forge();
        }

        $this->order->set($data);

        if( ! $this->order->order_no){
            $this->order->order_no = $this->generate_order_no();
        }
        if( ! $this->order->buyer_id){
            $this->order->buyer_id = \Auth::check() ? \Auth::get_user()->id : 0;
        }
        if( ! $this->order->from_id){
            $this->order->from_id = \Session::get('seller', false) ? \Session::get('seller')->id : 0;
        }
        if( ! $this->order->order_status){
            $this->order->order_status = 'WAIT_PAYMENT';
        }

        $this->original_fee = $this->order->total_fee - $this->order->preferential_fee;

        //保存订单
        if( ! $this->order->save()){
            return false;
        }

        //发送下单成功模板消息
        $params = [
            'first' => [
                'value' => '订单支付成功',
                'color' => '#D02090',
            ],
            'keyword1' => [
                'value' => $this->order->order_no,
                'color' => '#D02090',
            ],
            'keyword2' => [
                'value' => $this->order->order_name,
                'color' => '#D02090',
            ],
            'keyword3' => [
                'value' => $this->order->total_fee,
                'color' => '#D02090',
            ],
            'remark' => [
                'value' => '',
                'color' => '#D02090'
            ]
        ];
        $this->sendMsgTemplate('tQ46mymM617VOKpNv6rbg5hBQpXIle8EC64n-ozbSSw', $params, '');

        //清理购物车
        foreach($this->order->details as $item){
            $trolley = \Model_Trolley::query()
                ->where('goods_id', $item->id)
                ->get_one();

            if( ! $trolley){
                continue;
            }

            $trolley->delete();
        }

        return true;
    }

    /**
     * 填充detail数据
     */
    protected function load_details($data){
        if( ! $this->order){
            $this->order = \Model_Order::forge();
        }
        $this->order->details = [];

        $fee = 0;
        foreach($data as $item){
            array_push($this->order->details, \Model_OrderDetail::forge($item));
            $fee += intval($item['num']) * floatval($item['price']);
        }
        $this->order->total_fee = $fee;
    }

    /**
     * 添加优惠信息
     */
    protected function load_preferential($data){
        if( ! $this->order){
            $this->order = \Model_Order::forge();
        }
        $this->order->preferentials = [];

        $fee = 0;
        foreach($data as $item){
            array_push($this->order->preferentials, \Model_OrderPreferential::forge($item));
            $fee += $item->fee;
        }
        $this->order->preferential_fee = $fee;
    }

    /**
     * 删除订单
     *
     * @param $id 订单ID
     */
    protected function delete($id){

    }

    /**
     * 发货
     *
     * @param $id
     */
    protected function delivery($id){

        $this->order = \Model_Order::find($id);
        $this->order->order_status = 'DELIVERY';
        $this->order->save();

        //发送发货模板消息
        $params = [
            'first' => [
                'value' => '订单已发货!',
                'color' => '#D02090',
            ],
            'keyword1' => [
                'value' => $this->order->order_no,
                'color' => '#D02090',
            ],
            'keyword2' => [
                'value' => $this->order->total_fee,
                'color' => '#D02090',
            ],
            'keyword3' => [
                'value' => $this->order->order_name,
                'color' => '#D02090',
            ],
            'keyword4' => [
                'value' => $this->order->remark1,
                'color' => '#D02090',
            ],
            'keyword5' => [
                'value' => '服务员',
                'color' => '#D02090',
            ],
            'remark' => [
                'value' => '点击查看订单已使用状态',
                'color' => '#D02090'
            ]
        ];
        $this->sendMsgTemplate('kulOjNg1PT5gxUMZM6VV9GwjWCBdkw_xShlgPjzFM34', $params, 'http://ticket.wangxiaolei.cn');
    }

    /**
     * 订单分红操作
     */
    protected function cashback(){
        if( ! isset($this->order->seller->auto_cashback) || ! $this->order->seller->auto_cashback){
            $this->result_message = '订单非自动分红操作';
            return false;
        }else if($this->order->cashback_status){
            $this->result_message = '请勿重复分红操作';
            return false;
        }

        $rule = \Model_CashbackRule::find($this->order->seller->cashback_default_rule);
        if( ! $rule){
            $this->result_message = '订单分红失败,未找到分红规则';
            return false;
        }else if( ! $rule->items){
            $this->result_message = '未找到具体分红规则明细';
            return false;
        }

        $total_rate = 0;
        $rules = [];
        foreach ($rule->items as $item) {
            $rules[$item->depth] = $item->rate;
            $total_rate += $item->rate;
        }

        if($total_rate > 100){
            $this->result_message = '分红规则超出允许的最大比例!';
            return false;
        }

        //待分配金额
        $fee = $this->order->original_fee * ($rule->fee_rate / 100);

        //获取所有待分配会员列表
        $members = \Model_MemberRecommendRelation::parentMember($this->order->buyer_id);
        foreach($members as $member){
            //按各级别所得分额分配利润
            $item = \Model_OrderProfitShare::forge([
                'order_id' => $this->order->id,
                'user_id' => $member->master_id,
                'member_id' => $member->id,
                'total_fee' => $fee * ($rules[$member->depth] / 100),
            ]);
            $item->save();
        }

        $this->order->cashback_status = 1;
        return $this->order->save();
    }

    /**
     * 发送模板消息
     *
     * @param $no           订单号
     * @param $title        订单标题
     * @param $total_fee    订单金额
     * @param $url          订单链接
     * @return bool
     */
    protected function sendMsgTemplate($tmpl_id, $params, $url){
        $seller = \Session::get('seller', false);
        if( ! $seller
            || (isset($seller->is_send_template_msg) && ! $seller->is_send_template_msg)){
            $this->result_message = '商户未设置发送微信模板消息!';
            return false;
        }

        $account = \Session::get('WXAccount', false);
        $to_openid = $this->order->buyer_openid;

        $tmpl = new \handler\mp\TemplateMsg($account, $to_openid, $tmpl_id, $url);
        $result = $tmpl->send($params);
        if($result->errcode != 0){
            $this->result_message = '消息发送失败!';
            return false;
        }
        return true;
    }

    /**
     * 发送短信消息
     */
    protected function sendMsgSms(){

    }

    /**
     * 发送App通知消息
     */
    protected function sendAppSms(){

    }
}
