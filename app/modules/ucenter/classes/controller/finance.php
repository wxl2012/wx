<?php
/**
 * 会员财务控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace ucenter;

class Controller_Finance extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    public function action_index(){
        die('index');
    }

    /**
     * 申请提现
     */
    public function action_cashback(){
        $this->template->content = \View::forge("{$this->theme}/finance/cashback");
    }
}
