<?php
/**
 * 微信公众号控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

/**
 * 本控制器主要用于：
 * 1.
 * @package  app
 * @extends  Controller
 */
namespace admin;

class Controller_WXAccount extends Controller_BaseController {

    public function before(){
        parent::before();

        $params = array(
            'controller_name' => '微信公众号管理'
        );
        \View::set_global($params);
    }

    public function action_index(){
        $params = array(
            'title' => '微信公众帐户列表——微信公众号管理',
            'menu' => 'wxaccount',
            'action_name' => '微信公众帐户列表'
        );

        $GLOBAL_OPTIONS = \Session::get('GLOBAL_OPTIONS');

        if(\Auth::get_user()->username != 'admin' && isset($GLOBAL_OPTIONS['bind_wx_account_count']) && $GLOBAL_OPTIONS['bind_wx_account_count'] == 1){
            $seller = \Session::get('seller');
            
            $account_id = '';
            if($seller->wxaccounts){
                $account_id = current($seller->wxaccounts)->id;
            }
            \Response::redirect("/admin/wxaccount/save/{$account_id}");
        }

        $account = \Model_WXAccount::query();
        if(\Auth::get_user()->username != 'admin'){
            $account->where('seller_id', \Session::get('seller')->id);
        }
        $params['items'] = $account->get();

        \View::set_global($params);
        $this->template->content = \View::forge("ace/mp/account/index");
    }

    public function action_save($id = 0){
        $params = array(
            'title' => '公众号设置——微信公众号管理',
            'menu' => 'wxaccount',
            'action_name' => '公众号资料'
        );

        $account = array();

        if($id){
            $account = \Model_WXAccount::find($id);
        }

        if(\Input::method() == 'POST'){

            $data = \Input::post();
             $val = \Validation::forge('MyRules');
            $val->add_callable('MyRules');
            $val->add_field( 'open_id', 'OPENID', 'required' . ($id ? '' : '|unique[wx_accounts.open_id]'));
            $val->add_field( 'app_id', '应用ID', 'required');
            $val->add_field( 'app_secret', '应用密钥', 'required');

            if (! $val->run()){
                foreach ($val->error() as $key => $value) {
                    $errors[$key] = (string)$value;
                }
                if(\Input::is_ajax()){
                    die(json_encode(array('status' => 'err', 'msg' => '表单验证错误', 'data' => $errors, 'errcode' => 10)));
                }
                $msg = array('status' => 'err', 'msg' => '表单验证错误', 'data' => $errors, 'errcode' => 10);
            }else{

                //判断操作类型：编辑或创建
                if($account){
                    $account->set($data);
                }else{
                    $data['seller_id'] = isset($data['seller_id']) ? $data['seller_id'] : \Session::get('seller')->id;
                    $account = \Model_WXAccount::forge($data);

                    //设置额外属性
                    $account->metadata = array(
                            \Model_WXAccountMetadata::forge(array('key' => 'keyword_not_fond', 'value' => 'reply_text')),
                            \Model_WXAccountMetadata::forge(array('key' => 'keyword_not_found_content', 'value' => '')),
                            \Model_WXAccountMetadata::forge(array('key' => 'is_subscribe_member', 'value' => 1)),
                            \Model_WXAccountMetadata::forge(array('key' => 'wechat_ticket', 'value' => '')), 
                            \Model_WXAccountMetadata::forge(array('key' => 'wechat_ticket_valid', 'value' => 0)),
                            \Model_WXAccountMetadata::forge(array('key' => 'is_fans_create_page', 'value' => 1)),
                            \Model_WXAccountMetadata::forge(array('key' => 'share_url', 'value' => isset($data['share_url']) ? $data['share_url'] : '')),
                            \Model_WXAccountMetadata::forge(array('key' => 'fans_create_page_keyword', 'value' => isset($data['fans_create_page_keyword']) ? $data['fans_create_page_keyword'] : 'ok')),
                            \Model_WXAccountMetadata::forge(array('key' => 'fans_create_page_over_keyword', 'value' => isset($data['fans_create_page_over_keyword']) ? $data['fans_create_page_over_keyword'] : 'over'))
                        );
                }
                if($account->save()){
                    $seller = \Model_Seller::find(\Session::get('seller')->Id);
                    \Session::set('seller', $seller);
                    \Session::set('WXAccount', $account);
                    $msg = array('status' => 'succ', 'msg' => '操作成功', 'errcode' => 0);
                }else{
                    $msg = array('status' => 'err', 'msg' => '操作失败', 'errcode' => 10);
                }
            }

            if(\Input::is_ajax()){
                die(json_encode($msg));
            }
            \Session::set_flash('msg', $msg);
        }

        if($account){
            $params['item'] = $account;
        }

        \View::set_global($params);
        $this->template->content = \View::forge('ace/mp/account/details');
    }

    public function action_exist($filed = 'open_id', $value = ''){
        $account = \Model_WXAccount::query()->where($filed, $value)->get();
        if( ! $account){
            die(json_encode(array('status' => 'succ', 'msg' => '', 'errcode' => 0, 'data' => false)));
        }
        die(json_encode(array('status' => 'succ', 'msg' => '', 'errcode' => 0, 'data' => true)));
    }

