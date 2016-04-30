<?php
/**
 * 推荐控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace ucenter;

class Controller_Recommend extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    /**
     * 推荐列表
     */
    public function action_index(){
        $this->template->content = \View::forge("{$this->theme}/recommend/index");
    }

    public function action_qrcode(){
        $this->template->content = \View::forge("{$this->theme}/recommend/qrcode");
    }
}
