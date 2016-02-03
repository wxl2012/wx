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
 * 处理微信各项请求
 *
 * @package  app
 * @extends  Controller
 */
namespace handler\mp;

class Request {

	private $data;
	private $account;
	private $wechat;
	private $seller;
    
    function __construct($argument)
    {
    	$this->data = $argument;
    	$this->account = \Session::get('WXAccount');
    	$this->seller = \Session::get('seller');
    	$this->init_wechat();
    	$this->write_record();
    }

    /**
    * 初始化微信粉丝帐户
    *
    */
    public function init_wechat(){
    	$openid = \Model_WechatOpenid::getItem($this->data->FromUserName);
    	if( ! $openid){
    		$openid = \handler\mp\Account::createWechatAccount($this->data->FromUserName, $this->account);
    	}

    	$this->wechat = $openid->wechat;
    }

    /**
    * 记录本次请求数据
    *
    */
    public function write_record(){
    	$msg_content = isset($this->data->Content) ? $this->data->Content : '';
		if(strtolower($this->data->MsgType) == 'image'){
			$msg_content = json_encode(array('MediaId' => $this->data->MediaId, 'MsgId' => $this->data->MsgId));
		}else if(strtolower($this->data->MsgType) == 'event' && isset($this->data->EventKey)){
			$msg_content = $this->data->EventKey;
		}
		$request = \Model_WXRequest::forge(
			array(
				'wechat_id' => $this->wechat->id,
				'to_id' => $this->account->id,
				'msg_id' => isset($this->data->MsgId) ? $this->data->MsgId : 0,
				'msg_type' => $this->data->MsgType,
				'event' => strtolower($this->data->MsgType) == 'event' ? strtoupper($this->data->Event) : 'NONE',
				'msg_content' => $msg_content,
				'status' => 'NONE',
			)
		);
		$request->save();
    }

    public function handle(){

    }


}