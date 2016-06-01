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

namespace ucenter;

class Controller_User extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    public function action_index(){

        if(\Input::method() == 'POST'){
            $data = \Input::post();
        }

        $params = [
            'title' => '我的资料'
        ];

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/user/index");
    }

    /**
     * 初始化注册资料
     * 
     * @return mixed
     * @throws \Exception
     * @throws \FuelException
     */
    public function action_init(){

        $params = [
            'title' => '注册资料'
        ];

        $people = \Model_People::query()
            ->where('parent_id', \Auth::get_user()->id)
            ->get_one();

        if($people->phone){
            \Session::set_flash('msg', ['status' => 'err', 'msg' => '您已注册过帐户! 请勿重复注册!', 'title' => '温馨提示']);
            return $this->show_message();
        }

        if(\Input::method() == 'POST'){
            $msg = ['status' => 'err', 'msg' => '', 'errcode' => 10];
            $data = \Input::post();

            $this->change_user();

            if($data['birthday']){
                $data['birthday'] = strtotime($data['birthday']);
            }

            $people->set($data);
            if($people->save()){
                $msg = ['status' => 'succ', 'msg' => '', 'errcode' => 0];
            }

            if(\Input::is_ajax()){
                die(json_encode($msg));
            }
        }

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/user/init");
    }

    /**
     * 绑定微信
     */
    public function action_bind(){

        if(\Input::method() == 'POST'){
            $data = \Input::post();

        }

        $params = [
            'title' => '绑定微信'
        ];

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/user/bind");
    }

    /**
     * 修改密码
     */
    public function action_change_pwd(){

        if(\Input::method() == 'POST'){
            $data = \Input::post();

        }

        $params = [
            'title' => '修改密码'
        ];

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/user/change_pwd");
    }

    /**
     * 我的推荐二维码
     */
    public function action_qrcode(){
        $params = [
            'title' => '我的专属推广二维码'
        ];

        $people = \Session::get('people', false);

        if( ! $people){
            \Session::set_flash('msg', ['status' => 'err', 'msg' => '未找到用户扩展信息', 'title' => '错误信息', 'errcode' => 10]);
            return $this->show_message();
        }
        
        if( ! isset($people->qr_subscribe_ticket) || ! $people->qr_subscribe_ticket){


            $people = \Session::get('poeple');
            $ticket = $this->get_qrcode_ticket($people->user_id);
            $people->qr_subscribe_ticket = $ticket;
            $people->save();
            \Session::set('people', $people);
        }
        
        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/distributor/qrcode");
    }

    /**
     * 修改用户信息
     *
     */
    private function change_user(){

        $rule = \Validation::forge('init_user');
        $rule->add_callable('\handler\validation\MyRules');
        $rule->add_field('username', '用户名', 'required|trim|min_length[5]|max_length[30]|unique[users.username]');
        $rule->add_field('password', '密码', 'required|trim|min_length[6]');

        if( ! $rule->run()){
            $errors = [];
            foreach ($rule->error() as $key => $value) {
                /*$error[$key] = (string)$value;
                array_push($errors, $error);*/
                array_push($errors, (string)$value);
            }

            die(json_encode(['status' => 'err', 'msg' => '表单验证错误', 'errcode' => 10, 'data' => $errors]));
        }

        //修改密码
        $password = \Auth::reset_password(\Auth::get_user()->username);
        if( ! \Auth::change_password($password, \Input::post('password'))){
            die(json_encode(['status' => 'err', 'msg' => '密码修改失败', 'errcode' => 10]));
        }

        //修改登录名
        \DB::update('users')->set(['username' => \Input::post('username')])->where('id', \Auth::get_user()->id)->execute();
    }

    /**
     * 获取带参数的推广二维码
     */
    private function get_qrcode_ticket($user_id){
        $qrcode = \Model_WXAccountQrcode::query()
            ->where('key', $user_id)
            ->get_one();

        //该推广二维码不存在,创建
        if( ! $qrcode){

            $msg = false;

            $qrcode = \Model_WXAccountQrcode::forge([
                'qrcode' => '',
                'key' => $user_id,
                'valid_date' => 0,
                'type' => 'TEMP',
                'account_id' => \Session::get('WXAccount')->id
            ]);
            if( ! $qrcode->save()){
                $msg = ['status' => 'err', 'msg' => '保存二维码时错误', 'errcode' => 10];
            }

            if($msg){
                if(\Input::is_ajax()){
                    die(json_encode($msg));
                }
                \Session::set_flash($msg);
                return $this->show_message();
            }

        }

        //该二维码过期
        if($qrcode->valid_date < time()){
            $msg = false;
            $result = \handler\mp\Api::generate_qrcode_ticket(\Session::get('WXAccount'), $qrcode->key);
            $json = json_decode($result);

            if(isset($json->errcode)){
                $msg = ['status' => 'err', 'msg' => '获取推广二维码时发生异常', 'errcode' => 10];
            }

            if($msg){
                if(\Input::is_ajax()){
                    die(json_encode($msg));
                }
                \Session::set_flash($msg);
                return $this->show_message();
            }

            $qrcode->qrcode = $json->ticket;
            $qrcode->valid_date = time() + intval($json->expire_seconds);
            $qrcode->save();
            return $json->ticket;
        }

        return false;
    }
    
}
