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

namespace trade;

abstract class Controller_BaseController extends \Controller_BaseController {

    public $template = 'default/template';
    public $theme = 'default';

    public function before(){
        parent::before();
        if( ! \Auth::check()){
            $url = \Uri::current();
            $params = \Uri::build_query_string(\Input::get());
            \Response::redirect("/ucenter/login?to_url={$url}?{$params}");
        }
    }
}
