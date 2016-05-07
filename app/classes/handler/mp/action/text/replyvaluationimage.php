<?php

/**
 * 微信公众平台推送的文本消息处理类
 *
 * 生成图片
 *
 * @package    Fuel
 * @version    1.7
 * @author     Ray zyr.wxl@gmail.com
 * @license    MIT License
 * @copyright  2015 PMonkey Team
 * @link       http://mnzone.cn
 */
namespace handler\mp\action\text;

class ReplyValuationImage extends \handler\mp\action\Text {

    /**
     * 处理请求
     */
    public function handle(){
        $fileName = md5("{$this->data->FromUserName}{$this->data->Content}" .time());
        $span = DS;
        $fileName = DOCROOT . "uploads{$span}tmp{$span}valuation{$span}{$fileName}.jpg";

        //生成微信价值图片
        if( ! file_exists($fileName)){
            $result = $this->generateImage($fileName);
            if( ! $result){
                $this->reply_text('抱歉，命令丢失了，请您重新发送指令！');
            }
        }

        $media_id = false;
        $count = 0;
        do {
            try {
                $media_id = \Cache::get(md5($fileName));
            } catch (\CacheNotFoundException $e) {
                $this->account->checkToken();
                \handler\mp\Api::upload_media_tmp($this->account->temp_token, 'image', $fileName);
            }
            $count ++;
        }while ( ! $media_id && $count < 3);

        $this->reply_image($media_id);
    }

    private function generateImage($fileName){
        $image = imagecreatefromjpeg(DOCROOT . 'assets/img/valuation.jpg');

        $fontColor = imagecolorallocate($image, 255, 255, 255);
        $this->addTextToImage($image, $this->wechat->nickname, $fontColor, 40, 520);
        $this->addTextToImage($image, '您的帐户价格超越了 ' . (rand(0, 90)) . '% 的用户', $fontColor, 20, 580);
        $this->addTextToImage($image, '您的微信价值估测为', $fontColor, 20, 620);
        $this->addTextToImage($image, rand(100000, 99999999) . '.' . (rand(00, 99)) . '元', $fontColor, 20, 660);

        // 添加头像至图片
        $this->addPortraitToImage($image);
        // 添加二维码至图片
        $this->addQrcodeToImage($image);
        imagepng($image, $fileName);
        return true;
    }

    /**
     * 转换成圆图
     * @param $image
     * @param $output
     */
    private function convert_circle($output){
        if( ! $this->wechat->headimgurl){
            return false;
        }

        $file = \handler\mp\Wechat::getWechatHeadImage($this->wechat->headimgurl);
        \Image::load($file)
            ->rounded(\Image::sizes()->width / 2)
            ->save($output);
        return true;
    }

    /**
     * 添加头像至图片
     *
     * @param $image
     */
    function addPortraitToImage($image){
        //生成圆图
        $output = DOCROOT . 'uploads/tmp/valuation/head' . time() . '.png';
        if( ! $this->convert_circle($output)){
            return;
        }

        $portraitFile = imagecreatefromstring(file_get_contents($output));
        //头像尺寸
        $portraitWidth = imagesx($portraitFile);
        $portraitHeight = imagesy($portraitFile);

        //原图尺寸
        $imageWidth = 180;
        $imageHeight = 180;
        $x = 225;
        $y = 263;
        imagecopyresampled($image, $portraitFile, $x, $y, 0, 0, $imageWidth, $imageHeight, $portraitWidth, $portraitHeight);
    }

    /**
     * 添加二维码至图片中
     *
     * @param $image
     */
    function addQrcodeToImage($image){
        $portrait = DOCROOT . 'uploads/qrcode/shb.png';
        $portraitFile = imagecreatefromstring(file_get_contents($portrait));
        //头像尺寸
        $portraitWidth = imagesx($portraitFile);
        $portraitHeight = imagesy($portraitFile);

        //原图尺寸
        $imageWidth = 150;
        $imageHeight = 150;
        $x = 246;
        $y = 794;
        imagecopyresampled($image, $portraitFile, $x, $y, 0, 0, $imageWidth, $imageHeight, $portraitWidth, $portraitHeight);
    }

    /**
     * 添加文字至图片中
     *
     * @param $image    图片对象
     * @param $text     文字内容
     * @param $color    字体颜色
     * @param int $size 字体大小
     * @param int $y    y坐标
     * @param int $x    x坐标,当x为0时居中显示
     */
    function addTextToImage($image, $text, $color, $size = 0, $y = 0, $x = 0){

        $imageWidth = imagesx($image);

        $fontColor = imagecolorallocate($image, 0, 0, 0);
        if($color){
            $fontColor = $color;
        }

        //$font = '/Library/Fonts/Hannotate.ttc';
        $font = '/Library/Fonts/Hanzipen.ttc';
        //$font = realpath('D:\\wwwroot\\mnzone\\wwwroot\\assets\\fonts\\Libian.ttf');

        if( ! $x){
            $fontBox = imagettfbbox($size, 0, $font, $text);
            $x = ceil(($imageWidth - $fontBox[2]) / 2);
        }


        imagettftext($image, $size, 0, $x, $y, $fontColor, $font, $text);
    }

    /**
     * 回复一张图片
     *
     * @param $media_id 图片素材ID
     */
    private function reply_image($media_id){
        $response = new \handler\mp\Response($this->account, $this->data);
        $response->image($media_id);
    }

    private function reply_text($content){
        $response = new \handler\mp\Response($this->account, $this->data);
        $response->text($content);
    }
}