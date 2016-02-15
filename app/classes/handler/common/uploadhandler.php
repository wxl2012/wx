<?php

/**
 * 文件上传辅助类
 */

namespace handler\common;

class UploadHandler {

    function __construct()  {

    }

    /**
     * 获取用户上传文件存储的路径及访问地址
     *
     * @param module 资源存储的类型（请参考config/global.php文件中的folders数组）
     */
    public static function get_upload_path($module = 4, $coustom = ''){
        \Config::load('global');
        $folders = \Config::get('folders');
        $root = \Config::get('root_directory');
        $host = str_replace('.', '', \Input::server('HTTP_HOST'));
        $user_id = (\Auth::check() ? \Auth::get_user()->id : '0');

        //资源访问主机域名如：http://img1.evxin.com
        $resUrl = \Config::get('resource_url') !== false ? \Config::get('resource_url') : '';
        //资源物理路径
        $uploadPath = \Config::get('upload_path') !== false ? \Config::get('upload_path') : '';

        $user_id = ($module == 4 ? '' : "/{$user_id}/");
        $ymd = date('/Ymd');

        //完整物理路径＝服务器物理路径+当前域名+资源存储目录+年月日
        $path = "{$root}/{$host}/{$folders[$module]}{$user_id}{$ymd}/" . ($coustom ? "{$coustom}/" : '');
        $url = "{$resUrl}/{$path}";
        return array('root_directory' => $uploadPath, 'path' => $path, 'url' => $url);
    }

    /**
     * 创建目录，如果目录不存在的话
     *
     * @param path 物理路径如：D:/wwwroot/evxin
     * @return 成功返回true,否则返回false
     */
    public static function create_directory($root_directory = false, $path = false){
        if( ! $path){
            return false;
        }

        try{
            $folders = explode('/', $path);
            $tempPath = $root_directory;
            foreach ($folders as $key => $value) {
                $tempPath = "{$tempPath}/{$value}";
                if( ! $tempPath){
                    continue;
                }else if(is_dir($tempPath)){
                    continue;
                }
                mkdir($tempPath);
            }
        }catch(Exception $e){
            \Log::error("[tools\UploadHandler]创建目录是发生异常：" . $e->getMessage());
            return false;
        }

        return true;
    }
}