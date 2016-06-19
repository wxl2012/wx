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
 * 微信推送请求处理控制器.
 *
 * 微信接口控制器，主要用于处理由微信服务器发送过来的请求。
 *
 * @package  app
 * @extends  Controller
 */
class Controller_WXApi extends Controller_BaseController
{
	private $account = false;

	/**
	 * 默认方法
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
		die('');
	}

	/**
	 * 处理微信服务器推送的请求
	 *
	 */
	public function action_action($appid = false){

		if(! $appid){
			die(json_decode(['status' => 'err', 'msg' => '非法请求', 'errcode' => 2010]));
		}

		//获取微信公众号信息
		$key = "wx_account_{$appid}";

		try{
			$account = \Cache::get($key);
			$this->account = unserialize($account);
		}catch (\CacheNotFoundException $e){
			if(is_numeric($appid)){
				$this->account = \Model_WXAccount::find($appid);
			}else if(is_string($appid)){
				$this->account = \Model_WXAccount::query()
					->where('app_id', $appid)
					->get_one();
			}
			$this->account->seller;
			\Cache::set($key, serialize($this->account));
		}


		if( ! $this->account){
			die(json_decode(['status' => 'err', 'msg' => '该公众号不存在', 'errcode' => 2011]));
		}

		//检验消息合法性
		if( ! \handler\mp\Tool::checkSignature(\Input::get('signature', false), \Input::get('timestamp', false), \Input::get('nonce', false), $this->account->token)){
			\Log::error('WXApi.php check signature error!');
			die('success');
		}

		//接入请求
		if(\Input::get('echostr', false)){
			if($this->account->status != 'NONE'){
				\Log::error('account status error');
				die('success');
			}else{
				die(\Input::get('echostr'));
			}
		}

		$this->handler();
	}

	/**
	 * 网页授权获取用户基本信息回调处理方法
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_oauth2_callback()
	{
		$params = \Input::get();

		if(! \Input::get('code', false)){
			\Session::set_flash('msg', ['status' => 'err', 'msg' => '你拒绝授权，系统无法确认您的身份！系统中止！', 'title' => '错误']);
			return $this->show_message();
		}

		$this->account = \Session::get('WXAccount', \Model_WXAccount::find(1));
		$url = handler\mp\Tool::createOauthUrlForOpenid($this->account->app_id, $this->account->app_secret, $params['code']);
		$result = \handler\common\UrlTool::request($url, 'GET', null, true);
		$result = json_decode($result->body);
		if( ! isset($result->openid) || ! $result->openid){
			\Session::set_flash('msg', ['status' => 'err', 'msg' => '未获取到OpenId!', 'title' => '错误']);
			return $this->show_message();
		}

		//跳转参数加openid
		$to_url = \Input::get('to_url', '/');
		$addspan = strpos($to_url, '?') !== false ? '&' : '?';
		$to_url = "{$to_url}{$addspan}openid={$result->openid}";

		//获取openid对象
		$wechatOpenID = \Model_WechatOpenid::query()
			->where(['openid' => $result->openid])
			->get_one();

		//openid存在,不需要创建
		if($wechatOpenID && $wechatOpenID->wechat->nickname && $wechatOpenID->wechat->headimgurl){
			\Response::redirect($to_url);
			return;
		}

		//拉取用户信息
		$url = handler\mp\Tool::createOauthUrlForUserinfo($result->access_token, $result->openid);
		$result = \handler\common\UrlTool::request($url, 'GET', null, true);
		$result = json_decode($result->body);
		if(isset($result->errcode)){
			\Session::set_flash('msg', ['status' => 'err', 'msg' => $result->errmsg, 'title' => '错误']);
			return $this->show_message();
		}


		//查询微信用户信息是否存在
		$wechat = \Model_Wechat::query()
			->where([
				'nickname' => $result->openid
			])
			->or_where_open()
			->where([
				'nickname' => $result->nickname,
				'sex' => $result->sex,
				'city' => $result->city,
				'province' => $result->province,
				'country' => $result->country,
				'headimgurl' => $result->headimgurl
			])
			->or_where_close()
			->get_one();

		if($wechat && ! $wechatOpenID) {
			$wechatOpenID = \Model_WechatOpenid::forge([
				'openid' => $result->openid,
				'account_id' => $this->account->id,
				'wechat_id' => $wechat->id,
			]);
			$wechatOpenID->save();
		}else if(! $wechat && ! $wechatOpenID){
			//创建openid数据及微信信息
			$wechatOpenID = handler\mp\Account::createWechatAccount($result->openid, $this->account);
			if(! $wechatOpenID){
				\Session::set_flash('msg', ['status' => 'err', 'msg' => '微信信息保存失败! 缺少必要信息,系统终止!', 'title' => '错误']);
				return $this->show_message();
			}
		}

		$wechat = $wechatOpenID->wechat;
		# 保存拉取到的用户信息
		$wechat->nickname = $result->nickname;
		$wechat->sex = $result->sex;
		$wechat->city = $result->city;
		$wechat->province = $result->province;
		$wechat->country = $result->country;
		$wechat->headimgurl = $result->headimgurl;
		$wechat->language = isset($result->language) ? $result->language : '';
		$wechat->subscribe_time = isset($result->subscribe_time) ? $result->subscribe_time : 0;
		$wechat->subscribe = isset($result->subscribe) ? $result->subscribe : 0;
		$wechat->save();
		\Response::redirect($to_url);
	}

	/**
	 * 网页授权获取用户基本信息回调处理方法(指定认证服务公众号)
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_oauth2_callback_fixed(){
		\Config::load('mp');
		$account = \Config::get('account');
		echo $account['OpenID'];
	}

	/**
	 * 处理微信推送的请求
	 *
	 * @access  private
	 * @return  void
	 */
	private function handler()
	{
		$post = $GLOBALS['HTTP_RAW_POST_DATA'];

		if(! $post){
			\Log::error("未能识别请求数据(未获取到HTTP_RAW_POST_DATA)");
			die();
		}

		$data = [];
		try{
			$data = simplexml_load_string($post, 'SimpleXMLElement', LIBXML_NOCDATA);
		}catch(Exception $e){
			\Log::error('解析HTTP_RAW_POST_DATA数据时，发生异常：' . $e->getMessage());
			die('系统繁忙，请重试!');
		}

		if(isset($this->account->encoding_aes_key) && $this->account->encoding_aes_key){
			$biz = new \handler\mp\WXBizMsgCrypt($this->account->token,
				$this->account->encoding_aes_key,
				$this->account->app_id);
			$code = $biz->decryptMsg(\Input::get('msg_signature', false), \Input::get('timestamp', false), \Input::get('nonce', false), $post, $data);
			if(\handler\mp\ErrorCode::$OK != $code){
				\Log::error('解密消息时失败:' . $code);
				die();
			}
			$data = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
		}

		$request = new \handler\mp\Request($data, $this->account);
		$request->is_repeat();
		$request->write_record();
		$request->handle();
	}
}
