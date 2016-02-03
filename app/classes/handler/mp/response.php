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
 * 微信接口请求协助类
 *
 * 微信接口控制器，主要用于处理由微信服务器发送过来的请求。
 *
 * @package  app
 * @extends  Controller
 */
namespace handler\mp;

class Response {

    private $data;
    private $account;
    
    function __construct($argument)
    {
        # code...
        $this->account = $argument;
    }

    public function send(){
        $biz = new \handler\mp\WXBizMsgCrypt($this->account->token,
                                    $this->account->encoding_aes_key,
                                    $this->account->app_id);
        
        $xml = '<xml></xml>';
        $xml = "<xml><ToUserName><![CDATA[oia2Tj我是中文jewbmiOUlr6X-1crbLOvLw]]></ToUserName><FromUserName><![CDATA[gh_7f083739789a]]></FromUserName><CreateTime>1407743423</CreateTime><MsgType><![CDATA[video]]></MsgType><Video><MediaId><![CDATA[eYJ1MbwPRJtOvIEabaxHs7TX2D-HV71s79GUxqdUkjm6Gs2Ed1KF3ulAOA9H1xG0]]></MediaId><Title><![CDATA[testCallBackReplyVideo]]></Title><Description><![CDATA[testCallBackReplyVideo]]></Description></Video></xml>";
        $result = '';
        $code = $biz->encryptMsg($xml, time(), \Str::random('alnum', 16), $result);
        if( ! $code){
            die('加密后:' . $result);
        }else{
            die('加密失败:' . $code);
        }

        //$xml_tree = new \DOMDocument();
        $xmlTree = simplexml_load_string($post, 'SimpleXMLElement', LIBXML_NOCDATA);
        $xmlTree->Encrypt;
        $xmlTree->MsgSignature;
        $format = "<xml><ToUserName><![CDATA[toUser]]></ToUserName><Encrypt><![CDATA[%s]]></Encrypt></xml>";
    }
}