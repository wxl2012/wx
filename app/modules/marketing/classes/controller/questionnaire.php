<?php
/**
 * 基础控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace marketing;

class Controller_Questionnaire extends Controller_BaseController {

    public $theme = 'default';
    public $template = 'default/questionnaire/template';

    public function before(){
        parent::before();
    }

    public function action_index(){

        if( ! \Input::get('id', false)){
            die('');
        }
        $params['bank'] = \Model_QuestionBank::find(\Input::get('id'));

        \View::set_global($params);

        $this->template->content = \View::forge("{$this->theme}/questionnaire/index");
    }
}
