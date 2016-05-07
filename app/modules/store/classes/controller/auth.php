<?php
/**
 * 默认控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace store;

class Controller_Auth extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    public function action_index(){
        
        $this->template->content = \View::forge("{$this->theme}/auth/index");
    }
}
