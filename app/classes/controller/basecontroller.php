<?php
/**
 *
 * @package    Fuel
 * @version    1.7
 * @author     王晓雷 zyr.wxl@gmail.com
 * @license    MIT License
 * @copyright  2015 PMonkey Team
 * @link       http://mnzone.cn
 */

/**
 * 基础控制器
 *
 * 主要用于实现必要公共功能
 *
 * @package  app
 * @extends  Controller
 */
abstract class Controller_BaseController extends \Fuel\Core\Controller_Template
{
	public $template = 'template';
	protected $SESSION_WXACCOUNT_KEY = 'WXAccount';
	protected $SESSION_SELLER_KEY = 'seller';
	protected $SESSION_WECHAT_KEY = 'wechat';
	protected $result_message = false;

	public function before(){
		parent::before();

		$client_type = false;

		$ua = \Input::user_agent();

		if(preg_match('/MicroMessenger/i', $ua)){
			//加载微信公众号信息
			$this->load_wx_account();
			//加载微信粉丝OPENID信息
			$this->load_wechat();

			$client_type = 'wechat';
		}else{
			$this->load_seller();
		}

		$this->getToken();

		\View::set_global(['client_type' => $client_type]);
	}

	/**
	 * 加载微信公众号
	 */
	protected function load_wx_account(){
		if( ! \Input::get('account_id', false)){
			return;
		}
		$account = \Session::get($this->SESSION_WXACCOUNT_KEY, false);
		if($account && $account->id == \Input::get('account_id')){
			return;
		}

		$account = \Model_WXAccount::find(\Input::get('account_id'));
		\Session::set($this->SESSION_WXACCOUNT_KEY, $account);
		$this->load_seller($account->seller_id);
	}

	/**
	 * 加载商户信息
	 */
	protected function load_seller($id = 0){
		if(! $id && ! \Input::get('seller_id', false)){
			return;
		}else if(\Input::get('seller_id', false)){
			$id = \Input::get('seller_id');
		}
		$seller = \Session::get($this->SESSION_SELLER_KEY, false);
		if($seller && $seller->id == $id){
			return;
		}

		$seller = \Model_Seller::find($id);
		\Session::set($this->SESSION_SELLER_KEY, $seller);
	}

	/**
	 * 加载微信信息
	 */
	protected function load_wechat(){

		//是否需要获取openid
		$flag = $this->getNotOpenidAllowed();
		if($flag){
			return;
		}

		if(! \Session::get('wechat', false) && ! \Input::get('openid', false)){
			//获取到openid之后跳转的参数列表
			//$params = \handler\mp\UrlTool::createLinkstring(\Input::get());
			//本站域名
			$baseUrl = \Config::get('base_url');
			$url = $baseUrl . \Input::server('REQUEST_URI');
			$toUrl = urlencode($url);
			$callback = "{$baseUrl}wxapi/oauth2_callback?to_url={$toUrl}";
			$account = \Session::get('WXAccount', \Model_WXAccount::find(1));
			$url = \handler\mp\Tool::createOauthUrlForCode($account->app_id, $callback);
			\Response::redirect($url);
		}else if( ! \Session::get('wechat', false)){
			$wxopenid = \Model_WechatOpenid::query()
				->where(['openid' => \Input::get('openid')])
				->get_one();
			if( ! $wxopenid){
				\Session::set_flash('msg', ['status' => 'err', 'msg' => '未找到您的微信信息,无法确认您的身份! 系统无法为您提供服务!', 'title' => '拒绝服务']);
				return $this->show_mesage();
			}
			\Session::set('wechat', $wxopenid->wechat);
			\Session::set('OpenID', $wxopenid);
			$employee = \Model_Employee::query()
				->where('user_id', $wxopenid->wechat->user_id)
				->get_one();
			if($employee){
				\Session::set('employee', $employee);
			}
			\Auth::force_login($wxopenid->wechat->user_id);
		}else if( ! \Auth::check() && \Session::get('wechat')->user_id){
			\Auth::force_login(\Session::get('wechat')->user_id);
		}
	}
	
	/**
	 * 检测用户是否登录
	 *
	 * @param bool $url
	 * @return bool
	 */
	protected function checkLogin($url = false){

		if(\Auth::check()){
			return true;
		}

		if($this->getNotOpenidAllowed()){
			return true;
		}

		if($url){
			\Response::redirect($url);
		}else{
			$url = \Uri::current();
			$params = \Uri::build_query_string(\Input::get());
			\Response::redirect("/ucenter/login?to_url={$url}?{$params}");
		}

	}

	/**
	 * 显示提示信息
	 *
	 * @return mixed
	 */
	protected function show_message(){
		return \Response::forge(\View::forge('message/moblie'));
	}

	/**
	 * 允许没有openid下的访问列表
	 *
	 * @return array
	 */
	protected function getNotOpenidAllowed(){
		$allowed = [
			[
				'module' => 'order',
				'controller' => 'home',
				'actions' => ['save_wxpay_qrcode']
			],
			[
				'module' => 'wxapi',
				'controller' => 'oauth2_callback',
				'actions' => []
			],
			[
				'module' => 'ucenter',
				'controller' => 'login',
				'actions' => []
			],
			[
				'module' => 'marketing',
				'controller' => 'vote',
				'actions' => ['rank']
			],
			[
				'module' => 'admin',
				'controller' => 'login',
				'actions' => []
			]
		];

		foreach($allowed as $item){
			if(( ! $item['module'] || $item['module'] == \Uri::segment(1, ''))
				&& ( ! $item['controller'] || $item['controller'] == \Uri::segment(2, ''))
				&& ( ! $item['actions'] || in_array(\Uri::segment(3, ''), $item['actions']))){
				return true;
			}
		}
		return false;
	}

	/**
	 * 获取Token
	 */
	protected function getToken(){
		\View::set_global(['token' => 'MGE3MTYyYjIzODYzNjY5NDRiYzE2NTUwM2U2ZGQ5ODI=']);
	}
}
