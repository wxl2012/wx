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

	function __construct($data, $account)
	{
		$this->data = $data;
		$this->account = $account;
		$this->seller = $account->seller;
		$this->init_wechat();
	}

	/**
	 * 去重复请求
	 **/
	public function is_repeat(){

		$result = false;
		if(strtolower($this->data->MsgType) == 'event'){
			$key = "{$this->data->FromUserName}{$this->data->CreateTime}";
			$key = md5($key);
			try {
				$result = \Cache::get($key);
			} catch (\CacheNotFoundException $e) {
				\Cache::set($key, json_encode($this->data), 10);
			}
		}else if(strtolower($this->data->MsgType) == 'text'){
			$key = isset($this->data->MsgId) ? $this->data->MsgId : 0;
			$key = md5("wx{$key}");
			try {
				$result = intval(\Cache::get($key));
			} catch (\CacheNotFoundException $e) {
				//缓存记录请求消息ID
				\Cache::set($key, json_encode($this->data), 10);
			}
		}

		if($result > 0){
			die('success');
		}
	}

	/**
	 * 初始化微信粉丝帐户
	 *
	 */
	public function init_wechat(){

		if( ! isset($this->account->is_create_openid) || ! $this->account->is_create_openid){
			return true;
		}

		$openid = \Model_WechatOpenid::getItem($this->data->FromUserName);
		if( ! $openid){
			$openid = \handler\mp\Account::createWechatAccount($this->data->FromUserName, $this->account);
		}

		if(isset($openid->wechat)){
			$this->wechat = $openid->wechat;
		}

		if( $this->wechat && (! $this->wechat->nickname || ! $this->wechat->headimgurl)){
			$wechatInfo = \handler\mp\Wechat::getWechatInfo($this->account->temp_token, $openid->openid);
			if($wechatInfo === false){
				\Log::error('未获取到微信详细信息');
				return false;
			}

			if(isset($wechatInfo->nickname)){
				$this->wechat->set([
					'nickname' => $wechatInfo->nickname,
					'sex' => $wechatInfo->sex,
					'city' => $wechatInfo->city,
					'province' => $wechatInfo->province,
					'country' => $wechatInfo->country,
					'headimgurl' => $wechatInfo->headimgurl,
					'subscribe_time' => $wechatInfo->subscribe_time,
				]);
				if($this->wechat->save()){
					//将头像下载至本地
					\handler\mp\Wechat::getWechatHeadImage($this->wechat->headimgurl);
				}
			}
		}

	}

	/**
	 * 记录本次请求数据
	 *
	 */
	public function write_record(){

		if( ! isset($this->account->is_record_request) || ! $this->account->is_record_request){
			return true;
		}

		$msg_content = isset($this->data->Content) ? $this->data->Content : '';

		if(strtolower($this->data->MsgType) == 'image'){
			$msg_content = json_encode(['MediaId' => $this->data->MediaId, 'MsgId' => $this->data->MsgId, 'PicUrl' => $this->data->PicUrl]);
		}else if(strtolower($this->data->MsgType) == 'event' && isset($this->data->EventKey)){
			switch ($this->data->Event){
				case 'LOCATION':
					$msg_content = json_encode(['Latitude' => $this->data->Latitude, 'Longitude' => $this->data->Longitude, 'Precision' => $this->data->Precision]);
					break;
				case 'CLICK':
					$msg_content = $this->data->EventKey;
					break;
				case 'VIEW':
					$msg_content = $this->data->EventKey;
					break;
				case 'subscribe':
					$msg_content = isset($this->data->EventKey) ? "【未关注情况下挚友】扫码关注:{$this->data->EventKey},Ticket:{$this->data->Ticket}" : '';
					break;
				case 'unsubscribe':
					$msg_content = "取消关注";
					break;
				case 'SCAN':
					$msg_content = isset($this->data->EventKey) ? "【关注情况下扫码】扫码关注:{$this->data->EventKey},Ticket:{$this->data->Ticket}" : '';
					break;

			}
		}else if(strtolower($this->data->MsgType) == 'voice'){
			$msg_content = json_encode(['MediaId' => $this->data->MediaId, 'Format' => $this->data->Format]);
		}else if(strtolower($this->data->MsgType) == 'video'){
			$msg_content = json_encode(['MediaId' => $this->data->MediaId, 'ThumbMediaId' => $this->data->ThumbMediaId]);
		}else if(strtolower($this->data->MsgType) == 'shortvideo'){
			$msg_content = json_encode(['MediaId' => $this->data->MediaId, 'ThumbMediaId' => $this->data->ThumbMediaId]);
		}else if(strtolower($this->data->MsgType) == 'location'){
			$msg_content = json_encode(['Location_X' => $this->data->Location_X,
				'Location_Y' => $this->data->Location_Y,
				'Scale' => $this->data->Scale,
				'Label' => $this->data->Label]);
		}else if(strtolower($this->data->MsgType) == 'link'){
			$msg_content = json_encode(['Title' => $this->data->Title, 'Description' => $this->data->Description, 'Url' => $this->data->Url]);
		}

		$request = \Model_WXRequest::forge(
			array(
				'from_id' => $this->data->FromUserName,
				'to_id' => $this->account->id,
				'msg_id' => isset($this->data->MsgId) ? $this->data->MsgId : 0,
				'msg_type' => $this->data->MsgType,
				'event' => strtolower($this->data->MsgType) == 'event' ? strtoupper($this->data->Event) : 'NONE',
				'msg_content' => $msg_content,
				'status' => 'NONE',
				'msg_created_at' => isset($this->data->CreateTime) ? $this->data->CreateTime : 0,
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
			default:
				die('success');
				break;
		}
		$handle->setWechat($this->wechat);
		$handle->setAccount($this->account);
		$handle->setPostData($this->data);
		$handle->setSeller($this->seller);
		$handle->handle();
	}
}