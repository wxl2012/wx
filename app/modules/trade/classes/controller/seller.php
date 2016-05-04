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
        }else if(true){
            $msg = [
                'title' => '无此权限',
                'msg' => '您无权进行该项操作'
            ];
        }

        if($msg){
            \Session::set_flash('msg', $msg);
            $this->show_message();
        }
    }
}
