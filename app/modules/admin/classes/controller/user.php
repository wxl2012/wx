<?php
/**
 * 用户管理基础控制器
 *
 * @package  app
 * @extends  Controller
 */
namespace admin;

class Controller_User extends Controller_BaseController
{
    public function before(){
        parent::before();

        \View::set_global(['controller_name' => '用户管理']);
    }

    public function action_index(){
        $this->template->content = \View::forge("{$this->theme}/user/index");
    }

    public function action_profile($id = 0){
        $params = [
            'title' => '用户信息面板——用户管理',
            'action_name' => '用户信息面板'
        ];

        $params['people'] = \Model_People::find($id);

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/user/profile");
    }
}
