<?php

/**
 * 微信公众平台推送的消息处理基类
 *
 * @package    Fuel
 * @version    1.7
 * @author     Ray zyr.wxl@gmail.com
 * @license    MIT License
 * @copyright  2015 PMonkey Team
 * @link       http://mnzone.cn
 */
namespace handler\mp\action;

abstract class Base {

    protected $data;
    protected $account;
    protected $wechat;
    protected $seller;

    /**
     * 设置微信公众平台推送的数据包
     * @param bool $arg
     */
    public function setPostData($arg = false){
        $this->data = $arg;
    }

    /**
     * 设置微信公众号对象
     * @param bool $arg
     */
    public function setAccount($arg = false){
        $this->account = $arg;
    }

    /**
     * 设置微信粉丝对象
     * @param bool $arg
     */
    public function setWechat($arg = false){
        $this->wechat = $arg;
    }

    /**
     * 设置商户对象
     * @param bool $arg
     */
    public function setSeller($arg = false){
        $this->seller = $arg;
    }

}