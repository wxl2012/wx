<?php

/**
 * 微信公众平台推送的文本消息处理类
 *
 * @package    Fuel
 * @version    1.7
 * @author     Ray zyr.wxl@gmail.com
 * @license    MIT License
 * @copyright  2015 PMonkey Team
 * @link       http://mnzone.cn
 */
namespace handler\mp\action;

class Text extends Base {

    function __construct($argument = false)
    {
        # code...
    }

    /**
     * 处理请求
     */
    public function handle(){
        if(strpos($this->data->Content, '命运') !== false){
            $fate = new \handler\mp\action\text\ReplyFateImage();
            $fate->setWechat($this->wechat);
            $fate->setAccount($this->account);
            $fate->setPostData($this->data);
            $fate->handle();
        }
    }
}