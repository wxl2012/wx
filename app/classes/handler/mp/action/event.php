<?php

/**
 * 微信公众平台推送的事件消息处理类
 *
 * @package    Fuel
 * @version    1.7
 * @author     Ray zyr.wxl@gmail.com
 * @license    MIT License
 * @copyright  2015 PMonkey Team
 * @link       http://mnzone.cn
 */
namespace handler\mp\action;

class Event extends Base{

    function __construct($argument = false)
    {
        # code...
    }

    /**
     * 处理请求
     */
    public function handle(){
        $handle = false;
        switch($this->data->Event){
            case 'subscribe':
                $qrKey = isset($this->data->EventKey) ? $this->data->EventKey : '';
                $qrKey = str_replace('qrscene_', '', $qrKey);
                $handle = new \handler\mp\action\event\Subscribe('subscribe', $qrKey);
                break;
            case 'unsubscribe':
                $handle = new \handler\mp\action\event\UnSubscribe();
                break;
            case 'SCAN':
                $handle = new \handler\mp\action\event\Subscribe('SCAN', $this->data->EventKey);
                break;
            case 'LOCATION':
                $this->data->Latitude;
                $this->data->Longitude;
                $this->data->Precision;
                $handle = new \handler\mp\action\event\Location();
                break;
            case 'CLICK':
                //KEY
                $this->data->EventKey;
                $handle = new \handler\mp\action\event\Click();
                break;
            case 'VIEW':
                //URL
                $this->data->EventKey;
                $handle = new \handler\mp\action\event\View();
                break;
        }

        $handle->setWechat($this->wechat);
        $handle->setAccount($this->account);
        $handle->setPostData($this->data);
        $handle->setSeller($this->seller);
        $handle->handle();
    }

}