<?php

namespace handler\common;

class UrlTool{

    /**
     * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
     * @param $para 需要拼接的数组
     * return 拼接完成以后的字符串
     */
    public static function createLinkstring($para) {
        $arg  = "";
        while (list ($key, $val) = each ($para)) {
            $arg.= "{$key}={$val}&";
        }
        //去掉最后一个&字符
        $arg = substr($arg,0,count($arg)-2);

        //如果存在转义字符，那么去掉转义
        if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}

        return $arg;
    }

    /**
     * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
     * @param $para 需要拼接的数组
     * return 拼接完成以后的字符串
     */
    public static function createLinkstringUrlencode($para) {
        $arg  = "";
        while (list ($key, $val) = each ($para)) {
            $arg.=$key."=".urlencode($val)."&";
        }
        //去掉最后一个&字符
        $arg = substr($arg,0,count($arg)-2);

        //如果存在转义字符，那么去掉转义
        if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}

        return $arg;
    }

    /**
     * 模拟GET或POST发送请求
     * 并获取返回值
     * @param $url 需要发送的地址
     * @param $method 请求方式
     * @param $params 参数列表
     * @param $is_ssl https
     */
    public static function request($url, $method = 'GET', $params = array(), $is_ssl = false, $mime = false, $options = array(), $headers = array()){
        if( ! $url){
            die('错误的URL');
        }
        $curl = \Request::forge($url, 'curl');
        $curl->set_method($method);

        if($params){
            $curl->set_params($params);
        }

        if($is_ssl){
            $curl->set_option(CURLOPT_SSL_VERIFYPEER, false);
        }

        if($options){
            $curl->set_options($options);
        }

        if($mime){
            $curl->set_mime_type($mime);
        }

        if($headers){
            foreach ($headers as $key => $value) {
                $curl->set_header($key, $value);
            }
        }

        $curl->set_options(array(
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => true,
            )
        );

        $result = false;

        try{
            $result = $curl->execute()->response();
        }catch(Exception $e){
            \Log::error("发送请求时，发生了异常(classes/tolls/tools.php)：" . $e->getMessage());
        }

        return $result;
    }

    /**
     * 模拟GET或POST XML到直接URL
     *
     * @param $url 需要发送的地址
     * @param $method 请求方式
     * @param $params 参数列表
     * @param $is_ssl https
     */
    public static function request_xml($url, $method = 'POST', $params, $is_ssl = true){

        $curl = \Request::forge($url, 'curl');
        $curl->set_method($method);

        if($params){
            $curl->set_params($params);
        }

        if($is_ssl){
            $curl->set_option(CURLOPT_SSL_VERIFYPEER, false);
            $curl->set_option(CURLOPT_SSL_VERIFYHOST, false);
        }

        $curl->set_options(array(
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HEADER => FALSE,
                CURLOPT_RETURNTRANSFER => TRUE,
            )
        );

        $result = false;

        try{
            $result = $curl->execute()->response();
        }catch(Exception $e){
            \Log::error("发送请求时，发生了异常(classes/tolls/tools.php)：" . $e->getMessage());
        }

        return $result;
    }
}