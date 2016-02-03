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


}