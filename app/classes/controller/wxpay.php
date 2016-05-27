<?php
/**
 * 基于FuelPHP的微信第三方程序库
 *
 * @package    Fuel
 * @version    1.7
 * @author     Ray zyr.wxl@gmail.com
 * @license    MIT License
 * @copyright  2015 PMonkey Team
 * @link       http://mnzone.cn
 */

/**
 * 微信支付控制器
 *
 * 主要实现红包发放功能
 *
 * @package  app
 * @extends  Controller
 */
class Controller_WXPay extends Controller_BaseController
{
	public function before(){
    	parent::before();
    }

    /**
     * 发起微信扫码支付
     *
     * 调用示例：/wxpay/wxpay_qrcode?account_id=1&goods_id=2
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
            return $this->show_message();
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

        $msg = ['status' => 'succ', 'msg' => '', 'errcode' => 0, 'data' => $url];
        if(\Input::is_ajax()){
            die(json_encode($msg));
        }
        die("<img src='/common/image/qr?outtype=browser&content={$url}' alt=''>");
    }

    /**
     * 扫码支付回调
     */
    public function action_qrcode_order(){
        $post = $GLOBALS['HTTP_RAW_POST_DATA'];
        $data = false;
        try{
            $data = simplexml_load_string($post, 'SimpleXMLElement', LIBXML_NOCDATA);
        }catch(Exception $e){
            \Log::error('/wxpay/qrcode_order解析HTTP_RAW_POST_DATA数据时，发生异常：' . $e->getMessage());
            die('系统繁忙，请重试!');
        }

        if( ! $data){
            die();
        }
        //查微信帐户
        $openid = false;
        if($data->is_subscribe == 'Y'){
            $openid = \Model_WechatOpenid::query()->where(['openid' => $data->openid])->get_one();
        }

        //查询公众号
        $account = \Model_WXAccount::query()
            ->where('app_id', $data->appid)
            ->get_one();

        //查询商品
        $goods = \Model_Goods::find($data->product_id);
        //创建订单
        $order = \Model_Order::forge([
            'order_no' => \Model_Order::get_order_on(),
            'order_name' => $goods->name,
            'order_body' => $goods->title,
            'total_fee' => $goods->price,
            'original_fee' => $goods->sale_price,
            'from_id' => $account->seller_id,
            'buyer_id' => $openid ? $openid->wechat->user_id : 0,
            'buyer_openid' => $openid ? $openid->openid :  $data->openid,
            'order_status' => 'WAIT_PAYMENT',
            'order_type' => 'SELL',
            'payment_type' => 'wxpay',
            'remark' => 'qrcode'
        ]);
        $order->details = [
            \Model_OrderDetail::forge([
                'goods_id' => $goods->id,
                'price' => $goods->sale_price,
                'num' => 1
            ])
        ];
        $order->save();

        //查询收款帐户
        $access = \Model_AccessConfig::query()
            ->where(['seller_id' => $account->seller_id, 'access_type' => 'wxpay', 'enable' => 'ENABLE'])
            ->get_one();

        $result = \handler\mp\Tool::wxpay_order($account, $order, $access, $data->openid, 'NATIVE');
        $data = \handler\common\Tool::arrayToXml($result);
        $data = "<xml>{$data}</xml>";
        die($data);
    }

    /**
     * 微信支付结果回调
     * @throws Exception
     */
    public function action_notice(){
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
            if($order->paid_fee >= $order->original_fee){
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
     * 发起微信支付
     *
     * @return mixed
     */
    public function action_index(){

        $msg = false;

        if( ! \Input::get('account_id', false) && ! \Session::get('WXAccount', false)){
            $msg = ['status' => 'err', 'msg' => '无效的公众号', 'errcode' => 10, 'title' => '错误'];
        }else if(! \Input::get('openid', false) && ! \Session::get('OpenID', false)){
            $msg = ['status' => 'err', 'msg' => '无效的微信号', 'errcode' => 20, 'title' => '错误'];
        }else if( ! \Input::get('order_id', false)) {
            $msg = ['status' => 'err', 'msg' => '缺少必要参数:订单ID', 'errcode' => 30, 'title' => '错误'];
        }

        if($msg){
            if(\Input::is_ajax()){
                die(json_encode($msg));
            }
            \Session::set_flash('msg', $msg);
            return \Response::forge(\View::forge('message/moblie'));
        }

        $account = \Session::get('WXAccount', \Model_WXAccount::find(\Input::get('account_id', 1)));
        $openid = \Input::get('openid', false) ? \Input::get('openid') :  \Session::get('OpenID', false)->openid;
        $order = \Model_Order::find(\Input::get('order_id'));

        //查询收款帐户
        $access = \Model_AccessConfig::query()
            ->where('access_type', 'wxpay')
            ->where('seller_id', $order->from_id)
            ->where('enable', 'ENABLE')
            ->get_one();

        $result = \handler\mp\Tool::wxpay_order($account, $order, $access, $openid);

        $params = array(
            'appId' => $account->app_id,
            'timeStamp' => strval(time()),
            'nonceStr' => \Str::random('alnum', 16),
            'package' => "prepay_id={$result['prepay_id']}",
            'signType' => "MD5"
        );

        $params['paySign'] = \handler\mp\Tool::getWxPaySign($params, $access->access_key);
        $params['to_url'] = "/order/pay_status/{$order->id}";

        if(\Input::is_ajax()){
            die(json_encode(['status' => 'succ', 'msg' => '', 'errcode' => 0, 'data' => $params]));
        }

        return \Response::forge(\View::forge('pay/wxpay', $params));
    }
}
