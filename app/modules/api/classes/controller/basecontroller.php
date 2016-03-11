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

namespace common;

abstract class Controller_BaseController extends \Fuel\Core\Controller_Rest {

    public function before(){
        parent::before();
    }

    public function action_index(){
        die('over');
    }
}
