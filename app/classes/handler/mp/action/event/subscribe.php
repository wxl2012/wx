<?php
/**
 * 微信公众平台推送的关注事件消息处理类
 *
 * @package    Fuel
 * @version    1.7
 * @author     Ray zyr.wxl@gmail.com
 * @license    MIT License
 * @copyright  2015 PMonkey Team
 * @link       http://mnzone.cn
 */
namespace handler\mp\action;

class Subscribe extends Event {

    private $event_type;

    function __construct($argument)
    {
        $this->event_type = $argument;
    }

    public function handle(){
        if(isset($this->data->EventKey) && isset($this->data->Ticket)){
            if($this->event_type == 'SCAN'){
                $this->subscribe_scan();
            }else{
                $this->none_scan();
            }
        }else{
            $this->normal();
        }
    }

    /**
     * 未关注时的扫码关注操作
     */
    private function none_scan(){
        \Log::error("未关注时的扫码关注操作:none_scan()");
    }

    /**
     * 已关注时的扫码关注操作
     */
    private function subscribe_scan(){
        \Log::error("已关注时的扫码关注操作:subscribe_scan()");
    }

    /**
     * 正常关注操作
     */
    private function normal(){
        \Log::error("正常关注操作:normal()");
    }

}