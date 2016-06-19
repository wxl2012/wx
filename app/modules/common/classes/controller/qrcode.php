<?php
/**
 * 微信公众号常用方法控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

/**
 * 本控制器主要用于：
 * 1.
 * @package  app
 * @extends  Controller
 */

namespace common;

class Controller_Qrcode extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    public function action_generate(){

        $basePath = DOCROOT;


        $embedLogo = true;
        $logoFilePath = "{$basePath}uploads/tmp/qrcode/logo.png";

        //二维码内容
        $content = \Input::get('content', '');
        //保存路径
        $savePath = 'uploads/tmp/qrcode/';
        //容错级别(L | M | Q | H)
        $errLevel = 0;
        //二维码尺寸(1 ~ 10)
        $size = 10;
        //空白边距
        $margin = 2;

        $name = time();
        $qrFilePath = "{$basePath}{$savePath}{$name}.png";
        \QRcode::png($content, $qrFilePath, $errLevel, $size, $margin);
        $QRFile = imagecreatefromstring(file_get_contents($qrFilePath));
        // 是否嵌入Logo
        if($embedLogo && file_exists($logoFilePath)){
            $this->embedLogo($QRFile, $logoFilePath);
        }

        //保存为图片
        //imagepng($QRFile, $qrFilePath);
        //输出图片流
        imagepng($QRFile);
    }

    /**
     * 给二维码中间添加LOGO图标
     *
     * @param $QRFile       二维码PNG图片
     * @param $logoFilePath Logo图片路径
     */
    private function embedLogo($QRFile, $logoFilePath){
        $logoFile = imagecreatefromstring(file_get_contents($logoFilePath));
        //LOGO尺寸
        $logoWidth = imagesx($logoFile);
        $logoHeight = imagesy($logoFile);
        //二维码尺寸
        $qrWidth = imagesx($QRFile);
        //$qrHeight = imagesy($QRFile);

        $newQrWidth = $qrWidth / 5;
        $scale = $logoWidth / $newQrWidth;
        $newQrHeight = $logoHeight / $scale;

        $point = ($qrWidth - $newQrWidth) / 2;
        imagecopyresampled($QRFile, $logoFile, $point, $point, 0, 0, $newQrWidth, $newQrHeight, $logoWidth, $logoHeight);
    }
}
