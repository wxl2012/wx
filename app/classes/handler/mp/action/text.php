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
        $reply = false;
        if(strpos($this->data->Content, '命运') !== false){
            $reply = new \handler\mp\action\text\ReplyFateImage();
        }else if($this->data->Content == '微信价值'){
            $reply = new \handler\mp\action\text\ReplyValuationImage();
        }else if(intval($this->data->Content) > 0){
            $reply = new \handler\mp\action\text\ReplyVote();
        }else if(strpos($this->data->Content, '查询') !== false){
            $reply = new \handler\mp\action\text\ReplyVoteNum();
        }else{
            die('success');
        }
        $reply->setWechat($this->wechat);
        $reply->setAccount($this->account);
        $reply->setPostData($this->data);
        $reply->handle();
    }
}