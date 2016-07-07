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

class Controller_Marketing_One extends Controller_BaseController {

    public $template = 'one/template';
    public $theme = 'one';

    public function before(){
        parent::before();
    }

    public function action_index(){
        
    }

    /**
     * 我的夺宝
     */
    public function action_list(){
        $this->template->content = \View::forge("{$this->theme}/marketing/list");
    }

    /**
     * 幸运记录
     */
    public function action_win(){
        $this->template->content = \View::forge("{$this->theme}/marketing/win");
    }
}
