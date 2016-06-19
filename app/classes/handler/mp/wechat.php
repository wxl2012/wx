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
 * 微信用户协助类
 *
 *
 * @package  app
 * @extends  Controller
 */
namespace handler\mp;

class Wechat {

    function __construct($argument)
    {
        # code...
    }

    /**
     * 通过用户管理接口获取粉丝信息
     *
     * 本方法调用权限(认证的订阅号及认证的服务号)
     * @param $access_token 调用凭证
     * @param $openid       微信粉丝唯一ID
     * @return bool         获取成功返回信息对象,失败则返回False
     */
    public static function getWechatInfo($access_token, $openid){
        //拉取用户信息
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid}&lang=zh_CN";
        $result = \handler\common\UrlTool::request($url, 'GET', null, true);
        $result = json_decode($result->body);
        if(isset($result->errcode)){
            //\Session::set_flash('msg', ['status' => 'err', 'msg' => $result->errmsg, 'title' => '错误']);
            return false;
        }
        return $result;
    }

    /**
     * 根据微信头像链接, 判断是否已下载至本地.
     *
     * @param $url      微信头像URL
     * @return string   微信头像本地地址
     */
    public static function getWechatHeadImage($url){
        $filename = md5($url);
        $span = DS;
        $filePath = DOCROOT . "uploads{$span}tmp{$span}photos{$span}{$filename}.jpg";

        $result = \handler\common\UrlTool::request($url);

        $file = fopen($filePath, 'w');
        if($file === false){
            return;
        }else if(fwrite($file, $result) === false){
            return;
        }
        fclose($file);

        return $filePath;
    }
}