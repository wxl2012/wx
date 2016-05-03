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
 * 向微信服务器发起请求
 *
 * 微信接口控制器，主要用于处理由微信服务器发送过来的请求。
 *
 * @package  app
 * @extends  Controller
 */
namespace handler\mp;

class Api{

    /**
     * 向微信服务器上传多媒体资源(永久资源)
     *
     * @param $access_token     访问令牌
     * @param $type             资源类型 image | voice | video | thumb
     * @param $media            媒体信息
     * @return bool
     */
    public static function upload_media($access_token, $type, $media){

        $data = false;
        if(class_exists('\CURLFile')){
            $data = ['media' => new \CURLFile($media)];
        }else{
            $data = ['media' => "@{$media}"];
        }

        $url = "https://api.weixin.qq.com/cgi-bin/add_material?access_token={$access_token}&type={$type}";
        $result = \handler\common\UrlTool::request($url, 'POST', ['form-data' => $data], true);
        $obj = json_decode($result->body);

        if( ! isset($obj->media_id)){
            return false;
        }
        return $obj->media_id;
    }

    /**
     * 向微信服务器上传多媒体资源(临时资源)
     *
     * @param $access_token     访问令牌
     * @param $type             资源类型 image | voice | video | thumb
     * @param $media            媒体信息
     * @return bool
     */
    public static function upload_media_tmp($access_token, $type, $media){

        $data = false;
        if(class_exists('\CURLFile')){
            $data = ['media' => new \CURLFile($media)];
        }else{
            $data = ['media' => "@{$media}"];
        }

        $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token={$access_token}&type={$type}";
        $result = \handler\common\UrlTool::request($url, 'POST', ['form-data' => $data], true);
        \Log::error(serialize($result->body));
        $obj = json_decode($result->body);

        if( ! isset($obj->media_id)){
            return false;
        }

        \Cache::set(md5($media), $obj->media_id, 60 * 60 * 24 * 3);
        return $obj->media_id;
    }
}

?>