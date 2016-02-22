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
 * 微信接口协助类
 *
 * 微信接口控制器，主要用于处理由微信服务器发送过来的请求。
 *
 * @package  app
 * @extends  Controller
 */
namespace handler\mp;

class Tool {

    function __construct($argument)
    {
        # code...
    }

    /**
     * 检验signature
     * 检测是否来自微信服务器
     *
     * @param $signature 微信服务器传递参数
     * @param $timestamp 微信服务器传递参数
     * @param $nonce     微信服务器传递参数
     * @param $token     本地存储的token
     */
    public static function checkSignature($signature, $timestamp, $nonce, $token) {
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }



    /**
     * 生成签名
     */
    public static function getWxPaySign($params, $key) {
        $data = array();
        foreach ($params as $k => $v) {
            $data[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($data);
        $String = UrlTool::createLinkstring($data);
        //echo '【string1】'.$String.'</br>';
        //签名步骤二：在string后加入KEY
        $String = $String . "&key=" . $key;
        //echo "【string2】".$String."</br>";
        //签名步骤三：MD5加密
        $String = md5($String);
        //echo "【string3】 ".$String."</br>";
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        //echo "【result】 ".$result_."</br>";
        return $result_;
    }

    /**
     * 生成可以获得code的url
     *
     * @param $appid 公众号APPID
     * @param $redirect_uri 回调网址
     * @param $state 自定义参数
     * @param $scope 授权范围
     * @return 返回
     */
    public static function createOauthUrlForCode($appid, $redirect_uri = 'wxapi/oauth2_callback', $state = 'STATE', $scope = 'snsapi_userinfo')
    {
        if(strpos($redirect_uri, "http") === false){
            $redirect_uri = \Config::get('base_url') . $redirect_uri;
        }

        $params = array(
            'appid' => $appid,
            'redirect_uri' => urlencode($redirect_uri),
            'response_type' => 'code',
            'scope' => $scope,
            'state' => "{$state}#wechat_redirect",
        );
        ksort($params);
        reset($params);
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?" . \handler\mp\UrlTool::createLinkstring($params);
        return $url;
    }

    /**
     * 生成可以获得openid的url
     *
     * @param $appid 公众号openid
     * @param $secret 公众号secret
     * @param $code 获取粉丝open_id的code
     */
    public static function createOauthUrlForOpenid($appid, $secret, $code)
    {
        //进入支付页
        $params = array(
            'appid' => $appid,
            'secret' => $secret,
            'code' => $code,
            'grant_type' => 'authorization_code'
        );
        ksort($params);
        reset($params);
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?" . \handler\mp\UrlTool::createLinkstring($params);
        return $url;
    }

    /**
     * 生成可以获得用户信息的url
     * @param $access_token 获取用户信息的令牌
     * @param $openid 用户信息的openid
     */
    public static function createOauthUrlForUserinfo($access_token, $openid){
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
        return $url;
    }

    /**
     * 用SHA1算法生成安全签名
     * @param string $token 票据
     * @param string $timestamp 时间戳
     * @param string $nonce 随机字符串
     * @param string $encrypt 密文消息
     */
    public static function getSHA1($token, $timestamp, $nonce, $encrypt_msg)
    {
        //排序
        try {
            $array = array($encrypt_msg, $token, $timestamp, $nonce);
            sort($array, SORT_STRING);
            $str = implode($array);
            return array(ErrorCode::$OK, sha1($str));
        } catch (Exception $e) {
            //print $e . "\n";
            return array(ErrorCode::$ComputeSignatureError, null);
        }
    }

    /**
     * 提取出xml数据包中的加密消息
     * @param string $xmltext 待提取的xml字符串
     * @return string 提取出的加密消息字符串
     */
    public static function extract_xml_data($xmltext)
    {
        try {
            $xml = new \DOMDocument();
            $xml->loadXML($xmltext);
            $array_e = $xml->getElementsByTagName('Encrypt');
            $array_a = $xml->getElementsByTagName('ToUserName');
            $encrypt = $array_e->item(0)->nodeValue;
            $tousername = $array_a->item(0)->nodeValue;
            return array(0, $encrypt, $tousername);
        } catch (Exception $e) {
            //print $e . "\n";
            return array(ErrorCode::$ParseXmlError, null, null);
        }
    }

    /**
     * 生成xml消息
     * @param string $encrypt 加密后的消息密文
     * @param string $signature 安全签名
     * @param string $timestamp 时间戳
     * @param string $nonce 随机字符串
     */
    public static function generate_xml_msg($encrypt, $signature, $timestamp, $nonce)
    {
        $format = "<xml>
<Encrypt><![CDATA[%s]]></Encrypt>
<MsgSignature><![CDATA[%s]]></MsgSignature>
<TimeStamp>%s</TimeStamp>
<Nonce><![CDATA[%s]]></Nonce>
</xml>";
        return sprintf($format, $encrypt, $signature, $timestamp, $nonce);
    }

    /**
     * 根据Appid及Secret获取临时令牌
     *
     * @param $account_id Int 公众号ID，当值为0时，操作当前公众号
     * @param $grant_type String 类型
     *
     */
    public static function generate_token($appid, $appsecret, $grant_type = 'client_credential'){

        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type={$grant_type}&appid={$appid}&secret={$appsecret}";
        $result = \handler\common\UrlTool::request($url, 'GET', null, true);
        $obj = json_decode($result->body);

        if(isset($obj->errcode) && $obj->errcode > 0){
            \Log::error("app_id:{$appid};在获取临时account_token时发生异常.异常信息:{$obj->errmsg};异常代码:{$obj->errcode}");
            return false;
        }
        return ['token' => $obj->access_token, 'valid' => time() + ($obj->expires_in - 2)];
    }

    /**
     * 获取JSAPI Ticket
     * @param $access_token 公众号的access_token
     */
    public static function generate_jssdk_ticket($access_token){

        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$access_token}&type=jsapi";
        $result = \handler\common\UrlTool::request($url, 'GET', null, true);
        $obj = json_decode($result->body);

        if(isset($obj->errcode) && $obj->errcode > 0){
            \Log::error("在获取临时jsapi_ticket时发生异常.异常信息:{$obj->errmsg};异常代码:{$obj->errcode}");
            return false;
        }
        return ['ticket' => $obj->ticket, 'valid' => time() + ($obj->expires_in - 100)];
    }

    /**
     * 生成JsSdk配置
     *
     * @param $appid    公众号应用ID
     * @param $ticket   公众号JSApi ticket
     * @param $url      当前完整URL
     * @return array    返回完整配置
     */
    public static function getJssdkConfig($id = 0){
        $account = \Session::get('WXAccount', false);
        if($id){
            $account = \Model_WXAccount::find($id);
        }

        //判断ticket是否过期
        if( ! $account->wechat_ticket_valid && $account->wechat_ticket_valid < time()){
            if($account->temp_token_valid < time()){
                $result = \handler\mp\Tool::generate_token($account->app_id, $account->app_secret);
                $account->temp_token = $result['token'];
                $account->temp_token_valid = $result['valid'];
            }
            $result = \handler\mp\Tool::generate_jssdk_ticket($account->temp_token);
            $account->wechat_ticket = $result['ticket'];
            $account->wechat_ticket_valid = $result['valid'];
            $account->save();
        }
        $url = "http://" . \Input::server('HTTP_HOST') . \Input::server('REQUEST_URI');



        //参与签名的参数
        $timestamp = time();
        $params = array(
            'noncestr' => \Str::random('alnum', 16),
            'jsapi_ticket' => $account->wechat_ticket,
            'timestamp' => $timestamp,
            'url' => $url
        );
        //排序
        ksort($params);
        //生成签名
        $signature = sha1(\handler\common\UrlTool::createLinkstring($params));

        //配置文件
        $config = [
            'debug' => false,
            'appId' => $account->app_id,
            'timestamp' => $timestamp,
            'nonceStr' => $params['noncestr'],
            'signature' => $signature,
            'jsApiList' => [
                'onMenuShareTimeline', 'onMenuShareAppMessage', 'startRecord', 'stopRecord',
                'onVoiceRecordEnd', 'playVoice', 'pauseVoice', 'stopVoice', 'onVoicePlayEnd',
                'uploadVoice', 'downloadVoice', 'chooseImage', 'previewImage', 'uploadImage',
                'downloadImage', 'translateVoice', 'getNetworkType', 'openLocation', 'getLocation',
                'hideOptionMenu', 'showOptionMenu', 'hideMenuItems', 'showMenuItems', 'hideAllNonBaseMenuItem',
                'showAllNonBaseMenuItem', 'closeWindow', 'scanQRCode', 'chooseWXPay', 'openProductSpecificView',
                'addCard', 'chooseCard', 'openCard'
            ]
        ];

        return $config;
    }

    /**
     * 发起统一支付
     *
     * @param $account  微信公众号对象
     * @param $order    订单对象
     * @param $access   支付配置对象
     * @param $openid   微信Openid
     * @param string $trade_type    支付类型
     * @return bool|\handler\common\Array
     * @throws \Exception
     */
    public static function wxpay_order($account, $order, $access, $openid, $trade_type = 'JSAPI'){

        //创建支付记录
        $ip = \Input::real_ip();
        $timestamp = time();
        //创建支付单号
        $order_no = md5("{$order->order_no}{$timestamp}{$ip}");

        $data = array(
            'order_id' => $order->id,
            'return_status' => 'NONE',
            'out_trade_no' => $order_no,
            'remark' => \Input::get('remark', ''),
            'name' => \Input::get('name', ''),
            'name_stype' => \Input::get('name_style', ''),
            'real_money' => \Input::get('total_fee', $order->original_money),
            'openid' => $openid
        );
        $trade = \Model_OrderTrade::forge($data);
        if(!$trade->save()){
            \Log::error('微信支付时发生异常，原因：交易记录创建失败');
            die('trade save error!');
        }

        //是否指定收款金额
        $total_fee = $order->original_money;
        if(\Input::get('total_fee', false)){
            $total_fee = floatval(\Input::get('total_fee'));
        }

        $params = array(
            'openid' => $openid,
            'body' => $order->order_body ? $order->order_body : '',
            'out_trade_no' => $order_no,
            'total_fee' => $total_fee  * 100,
            'notify_url' => \Config::get('base_url') . 'services/gateway/notice_wxpay',
            'trade_type' => $trade_type,
            'appid' => $account->app_id,
            'mch_id' => $access->access_id,
            'nonce_str' => \Str::random('alnum', 16)
        );
        $params['sign'] = static::getWxPaySign($params, $access->access_key);

        $data = \handler\common\Tool::arrayToXml($params);
        $data = "<xml>{$data}</xml>";

        $result = \handler\common\UrlTool::request_xml('https://api.mch.weixin.qq.com/pay/unifiedorder', 'POST', $data);
        $result = \handler\common\Tool::xmlToArray($result);
        if($result['return_code'] == 'FAIL'){
            var_dump($result);
            die();
        }
        return $result;
    }
}