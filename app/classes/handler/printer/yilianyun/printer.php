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
 * 易联云打印机对接接口
 *
 * 定义打印机发起打印请求,打印完成通知等功能
 *
 * @package  app
 * @extends  Controller
 */

namespace handler\printer\yilianyun;

class Printer implements \handler\printer\PrinterProtocol{

    private $data;      //请求包数据
    private $user_id = 3639;   //应用用户ID
    private $api_key = '91c4864cbc5f07d38438df3b4e50442b92c948e6';   //应用Key
    private $msg;       //响应信息
    private $domain = 'http://open.10ss.net:8888';    //主机

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * 打印完成通知
     *
     * @return mixed
     */
    public function finish(){

        if( ! isset($this->data['time'])){
            $this->msg = ['status' => 'err', 'msg' => '缺少必要参数', 'errcode' => 90001];
            return false;
        }

        $sign = md5("{$this->api_key}{$this->data['time']}");
        $sign = strtoupper($sign);

        if($sign != $this->data['sign']){
            $this->msg = ['status' => 'err', 'msg' => '签名错误', 'errcode' => 90002];
            return false;
        }

        //$this->data['dataid']; 单号
        //$this->data['machine_code']; 单号
        //$this->data['printtime']; 单号
        //$this->data['time']; 单号
        //$this->data['state']; 单号
        //$this->data['sign']; 单号
        //$this->data['cmd']; 单号
    }

    /**
     * 发起打印请求
     *
     * @param $content
     * @param $machine_code
     * @param $mkey
     * @param $time
     */
    public function start_print($content, $machine_code, $mkey, $time){
        $params = [
            'partner' => $this->user_id,
            'machine_code' => $machine_code,
            'time' => $time,
            'content' => $content
        ];

        $sign = "{$this->api_key}machine_code{$machine_code}partner{$this->user_id}time{$time}{$mkey}";

        $params['sign'] = md5($sign);
        $params['sign'] = strtoupper($params['sign']);

        $result = \handler\common\UrlTool::request($this->domain, 'POST', $params);
        $result = json_decode($result->body);

        if($result->state == 1){
            return true;
        }
        $errmsg = [2 => '提交时间超时.验证你所提交的时间戳超过3分钟事拒绝接受', 3 => '参数有误', 4 => 'sign加密检验失败'];
        $this->msg = ['status' => 'err', 'msg' => $errmsg[$result->state], 'errcode' => 90100];
        return false;
    }
}