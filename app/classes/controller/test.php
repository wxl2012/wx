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

    public function action_index(){
        $access_token = 'u8uU_Ak6UQ9yztMUUw-ykbafvsWSZTNSnKn6etM1C0H1ifsRX0-6k7FofLyz7dv5NSS0jsI4Tdm13YWcRBjD9ypeFOzq6A38eQ0Wj1iEeIezsVkG_t3KWwaRfM84LXP3GYEhAFAPHN';
        \handler\mp\Api::upload_media($access_token, 'image', DOCROOT . 'uploads/tmp/fates/sc_fate.jpg');
    }

    public function action_image(){

        $image = imagecreatefromjpeg(DOCROOT . 'assets/img/fate.jpg');

        $fontColor = imagecolorallocate($image, 255, 0, 0);
        $this->addTextToImage($image, "86", $fontColor, 100, 255, 250);
        $this->addTextToImage($image, "岁", $fontColor, 20, 260, 370);
        $this->addTextToImage($image, "孙超的命运是", $fontColor, 18, 380, 0);
        $this->addTextToImage($image, "活到86岁", $fontColor, 18, 400, 0);

        $fonts = ['房', '子', ' ：', '洛', '杉', '矶', '霍', '尔', '姆', '比', '山', '庄', '园'];
        $this->addFontToImage($image, $fonts, 430, 230);

        $fonts = ['车', '子', ' ：', '科', '迈', '罗', 'RS', '限', '量', '版'];
        $this->addFontToImage($image, $fonts, 430, 285);

        $fonts = ['家', '庭', ' ：', '二', '十', '六', '岁', '结', '婚', '后', '得'];
        $this->addFontToImage($image, $fonts, 430, 340);

        $fonts = ['寿', '命', ' ：', '八', '十', '六', '岁'];
        $this->addFontToImage($image, $fonts, 430, 395);


        $this->addPortraitToImage($image);

        imagepng($image, DOCROOT . 'uploads/tmp/fates/sc_fate.jpg');
    }

    private function addFontToImage($image, $fonts, $startY, $x){
        $y = $startY;
        foreach ($fonts as $font){
            $y += 20;
            //$this->addTextToImage($image, $font, false, 18, $y, $x);
            $this->addTextToImage($image, $font, false, 15, $y, $x);
        }
    }

    /**
     * 添加头像至图片中
     *
     * @param $image
     */
    function addPortraitToImage($image){
        $portrait = DOCROOT . 'uploads/tmp/qrcode/1461322395.png';
        $portraitFile = imagecreatefromstring(file_get_contents($portrait));
        //头像尺寸
        $portraitWidth = imagesx($portraitFile);
        $portraitHeight = imagesy($portraitFile);

        //原图尺寸
        $imageWidth = 130;
        $imageHeight = 130;
        $x = 165;
        $y = 740;
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
     * @param $color	字体颜色
     * @param int $size 字体大小
     * @param int $y	y坐标
     * @param int $x    x坐标,当x为0时居中显示
     */
    function addTextToImage($image, $text, $color, $size = 0, $y = 0, $x = 0){

        $imageWidth = imagesx($image);

        $fontColor = imagecolorallocate($image, 0, 0, 0);
        if($color){
            $fontColor = $color;
        }

        //$font = '/Library/Fonts/Hannotate.ttc';
        //$font = '/Library/Fonts/Hanzipen.ttc';
        $font = '/Library/Fonts/Libian.ttc';

        if( ! $x){
            $fontBox = imagettfbbox($size, 0, $font, $text);
            $x = ceil(($imageWidth - $fontBox[2]) / 2);
        }


        imagettftext($image, $size, 0, $x, $y, $fontColor, $font, $text);
    }
}
?>