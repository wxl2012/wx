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

namespace store;

abstract class Controller_BaseController extends \Controller_BaseController {

    public $template = 'default/template';
    public $theme = 'default';

    public function before(){
        parent::before();

        if( ! \Session::get('seller', false) && \Input::get('seller_id', false)){
            $seller = \Model_Seller::find(\Input::get('seller_id'));
            if( ! $seller){
                die('bad request');
            }
        }

        if( ! \Session::get('store', false)){
            $store = \Model_Store::find(1);
            if( ! $store){
                die();
            }
            \Session::set('store', $store);
        }
    }
}
