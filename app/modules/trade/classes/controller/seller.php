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
    public function action_create(){}
}
