<?php

/**
 * 支付控制器
 * 短信通知、微信通知等通知方式
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Services_Gateway extends Controller_BaseController {

    public $template = 'template';
    private $account = false;

    public function before(){
        parent::before();
    }

    /**
     * 默认方法
     *
     * @access  public
     * @return  \Response
     */
    public function action_index() {
        die('index');
    }

    /**
     * 发起微信支付（公众号JSSDK支付）
     */
    public function action_wxpay(){
        $this->account = \Session::get('WXAccount', \Model_WXAccount::find(\Input::get('account_id', 1)));
        if( ! \Input::get('openid', false)){
            //本站域名
            $baseUrl = \Config::get('base_url');
            $request_uri = \Input::server('REQUEST_URI', '');
            if($request_uri){
                $request_uri = substr($request_uri, 1);
            }
            $toUrl = urlencode("{$baseUrl}{$request_uri}");
            $callback = "{$baseUrl}wxapi/oauth2_callback?to_url={$toUrl}";
            $url = \handler\mp\Tool::createOauthUrlForCode($this->account->app_id, $callback);
            \Response::redirect($url);
        }

        $msg = false;
        if( ! \Input::get('order_id', false)){
            $msg = ['status' => 'err', 'msg' => '缺少订单ID', 'errcode' => 0, 'title' => '错误'];
        }else if( ! $this->account){
            $msg = ['status' => 'err', 'msg' => '缺少微信公众号ID', 'errcode' => 0, 'title' => '错误'];
        }

        if($msg){
            \Session::set_flash('msg', $msg);
            return \Response::forge(\View::forge('message/moblie'));
        }

        //订单openid赋值
        $order = \Model_Order::find(\Input::get('order_id'));
        if( ! $order->buyer_openid){
            $openID = \Model_WechatOpenid::query()->where(['openid' => \Input::get('openid')])->get_one();
            if($openID->wechat->user_id == $order->buyer_id){
                $order->buyer_openid = \Input::get('openid');
                $order->save();
            }
        }

        //查询收款帐户
        $access = \Model_AccessConfig::query()
            ->where('access_type', 'wxpay')
            ->where('seller_id', $order->from_id)
            ->where('enable', 'ENABLE')
            ->get_one();

        $result = \handler\mp\Tool::wxpay_order($this->account, $order, $access, \Input::get('openid'));

        $params = array(
            'appId' => $this->account->app_id,
            'timeStamp' => strval(time()),
            'nonceStr' => \Str::random('alnum', 16),
            'package' => "prepay_id={$result['prepay_id']}",
            'signType' => "MD5"
        );

        $params['paySign'] = \handler\mp\Tool::getWxPaySign($params, $access->access_key);
        $params['to_url'] = "/order/home/delivery/{$order->id}";

        return \Response::forge(\View::forge('pay/wxpay', $params));
    }

    /**
     * 微信支付通知
     *
     */
    public function action_notice_wxpay(){

        //获取微信支付服务器提供的数据
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $result = \handler\common\Tool::xmlToArray($xml);

        //获取商户的支付配置信息
        $trade = \Model_OrderTrade::query()
            ->where('out_trade_no', $result['out_trade_no'])
            ->get_one();

        if( ! $trade){
            die('trade empty');
        }

        //订单交易对象
        $trade->response_msg = json_encode($result);
        $trade->return_trade_no = $result['transaction_id'];
        $trade->real_money = $result['total_fee'] / 100;
        $trade->updated_at = time();

        //订单对象
        $order = $trade->order;

        //支付配置
        $access = \Model_AccessConfig::query()
            ->where('access_type', 'wxpay')
            ->where('seller_id', $order->from_id)
            ->where('enable', 'ENABLE')
            ->get_one();

        //检验签名
        $tmpSign = $result;
        unset($tmpSign['sign']);
        $sign = handler\mp\Tool::getWxPaySign($tmpSign, $access->access_key);

        $params = array(
            'return_code' => 'SUCCESS'
        );
        if($result['sign'] != $sign){
            $order->order_status = 'PAYMENT_ERROR';
            $trade->return_status = 'ERROR';
            $params = array(
                'return_code' => 'FAIL',
                'return_msg' => '签名失败'
            );
        }else if($order->order_status == 'WAIT_PAYMENT'){
            $order->paid_fee += $result['total_fee'] / 100;
            $order->pay_at = time();
            if($order->paid_fee >= $order->original_money){
                $order->order_status = 'PAYMENT_SUCCESS';
            }
            $trade->return_status = 'SUCCESS';
            $trade->return_trade_no = $result['transaction_id'];
            $trade->response_msg = json_encode($result);
        }
        if($order->save() && $order->remark == 'qrcode'){
            \Model_Order::delivery($order->id);
        }
        $trade->save();

        $data = \handler\common\Tool::arrayToXml($params);
        die($data);
    }

    /**
     * 发起微信扫码支付
     *
     * 调用示例：/services/wxpay_qrcode?account_id=1&goods_id=2
     */
    public function action_wxpay_qrcode(){
        $msg = false;
        if( ! \Input::get('account_id', false) && ! \Session::get($this->SESSION_WXACCOUNT_KEY, false)){
            $msg = ['status' => 'err', 'msg' => '缺少微信公众号ID', 'errcode' => 0, 'title' => '错误'];
        }else if( ! \Input::get('goods_id', false)){
            $msg = ['status' => 'err', 'msg' => '缺少商品ID', 'errcode' => 0, 'title' => '错误'];
        }

        if($msg){
            \Session::set_flash('msg', $msg);
            return \Response::forge(\View::forge('message/moblie'));
        }

        $account = false;
        if(\Input::get('account_id', false)){
            $account = \Model_WXAccount::find(\Input::get('account_id'));
        }else{
            $account = \Session::get($this->SESSION_WXACCOUNT_KEY);
        }

        $config = \Model_AccessConfig::query()
            ->where(['seller_id' => $account->seller_id, 'access_type' => 'wxpay'])
            ->get_one();
        $params = [
            'appid' => $account->app_id,
            'mch_id' => $config->access_id,
            'product_id' => \Input::get('goods_id'),
            'time_stamp' => time(),
            'nonce_str' => \Str::random('alnum', 16),
        ];
        ksort($params);
        reset($params);
        $signStr = handler\common\UrlTool::createLinkstring($params);
        $signStr = "{$signStr}&key={$config->access_key}";
        $params['sign'] = strtoupper(md5($signStr));
        $url = "weixin://wxpay/bizpayurl?" . handler\common\UrlTool::createLinkstring($params);
        $url = urlencode($url);
        die($url);
    }
}