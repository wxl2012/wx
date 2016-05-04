<?php

/**
 * 微信公众平台推送的文本消息处理类
 *
 * @package    Fuel
 * @version    1.7
 * @author     Ray zyr.wxl@gmail.com
 * @license    MIT License
 * @copyright  2015 PMonkey Team
 * @link       http://mnzone.cn
 */
namespace handler\mp\action\text;

class ReplyFateImage extends \handler\mp\action\Text {

    /**
     * 处理请求
     */
    public function handle(){
        if(strpos($this->data->Content, '命运') !== false){
            $name = str_replace('命运', '', $this->data->Content);
            $fileName = md5("{$this->data->FromUserName}{$name}");
            $fileName = DOCROOT . "uploads/tmp/fates/{$fileName}.jpg";

            //生成命运图片
            if( ! file_exists($fileName)){
                $result = $this->generateImage($name, rand(80, 99), $fileName);
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
    }

    private function generateImage($name, $age, $fileName){
        $image = imagecreatefromjpeg(DOCROOT . 'assets/img/fate.jpg');

        $fontColor = imagecolorallocate($image, 255, 0, 0);
        $this->addTextToImage($image, $age, $fontColor, 100, 255, 250);
        $this->addTextToImage($image, "岁", $fontColor, 20, 260, 370);
        $this->addTextToImage($image, "{$name}的命运是", $fontColor, 18, 380, 0);
        $this->addTextToImage($image, "活到{$age}岁", $fontColor, 18, 400, 0);

        $fonts = array_merge(['房', '子', ' ：'], $this->getHouses());
        $this->addFontsToImage($image, $fonts, 430, 230);

        $fonts = array_merge(['车', '子', ' ：'], $this->getCars());
        $this->addFontsToImage($image, $fonts, 430, 285);

        $fonts = array_merge(['家', '庭', ' ：'], $this->numberToChar(rand(20, 38)), ['岁', '结', '婚', '后', '得']);
        $this->addFontsToImage($image, $fonts, 430, 340);

        $fonts = array_merge(['寿', '命', ' ：'], $this->numberToChar($age), ['岁']);
        $this->addFontsToImage($image, $fonts, 430, 395);


        $this->addQrcodeToImage($image);

        imagepng($image, $fileName);
        return true;
    }

    private function numberToChar($age){
        $units = ['零', '一', '二', '三', '四', '五', '六', '七', '八', '九'];
        $str = sprintf('%d', $age);

        if($age > 100){
            $str = intval($str[1]) == 0 ? "{$units[$str[0]]},百,零,{$units[$str[2]]}" : "{$units[$str[0]]},百,{$units[$str[1]]},十,{$units[$str[2]]}";
        }else if($age % 10 == 0){
            $str = $units[($age / 10)] . ',十';
        }else if($age > 9){
            $str = "{$units[$str[0]]},十,{$units[$str[1]]}";
        }else{
            $str = $units[$str[0]];
        }

        return explode(',', $str);
    }

    /**
     * 添加字体到图片中
     *
     * @param $image    图片对象
     * @param $fonts    字符串数组
     * @param $startY   起始Y坐标
     * @param $x        x坐标
     */
    private function addFontsToImage($image, $fonts, $startY, $x){
        $y = $startY;
        foreach ($fonts as $font){
            $y += 20;
            //$this->addTextToImage($image, $font, false, 18, $y, $x);
            $this->addTextToImage($image, $font, false, 15, $y, $x);
        }
    }

    /**
     * 添加二维码至图片中
     *
     * @param $image
     */
    function addQrcodeToImage($image){
        $portrait = DOCROOT . 'assets/img/qrcode.png';
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
        //$font = '/Library/Fonts/Hanzipen.ttc';
        $font = realpath('D:\\wwwroot\\mnzone\\wwwroot\\assets\\fonts\\Libian.ttf');

        if( ! $x){
            $fontBox = imagettfbbox($size, 0, $font, $text);
            $x = ceil(($imageWidth - $fontBox[2]) / 2);
        }


        imagettftext($image, $size, 0, $x, $y, $fontColor, $font, $text);
    }

    /**
     * 随机获取一套房子
     * @return mixed
     */
    private function getHouses(){
        $houses = [
            explode(',', '吸,血,鬼,城,堡'),
            explode(',', '维,多,利,亚,别,墅'),
            explode(',', '巅,峰,园'),
            explode(',', '费,尔,菲,尔,德,豪,宅'),
            explode(',', '郝,斯,特,山,庄'),
            explode(',', '海,德,公,园,一,号'),
            explode(',', '安,提,拉'),
            explode(',', '利,奥,波,德,别,墅'),
            explode(',', '爱,敦,阁')
        ];
        return $houses[rand(0, count($houses) - 1)];
    }

    /**
     * 随机获取一辆汽车
     * @return mixed
     */
    private function getCars(){
        $houses = [
            explode(',', '科,迈,罗,RS,限,量,版'),
            explode(',', '法,拉,利,458'),
            explode(',', '凯,迪,拉,克,XT5'),
            explode(',', '劳,斯,莱,斯,幻,影'),
            explode(',', '世,爵,C8'),
            explode(',', '宾,利,欧,陆'),
            explode(',', '迈,巴,赫,s600'),
            explode(',', '帕,加,尼,Huayra'),
            explode(',', '布,加,迪,威,航')
        ];
        return $houses[rand(0, count($houses) - 1)];
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