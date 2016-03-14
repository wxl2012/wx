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
        $printer_id = \Input::get('printer_id', 0);
        if( ! $printer_id){
            die();
        }
        $printer = \Model_Printer::find($printer_id);
        $protocol = new \handler\printer\yilianyun\Printer([]);
        $result = $protocol->start_print('注册本次打印是通过华苑产业园发起的.', $printer->machine_code, $printer->msign, time());
        if($result === true){
            die('已提交打印');
        }
    }

    /**
     * 打印机作业完成通知
     */
    public function action_finish(){
        $protocol = new \handler\printer\yilianyun\Printer([]);
        $protocol->finish();
    }
}
