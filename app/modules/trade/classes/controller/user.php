<?php
/**
 * 用户控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace trade;

class Controller_User extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    /**
     * 加载预创建支付页
     */
    public function action_index(){}

    /**
     * 发起付款
     */
    public function action_pay(){

        $cache = false;
        $user = \Auth::get_user();
        $openid = \Session::get('OpenID', false);
        $key = md5("pay{$user->id}-" . ($openid ? $openid->openid : ''));

        $params = [
            'pay' => false,
            'user' => $user
        ];

        try{
            $cache = \Cache::get($key);
            $params['pay'] = unserialize($cache);
            $params['key'] = $key;
        }catch(\CacheNotFoundException $e){
        }

        if(\Input::method() == 'POST'){
            if( ! $cache){
                $wechat = \Session::get('wechat');
                $data = [
                    'buyer_id' => $user->id,
                    'wechat_id' => $wechat->id,
                    'openid' => $openid->openid,
                    'total_fee' => \Input::post('total_fee', 0),
                    'remark' => \Input::post('remark', ''),
                    'created_at' => time()
                ];
                \Cache::set(md5($key), serialize($data), 60 * 30);
                $cache = \Cache::get(md5($key));
            }

            $data = unserialize($cache);
            die(json_encode(['status' => 'succ', 'msg' => '', 'data' => $data, 'key' => md5($key)]));
        }

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/user/pay");
    }

    public function action_create(){

        $msg = false;
        if(! \Input::get('id', false)){
            $msg = [
                'title' => '发生异常',
                'msg' => '缺少必要参数'
            ];
        }else if( ! \Auth::check()){
            $msg = [
                'title' => '发生异常',
                'msg' => '请先登录商户平台后,再次扫码!'
            ];
        }

        if($msg){
            \Session::set_flash('msg', $msg);
            return $this->show_message();
        }

        $params = [
            'title' => '确认付款'
        ];

        try{
            $item = \Cache::get(\Input::get('id'));
            $params['item'] = unserialize($item);
            $params['seller'] = \Model_Seller::find($params['item']['seller_id']);
        }catch(\CacheNotFoundException $e){
        }

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/user/confirm_pay");
    }
}
