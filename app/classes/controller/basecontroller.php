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

	public function before(){
		parent::before();

		$this->load_wx_account();

		$this->load_seller();
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

	protected function show_mesage(){
		return \Response::forge(\View::forge('message/moblie'));
	}
}
