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

    public function send($xml){
        $biz = new \handler\mp\WXBizMsgCrypt($this->account->token,
                                    $this->account->encoding_aes_key,
                                    $this->account->app_id);
        $result = '';
        $code = $biz->encryptMsg($xml, time(), \Str::random('alnum', 16), $result);
        if($code){
            die('加密失败:' . $code);
        }

        die($result);
    }

    public function text(){
        $textTpl = "<xml>
						<ToUserName><![CDATA[{$this->data->FromUserName}]]></ToUserName>
						<FromUserName><![CDATA[{$this->data->ToUserName}]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[text]]></MsgType>
						<Content><![CDATA[]]></Content>
						<FuncFlag>0</FuncFlag>
					</xml>";
        $resultStr = sprintf($textTpl, time());
        if($this->account->msg_method == 'encrypt'){
            $this->send($resultStr);
        }
        die($resultStr);
    }
}