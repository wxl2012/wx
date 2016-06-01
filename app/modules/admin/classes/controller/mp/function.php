<?php
/**
 * 后台管理基础控制器
 *
 * @package  app
 * @extends  Controller
 */
namespace admin;

class Controller_MP_Function extends Controller_BaseController
{
    public function before(){
        parent::before();
    }

    public function action_index(){
        $params = array(
            'title' => "数据配置——",
            'menu' => 'wechat',
            'action_name' => '数据配置项'
        );

        \View::set_global($params);
        $this->template->content = \View::forge("ace/wxaccount/config");
    }

    public function action_menu_save($id = 0){
        $data = \Input::post();
        $account = \Model_WXAccount::find($id);
        $account->set($data);
        if($account->save()){
            $account->checkToken();
            $result = \handler\mp\Api::generate_coustom_menu($account->temp_token, $data['menu']);
            die(json_encode(array('status' => 'succ', 'msg' => '菜单保存成功', 'errcode' => 0, 'result' => $result->body)));
        }else{
            die(json_encode(array('status' => 'err', 'msg' => '菜单保存失败', 'errcode' => 10)));
        }

        \View::set_global($params);
        $this->template->content = \View::forge("ace/mp/coustom_menu/index");
    }

    public function action_menu(){
        $params = array(
            'title' => "自定义菜单——",
            'menu' => 'wechat-menu',
            'action_name' => "自定义菜单"
        );

        \View::set_global($params);
        $this->template->content = \View::forge("ace/mp/coustom_menu/index");
    }

    public function action_menus(){
        $params = array(
            'title' => "菜单项",
            'menu' => 'wechat-menu',
            'action_name' => "自定义菜单"
        );

        $account = \Model_WXAccount::find(\Session::get('WXAccount')->id);
        if( ! $account){
            if(\Input::is_ajax()){
                die(json_encode(array('status' => 'err', 'msg' => '您还未绑定有效公众帐户', 'errcode' => 10)));
            }
            die('您还未绑定有效公众帐户');
        }

        $params['items'] = isset($account->menu) && $account->menu ? json_decode($account->menu) : '';

        \View::set_global($params);
        return \View::forge("ace/mp/coustom_menu/moblie");
    }

    public function action_menus_actions(){
        $items = array(
            array(
                'category' => 'normal',
                'data' => array(
                    array(
                        'value' => 'click',
                        'text' => '关键字'
                    ),
                    array(
                        'value' => 'view',
                        'text' => '网址'
                    )
                )
            ),
            /*array(
                'category' => 'function',
                'data' => array(
                    array(
                        'value' => \Config::get('base_url') . "/m/website?account_id=". \Session::get('account')->id,
                        'text' => '微官网'
                    ),
                    array(
                        'value' => \Config::get('base_url') . "/m/member/view?account_id=" . \Session::get('account')->id,
                        'text' => '会员卡'
                    ),
                    array(
                        'value' => \Config::get('base_url') . "/m/mall?account_id=" . \Session::get('account')->id,
                        'text' => '微商城'
                    ),
                    array(
                        'value' => \Config::get('base_url') . "/m/catering?account_id=" . \Session::get('account')->id,
                        'text' => '微订餐'
                    ),
                    array(
                        'value' => 'category',
                        'text' => '文章类目'
                    ),
                    array(
                        'value' => 'vote',
                        'text' => '投票'
                    )
                )
            ),
            array(
                'category' => 'other',
                'data' => array(
                    array(
                        'value' => 'text',
                        'text' => '文本信息'
                    ),
                    array(
                        'value' => 'news',
                        'text' => '图文信息'
                    )
                )
            ),
            array(
                'category' => 'event',
                'data' => array(
                    array(
                        'value' => 'scancode_push',
                        'text' => '扫码推事件'
                    ),
                    array(
                        'value' => 'scancode_waitmsg',
                        'text' => '扫码推事件且弹出“消息接收中”提示框'
                    ),
                    array(
                        'value' => 'pic_sysphoto',
                        'text' => '弹出系统拍照发图'
                    ),
                    array(
                        'value' => 'pic_photo_or_album',
                        'text' => '弹出拍照或者相册发图'
                    ),
                    array(
                        'value' => 'pic_weixin',
                        'text' => '弹出微信相册发图器'
                    ),
                    array(
                        'value' => 'location_select',
                        'text' => '弹出地理位置选择器'
                    )
                )
            )*/
        );
        if($items){
            die(json_encode(array('status' => 'succ', 'msg' => '', 'errcode' => 0, 'data' => $items)));
        }
        die(json_encode(array('status' => 'err', 'msg' => '', 'errcode' => 20)));
    }


    /**
     * 关键字列表
     */
    public function action_reply(){

        $params = array(
            'title' => "自动回复——{$this->controller_name}",
            'menu' => 'auto-reply',
            'action_name' => "关键字回复列表"
        );

        $items = \Model_WXAction::query()
            ->where('account_id', \Session::get('WXAccount')->id);

        $count = $items->count();
        $config = array(
            'pagination_url' => "/admin/wxaccount/reply",
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
        $this->template->content = \View::forge("ace/wxaccount/material/auto_reply");
    }


    /**
     * 关键字详情
     * @param $id 关键字ID
     */
    public function action_reply_save($id = 0){

        $params = array(
            'title' => "自动回复——{$this->controller_name}",
            'menu' => 'auto-reply',
            'action_name' => "创建关键字回复"
        );

        $item = array();

        if($id){
            $item = \Model_WXAction::find($id);
        }

        if(\Input::method() == 'POST'){
            $data = \Input::post();
            if($item){
                $material = \Model_WXMaterial::find($data['material_id']);
                $material->set($data);
                $material->save();

                $item->set($data);
            }else{
                $material = \Model_WXMaterial::forge($data);
                $material->save();

                $data['material_id'] = $material->id;
                $item = \Model_WXAction::forge($data);
            }
            $item->save();
        }

        if($item){
            $params['item'] = $item;
        }

        \View::set_global($params);
        $this->template->content = \View::forge("ace/wxaccount/material/reply");
    }

    /**
     * 关键字删除
     * @param $id 关键字ID
     */
    public function action_reply_delete($id = 0){
        $action = \Model_WXAction::find($id);
        if($action){
            $action->delete();
        }
        \Response::redirect('/admin/wxfunction/reply');
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
}
