<?php
/**
 * 后台管理基础控制器
 *
 * @package  app
 * @extends  Controller
 */
namespace admin;

abstract class Controller_BaseController extends \Controller_BaseController
{
    public $template = 'ace/template';
    public $theme = 'ace';
    protected $result_message = false;

    public function before(){
        parent::before();

        if($this->getNotOpenidAllowed()){
            return;
        }

        if(!\Agent::is_mobiledevice()){
            $this->theme = 'mobile';
            $this->template->set_filename('mobile/template');
        }

        if( ! \Auth::check()){
            \Response::redirect('/admin/login');
        }
        // 检测是否后台帐户
        if( ! \Session::get('employee', false) && \Auth::get_user()->username != 'admin'){
            \Auth::logout();
            \Response::redirect('/admin/login');
        }
    }

    /**
     * 未登录时的消息提示
     *
     * @return mixed
     */
    protected function not_login_alert(){
        return \Response::forge(\View::forge('ace/alerts/not_logged'));
    }
}
