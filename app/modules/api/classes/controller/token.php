<?php
/**
 * Token控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace api;

class Controller_Token extends \Fuel\Core\Controller_Rest {

    public function before(){
        parent::before();
    }

    public function auth(){
        return true;
    }

    /**
     * 获取token
     */
    public function action_index(){

        $data = ['status' => 'err', 'msg' => '缺少必要参数', 'errcode' => 90001];

        $user_id = \Input::get('user_id', false);
        $wechat_id = \Input::get('wechat_id', false);
        $open_id = \Input::get('open_id', false);
        $store_id = \Input::get('store_id', false);
        $wx_account_id = \Input::get('wx_account_id', false);

        if(! $user_id || ! $wechat_id || ! $open_id || ! $store_id || ! $wx_account_id){
            return $this->response($data, 403);
        }

        $user = false;
        $wechat = false;
        $openid = false;
        $store = false;
        $account = false;

        if($user_id){
            $user = \Model_User::find($user_id);
        }
        if($wechat_id){
            $wechat = \Model_Wechat::find($wechat_id);
        }
        if($open_id){
            $openid = \Model_WechatOpenid::find($open_id);
        }
        if($store_id){
            $store = \Model_Store::find($store_id);
        }
        if($wx_account_id){
            $account = \Model_WXAccount::find($wx_account_id);
        }

        if(! $user || ! $wechat || ! $openid || ! $store || ! $account){
            return $this->response($data, 403);
        }

        $params = [
            'user_id' => $user_id,
            'store_id' => $store_id,
            'wechat_id' => $wechat_id,
            'openid_id' => $open_id,
            'wx_account_id' => $wx_account_id,
        ];

        $token = \Model_ApiToken::forge([
            'token' => md5("{$user_id}{$wechat_id}{$open_id}{$store_id}{$wx_account_id}" . time()),
            'expire_at' => time() + 7200,
            'data' => serialize((object)$params)
        ]);
        $token->save();

        $data = ['status' => 'succ', 'msg' => 'ok', 'errcode' => 0, 'expires_in' => 7200, 'access_token' => base64_encode($token->token)];
        $this->response($data, 200);
    }
}
