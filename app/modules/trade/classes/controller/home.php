<?php
/**
 * 交易默认控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace trade;

class Controller_Home extends Controller_BaseController {

    public $template = 'default/template';
    public $theme = 'default';

    public function before(){
        parent::before();
    }

    /**
     * 加载预创建支付页
     */
    public function action_index(){}
}
