<?php
/**
 * 打印机控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace api;

class Controller_Printer extends \Controller_BaseController {

    public function before(){
        parent::before();
    }

    /**
     * 开始打印
     */
    public function action_index(){
        $protocol = new \handler\printer\yilianyun\Printer([]);
        $protocol->start_print('内容', '终端号', '终端密钥', time());
    }

    /**
     * 打印机作业完成通知
     */
    public function action_finish(){
        $protocol = new \handler\printer\yilianyun\Printer([]);
        $protocol->finish();
    }
}
