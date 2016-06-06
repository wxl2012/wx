<?php
/**
 * 基础控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace api;

use Fuel\Core\CacheNotFoundException;

abstract class Controller_BaseController extends \Fuel\Core\Controller_Rest {

    protected $user = false;
    protected $store = false;
    protected $wechat = false;
    protected $wechat_openid = false;
    protected $wx_account = false;
    protected $seller = false;

    public function before(){
        parent::before();
    }

    public function auth(){

        $flag = false;

        if(\Fuel::$env == \Fuel::DEVELOPMENT){
            return true;
        }
        
        if( ! \Input::get('access_token', false)){
            return $flag;
        }

        //$this->db();
        return $this->redis();
    }

    function db(){
        $token = \Model_ApiToken::query()
            ->where('token', base64_decode(\Input::get('access_token')))
            ->get_one();

        if( ! $token){
            return false;
        }else if($token->expire_at < time()){
            return false;
        }

        $data = unserialize($token->data);
        $this->user = \Model_User::find($data->user_id);
        if(\Input::param('store_id', false)){
            $this->store = \Model_Store::find(\Input::param('store_id'));
            $this->seller = $this->wx_account->seller;
        }
        if(\Input::param('wechat_id', false)){
            $this->wechat = \Model_Wechat::find(\Input::param('wechat_id'));
        }
        if(\Input::param('openid_id', false)){
            $this->store = \Model_WechatOpenid::find(\Input::param('openid_id'));
        }
        if(\Input::param('account_id', false)){
            $this->wx_account = \Model_WXAccount::find(\Input::param('account_id'));
            $this->seller = $this->wx_account->seller;
        }
        if(\Input::param('seller_id', false)){
            $this->seller = \Model_Seller::find(\Input::param('seller_id'));
        }

        //解析access_token,并查询access_token有效期
        //有效返回true否则返回false
        return $this->user ? true : false;
    }

    /**
     * redis
     * @return bool
     */
    private function redis(){

        $key = base64_decode(\Input::get('access_token'));

        $token = false;
        try {
            $token = \Cache::get($key);
        } catch (CacheNotFoundException $e){
        }

        if( ! $token){
            return false;
        }

        $data = unserialize($token);
        $this->user = \Model_User::find($data->user_id);

        if(isset($data->openid) && $data->openid){
            $this->wechat_openid = \Model_WechatOpenid::find($data->openid);
            $this->wechat = $this->wechat_openid->wechat;
            $this->wx_account = \Model_WXAccount::find($this->wechat_openid->openid);
            $this->seller = $this->wx_account->seller;
        }else if(\Input::get('account_id', false)){
            $this->wx_account = \Model_WXAccount::find(\Input::param('account_id'));
            $this->seller = $this->wx_account->seller;
        }else if(\Input::get('store_id', false)){
            $this->store = \Model_Store::find(\Input::param('store_id'));
            $this->seller = $this->store->seller;
        }else if(\Input::get('seller_id', false)){
            $this->seller = \Model_Seller::find(\Input::param('seller_id'));
        }

        return true;
    }
}
