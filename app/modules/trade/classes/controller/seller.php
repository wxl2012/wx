<?php
/**
 * 商户控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace trade;

class Controller_Seller extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    /**
     * 收款
     */
    public function action_collection(){
        $cache = false;
        $user = \Auth::get_user();
        $seller = \Session::get('seller');
        $key = md5("collection{$seller->id}{$user->id}" . time());

        $params = [
            'pay' => false,
            'user' => $user,
            'title' => '发起收款'
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
                    'seller_id' => $seller->id,
                    'employee_id' => $user->id,
                    'total_fee' => \Input::post('total_fee', 0),
                    'payment' => \Input::post('payment', 0),
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
        $this->template->content = \View::forge("{$this->theme}/seller/collection");
    }

    /**
     * 创建支付记录
     */
    public function action_create(){
        $msg = false;
        if(! \Input::get('id', false) && \Input::get('buyer_id', false)){
            $msg = [
                'title' => '发生异常',
                'msg' => '缺少必要参数'
            ];
        }else if( ! \Auth::check()){
            $msg = [
                'title' => '发生异常',
                'msg' => '请先登录商户平台后,再次扫码!'
            ];
        }else{
            $where = ['user_id' => \Auth::get_user()->id];
            $employee = \Model_Employee::query()
                ->where($where)
                ->get_one();

            if( ! $employee){
                $msg = [
                    'title' => '无此权限',
                    'msg' => '您无权进行该项操作'
                ];
            }
        }

        if($msg){
            \Session::set_flash('msg', $msg);
            return $this->show_message();
        }

        $params = [
            'title' => '确认收款'
        ];
        if(\Input::get('id', false)){
            try{
                $cache = \Cache::get(\Input::get('id'));
            }catch(\CacheNotFoundException $e){
                $msg = [
                    'title' => '发生异常',
                    'msg' => '数据已过期'
                ];
                \Session::set_flash('msg', $msg);
                return $this->show_message();
            }
            $params['order'] = unserialize($cache);
            $params['buyer'] = \Model_User::find($params['order']['buyer_id']);
        }else if(\Input::get('buyer_id', false)){
            $params['buyer'] = \Model_User::find(\Input::get('buyer_id'));
        }
        
        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/seller/confirm_collection");
    }
}