    /**
    * 查看带参数二维码列表
    * @param $id 公众号ID
    */
    public function action_param_qrcode($id = 0){

        $params = array(
            'title' => '微信公众帐户带参二维码列表——微信公众号管理',
            'menu' => 'wxaccount',
            'action_name' => '微信公众帐户列表 》带参二维码列表'
        );

        if(\Input::method() == 'POST'){
            $data = \Input::post();

            $account_id = \Session::get('WXAccount')->id;
            $table = \DB::table_prefix('wx_accounts_qrcodes');
            $time = time();
            $sql = "SELECT * FROM {$table} WHERE (`key` = '{$data['key']}' AND `type` = 'TEMP' AND `valid_date` > {$time} AND `account_id` = {$account_id}) OR (`key` = '{$data['key']}' AND `type` = 'LIMIT' AND `account_id` = {$account_id})";
            $rows = \DB::query($sql)->execute()->as_array();
            if($rows){
                $data = current($rows);
                die(json_encode(array('status' => 'err', 'msg' => '该参数的二维码已存在', 'errcode' => 10, 'data' => $data ? $data['qrcode'] : '')));
            }

            $result = \impls\wechat\Common::generate_qrcode_ticket($data['key'], strtolower($data['type']));
            $array = json_decode($result);
            $data['url'] = $array->url;
            $data['ticket'] = $array->ticket;
            if($data['type'] == 'TEMP'){
                $data['valid_date'] = time() + $array->expire_seconds;
            }else{
                $data['valid_date'] = 0;
            }
            $data['qrcode'] = \tools\Tools::generate_qrcode($data['url'], '/uploads/qrcodes/');

            $qrcode = \Model_WXAccountQrcode::forge($data);
            if($qrcode->save()){
                if(\Input::is_ajax()){
                    die(json_encode(array('status' => 'succ', 'msg' => '', 'errcode' => 0, 'data' => $data['qrcode'])));
                }
            }else{
                if(\Input::is_ajax()){
                    die(json_encode(array('status' => 'err', 'msg' => '生成失败', 'errcode' => 20)));
                }
            }
        }

        $data = \Input::get();

        $items = \Model_WXAccountQrcode::query()
                ->where('account_id', $id);


        $where_args = '';
        //是否需要筛选二维码的参数
        if(isset($data['key']) && $data['key']){
            $items->where('key', $data['key']);   
            $where_args .= "key={$data['key']}&";
        }
        //是否需要筛选二维码的状态
        if(isset($data['status']) && $data['status']){
            $where_args .= "status={$data['status']}&";
            if($data['status'] == 'valid'){
                $items->and_where_open()
                        ->where('valid_date', '>', time())
                        ->where('type', 'TEMP')
                        ->and_where_close();
                $items->or_where_open()
                        ->where('type', 'LIMIT')
                        ->or_where_close();
            }else if(in_array(strtoupper($data['status']), array('TEMP', 'LIMIT'))){
                $items->where('type', $data['status']);
            }
        }
        $where_args = $where_args ? "?{$where_args}" : '';
        $count = $items->count();
        $config = array(
            'pagination_url' => "/admin/wxaccount/param_qrcode/{$id}{$where_args}",
            'total_items'    => $count,
            'per_page'       => \Input::get('count', 15),
            'uri_segment'    => "start",
            'show_first'     => true,
            'show_last'      => true,
            'name'           => 'bootstrap3_cn'
        );

        $pagination = new \Pagination($config);
        $params['pagination'] = $pagination;        
        $params['items'] = $items
                            ->rows_offset($pagination->offset)
                            ->rows_limit($pagination->per_page)
                            ->get();

        \View::set_global($params);
        $this->template->content = \View::forge("ace/wxaccount/qrcodes");
    }

    /**
    * 查询推广数据
    * @param $id 带参数的二维码ID
    */
    public function action_records($id = 0){
        $params = array(
            'title' => '微信公众帐户推广数据——微信公众号管理',
            'menu' => 'wxaccount',
            'action_name' => '微信公众帐户列表 》带参数二维码 》推广数据'
        );

        $items = \Model_WXAccountQrcodeRecord::query();
        if($id){
            $items->where('qrcode_id', $id);
        }

        $count = $items->count();
        $config = array(
            'pagination_url' => "/admin/wxaccount/records/{$id}",
            'total_items'    => $count,
            'per_page'       => \Input::get('count', 15),
            'uri_segment'    => 'start',
            'show_first'     => true,
            'show_last'      => true,
            'name'           => 'bootstrap3_cn'
        );

        $pagination = new \Pagination($config);
        $params['pagination'] = $pagination;        
        $params['items'] = $items
                            ->rows_offset($pagination->offset)
                            ->rows_limit($pagination->per_page)
                            ->get();

        \View::set_global($params);
        $this->template->content = \View::forge("ace/wxaccount/records");
    }

    /**
    * 获取粉丝信息后的操作链接
    * @param $id 带参数的二维码ID
    */
    public function action_urls($id = 0){
        $params = array(
            'title' => '后续操作链接——微信公众号管理',
            'menu' => 'wxaccount',
            'action_name' => '微信公众帐户列表 》后续操作链接地址'
        );

        $items = \Model_WXUrl::query();
        if($id){
            $items->where('account_id', $id);
        }

        $count = $items->count();
        $config = array(
            'pagination_url' => "/admin/wxaccount/urls/{$id}",
            'total_items'    => $count,
            'per_page'       => \Input::get('count', 20),
            'uri_segment'    => 'start',
            'show_first'     => true,
            'show_last'      => true,
            'name'           => 'bootstrap3_cn'
        );

        $pagination = new \Pagination($config);
        $params['pagination'] = $pagination;        
        $params['items'] = $items
                            ->rows_offset($pagination->offset)
                            ->rows_limit($pagination->per_page)
                            ->get();

        \View::set_global($params);
        $this->template->content = \View::forge("ace/wxaccount/urls");
    }
}