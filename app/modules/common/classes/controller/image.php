<?php
/**
 * 图片控制器
 *
 * @package    admin
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

/**
 * 本控制器主要用于：
 * @extends   \Controller_Base
 */
namespace common;

class Controller_Image extends Controller_BaseController{

    public function action_index(){
        die();
    }

    /**
     * 生成二维码
     *
     * @param content 生成二维码的内容
     * @param errLevel 容错级别 取值范围 L、M、Q、H
     * @param size 生成图片大小 取值范围 1 ~ 10
     * @param outtype 输出类型
     */
    public function action_qr(){
        $data = \Input::get();
        $user_id = \Auth::check() ? \Auth::get_user()->id : 0;
        $time = time();

        $errLevel = \Input::get('level', 'L');
        $size = \Input::get('size', 10);

        //添加LOGO
        //$logo_file = DOCROOT . 'uploads/images/demo/mall/icon.jpg';
        $logo_file = false;
        //指定输出目录
        $output_path = '/uploads' . (\Auth::check() ? '/' . \Auth::get_user()->id : '') . '/images/qrcodes/' . date('Ymd');
        //指定文件名称
        $image = "qrcode_{$time}_{$user_id}.png";

        //检测目录是否存在，并创建目录
        $qr_path = DOCROOT . "{$output_path}";
        if( ! file_exists($qr_path)){
            $temp = DOCROOT;
            foreach (explode('/', $output_path) as $key => $value) {
                $temp .= "/{$value}";
                if( ! file_exists($temp)){
                    mkdir($temp);
                }
            }
        }
        $qr_path = "{$qr_path}/{$image}";

        \QRcode::png($data['content'], $qr_path, $errLevel, $size, 2);

        $QR = imagecreatefromstring(file_get_contents($qr_path));

        if($logo_file){
            $logo = imagecreatefromstring(file_get_contents($logo_file));
            $QR_width = imagesx($QR);//二维码图片宽度
            $QR_height = imagesy($QR);//二维码图片高度

            $logo_width = imagesx($logo);//logo图片宽度
            $logo_height = imagesy($logo);//logo图片高度

            $logo_qr_width = $QR_width / 5;
            $scale = $logo_width / $logo_qr_width;
            $logo_qr_height = $logo_height / $scale;

            $from_width = ($QR_width - $logo_qr_width) / 2;
            //重新组合图片并调整大小
            imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
                $logo_qr_height, $logo_width, $logo_height);
        }

        if( ! isset($data['outtype']) || $data['outtype'] == 'file'){
            imagepng($QR, $qr_path);
            echo "<img src='{$output_path}/{$image}'>";
        }else if($data['outtype'] == 'browser'){
            imagepng($QR);
        }else if($data['outtype'] == 'url'){
            echo "{$output_path}/{$image}";
        }
    }
}