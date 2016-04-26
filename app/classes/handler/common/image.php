<?php

namespace handler\common;

class Image{

    /**
     * 将文字转换为图片
     *
     * @param $text 文字
     * @param $width    图片宽度
     * @param $height   图片高度
     * @return mixed    image对象
     */
    public static function text2Image($text, $width, $height){
        $image = imagecreate($width, $height);
        imagecolorallocate($image, 255, 255, 255);          #白色背景
        $fontColor = imagecolorallocate($image, 0, 0, 0);   #字体颜色
        imagestring($image, 16, 0, 0, $text, $fontColor);   #将字符串写到图片上
        return $image;
        //imagepng($image);       #输出一个PNG格式的图片
        //imagedestroy($image);   #销毁图片对象
    }

}