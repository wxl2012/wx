<?php
/**
 * 商户管理控制器
 *
 * @package  app
 * @extends  Controller
 */
namespace admin;

class Controller_Seller extends Controller_BaseController
{
    public function before(){
        parent::before();
    }

    public function action_index(){
        $this->template->content = \View::forge("{$this->theme}/dashboard");
    }

    public function action_register(){
        return \Response::forge(\View::forge("{$this->theme}/seller/register"));
    }
}
