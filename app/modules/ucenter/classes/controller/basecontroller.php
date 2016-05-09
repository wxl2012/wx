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

namespace ucenter;

abstract class Controller_BaseController extends \Controller_BaseController {

    public $template = 'default/template';
    public $theme = 'default';

    public function before(){
        parent::before();
        
        $this->checkLogin();
    }

    /**
     * 获取未登录时的可访问列表
     * @return bool
     */
    protected function getNotLoginAllowed(){
        $allowed = [
            [
                'module' => 'ucenter',
                'controller' => 'home',
                'actions' => ['register', 'login', 'forget_pwd']
            ]
        ];
        foreach($allowed as $item){
            if($item['module'] == \Uri::segment(1)
                && in_array(\Uri::segment(2), $item['actions'])){
                return true;
            }else if($item['module'] == \Uri::segment(1)
                && $item['controller'] == \Uri::segment(2)
                && in_array(\Uri::segment(3), $item['actions'])){
                return true;
            }
        }
        return false;
    }
}
