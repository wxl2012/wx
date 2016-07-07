<?php
/**
 * 一元购控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace marketing;

class Controller_Luck_One extends Controller_BaseController {

    public $theme = 'default';
    public $template = 'one/default/template';

    public function before(){
        parent::before();
    }

    public function action_index(){

        $params = [];

        \View::set_global($params);

        $this->template->content = \View::forge("one/{$this->theme}/index");
    }

    public function action_list(){

        $params = [];

        \View::set_global($params);

        $this->template->content = \View::forge("one/{$this->theme}/list");
    }

    public function action_view($id){

        $params = [];

        \View::set_global($params);

        $this->template->content = \View::forge("one/{$this->theme}/view");
    }

    public function action_history(){

        $params = [];

        \View::set_global($params);

        $this->template->content = \View::forge("one/{$this->theme}/history");
    }
}
