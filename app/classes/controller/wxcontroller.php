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
 * 微信手机端基础控制器
 *
 * 主要用于实现必要公共功能
 *
 * @package  app
 * @extends  Controller
 */
class Controller_WXController extends Controller_BaseController
{

	public function before(){
		parent::before();
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
			\Auth::force_login($wxopenid->wechat->user_id);
		}else if( ! \Auth::check() && \Session::get('wechat')->user_id){
			\Auth::force_login(\Session::get('wechat')->user_id);
		}
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
			]
		];
		foreach($allowed as $item){
			if($item['module'] == \Uri::segment(1)
				&& in_array(\Uri::segment(2), $item['actions'])){
				return true;
			}else if($item['module'] == \Uri::segment(1)
				&& $item['controller'] == \Uri::segment(2)
				&& in_array(\Uri::segment(3), $item['actions'])){
				return true;
			}
		}
		return false;
	}
}
