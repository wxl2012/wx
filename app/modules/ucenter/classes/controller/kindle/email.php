<?php
/**
 * Kindle推送相关邮箱设置控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace ucenter;

class Controller_Kindle_Email extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    /**
     * 默认方法
     */
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

}
