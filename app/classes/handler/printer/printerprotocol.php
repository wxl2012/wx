<?php

/**
 * 基于FuelPHP的微信第三方程序库
 *
 * @package    Fuel
 * @version    1.7
 * @author     Ray zyr.wxl@gmail.com
 * @license    MIT License
 * @copyright  2015 PMonkey Team
 * @link       http://mnzone.cn
 */

/**
 * 打印机作业接口
 *
 * 定义打印机发起打印请求,打印完成通知等功能
 *
 * @package  app
 * @extends  Controller
 */
namespace handler\printer;

interface PrinterProtocol{

    /**
     * 打印完成通知
     *
     * @return mixed
     */
    public function finish();

    /**
     * 发起打印请求
     *
     * @param $content
     * @param $machine_code
     * @param $mkey
     * @param $time
     */
    public function start_print($content, $machine_code, $mkey, $time);

}