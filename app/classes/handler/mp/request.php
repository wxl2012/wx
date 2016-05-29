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
	}

	/**
	 * 去重复请求
	 **/
	public function is_repeat(){
		$count = 0;
		if(strtolower($this->data->MsgType) == 'event'){
			$count = \Model_WXRequest::query()
				->where([
					'from_id' => $this->data->FromUserName,
					'msg_created_at' => $this->data->CreateTime,
				])
				->count();
		}else{
			try {
				$key = isset($this->data->MsgId) ? $this->data->MsgId : 0;
				$count = intval(\Cache::get(md5("wx{$key}")));
				$count ++;
			} catch (\CacheNotFoundException $e) {
			}
		}

		if($count > 0){
			\handler\mp\Wechat::getWechatHeadImage($this->wechat->headimgurl);
			die('success');
		}
	}

	/**
	 * 初始化微信粉丝帐户
	 *
	 */
	public function init_wechat(){
		$openid = \Model_WechatOpenid::getItem($this->data->FromUserName);
		if( ! $openid){
			$this->account->checkToken();
			$openid = \handler\mp\Account::createWechatAccount($this->data->FromUserName, $this->account);
		}

		$this->wechat = $openid->wechat;
		if( ! $this->wechat->nickname || ! $this->wechat->headimgurl){
			$wechatInfo = \handler\mp\Wechat::getWechatInfo($this->account->temp_token, $openid->openid);
			if( ! $wechatInfo){
				return false;
			}
			$this->wechat->set([
				'nickname' => $wechatInfo->nickname,
				'sex' => $wechatInfo->sex,
				'city' => $wechatInfo->city,
				'province' => $wechatInfo->province,
				'country' => $wechatInfo->country,
				'headimgurl' => $wechatInfo->headimgurl,
				'subscribe_time' => $wechatInfo->subscribe_time,
			]);
			$this->wechat->save();
		}
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

		//缓存记录请求消息ID
		$key = isset($this->data->MsgId) ? $this->data->MsgId : 0;
		\Cache::set(md5("wx{$key}"), '0', 15);

		$request = \Model_WXRequest::forge(
			array(
				'from_id' => $this->data->FromUserName,
				'to_id' => $this->account->id,
				'msg_id' => isset($this->data->MsgId) ? $this->data->MsgId : 0,
				'msg_type' => $this->data->MsgType,
				'event' => strtolower($this->data->MsgType) == 'event' ? strtoupper($this->data->Event) : 'NONE',
				'msg_content' => $msg_content,
				'status' => 'NONE',
				'msg_created_at' => $this->data->CreateTime,
			)
		);
		$request->save();
	}

	/**
	 * 处理请求
	 */
	public function handle(){
		$handle = false;
		switch ($this->data->MsgType) {
			case 'text':
				$handle = new \handler\mp\action\Text();
				break;
			case 'event':
				$handle = new \handler\mp\action\Event();
				break;
			case 'voice':
				$handle = new \handler\mp\action\Voice();
				break;
			case 'image':
				$handle = new \handler\mp\action\Image();
				break;
			case 'video':
				$handle = new \handler\mp\action\Video();
				break;
			case 'location':
				$handle = new \handler\mp\action\Location();
				break;
		}
		$handle->setWechat($this->wechat);
		$handle->setAccount($this->account);
		$handle->setPostData($this->data);
		$handle->setSeller($this->seller);
		$handle->handle();
	}
}