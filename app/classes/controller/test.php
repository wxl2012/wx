<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2015 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * The Test Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Test extends Controller {

    public function action_image(){

        $image = imagecreatefromjpeg(DOCROOT . 'uploads/tmp/bg.jpg');

        $this->addTextToImage($image, "81岁", 50);

        $this->addTextToImage($image, "王晨芯的命运是", 100);

        $this->addTextToImage($image, "寿命: 81岁", 150);

        $this->addTextToImage($image, "家庭: 21岁结婚后得", 200);

        $this->addTextToImage($image, "车子: 法拉利458 Speciale", 250);

        $this->addTextToImage($image, "房子: 利奥波德别墅", 300);

        $this->addPortraitToImage($image);

        imagepng($image);
    }

    /**
     * 添加头像至图片中
     *
     * @param $image
     */
    function addPortraitToImage($image){
        $portrait = DOCROOT . 'uploads/tmp/logo.png';
        $portraitFile = imagecreatefromstring(file_get_contents($portrait));
        //头像尺寸
        $portraitWidth = imagesx($portraitFile);
        $portraitHeight = imagesy($portraitFile);

        //原图尺寸
        $imageWidth = 50;
        $imageHeight = 50;
        $x = 250;
        $y = 50;
        imagecopyresampled($image, $portraitFile, $x, $y, 0, 0, $imageWidth, $imageHeight, $portraitWidth, $portraitHeight);
    }

    /**
     * 添加二维码至图片中
     * @param $image
     */
    function addQrcodeToImage($image){

    }

    /**
     * 添加文字至图片中
     *
     * @param $image	图片对象
     * @param $text		文字内容
     * @param int $y	y坐标
     */
    function addTextToImage($image, $text, $y = 0){

        $imageWidth = imagesx($image);

        $fontColor = imagecolorallocate($image, 255, 255, 255);

        $font = '/Library/Fonts/Baoli.ttc';

        $fontBox = imagettfbbox(20, 0, $font, $text);

        imagettftext($image, 20, 0, ceil(($imageWidth - $fontBox[2]) / 2), $y, $fontColor, $font, $text);
    }
}
?>