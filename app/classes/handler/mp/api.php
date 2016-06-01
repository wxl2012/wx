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
        
        $obj = json_decode($result->body);

        if( ! isset($obj->media_id)){
            return false;
        }

        \Cache::set(md5($media), $obj->media_id, 60 * 60 * 24 * 3);
        return $obj->media_id;
    }

    /**
     * 调用微信公众帐户“创建二维码ticket”接口
     *
     * @param $account 公众号信息
     * @param $scene_id 二维码携带的参数
     * @param $scope [temp | limit]，二维码类型 临时或永久
     * @return json格式的字符串
     * Example:
     *     以下为永久二维码调用方式：
     * 			\impls\wechat\Common::generate_qrcode_ticket('abc123', 'limit')
     * 			\impls\wechat\Common::generate_qrcode_ticket(1, 'limit') //取值范围1 - 100000
     *	  以下为临时二维码调用方式：
     *			\impls\wechat\Common::generate_qrcode_ticket(1) //取值范围 32位正整数
     * return:
     *     {
     *		    "ticket": "gQH47joAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2taZ2Z3TVRtNzJXV1Brb3ZhYmJJAAIEZ23sUwMEmm3sUw==",
     *		    "expire_seconds": 60, // 二维码有效期，单位：秒,
     *		    "url": "http://weixin.qq.com/q/kZgfwMTm72WWPkovabbI" //二维码解析后的地址
     *		}
     */
    public static function generate_qrcode_ticket($account, $scene_id, $scope = 'temp'){

        $params = array(
            'expire_seconds' => 2592000,
            'action_name' => 'QR_SCENE',
            'action_info' => array(
                'scene' => array(
                    'scene_id' => $scene_id
                )
            )
        );

        if($scope == 'limit'){
            $scene = array();
            $scene[is_numeric($scene_id) ? 'scene_id' : 'scene_str'] = $scene_id;

            $params = array(
                'action_name' => is_numeric($scene_id) ? 'QR_LIMIT_SCENE' : 'QR_LIMIT_STR_SCENE',
                'action_info' => array(
                    'scene' => $scene
                )
            );
        }

        $account->checkToken();

        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=" . \Session::get('WXAccount')->temp_token;
        $result = \handler\common\UrlTool::request($url, 'POST', json_encode($params));
        return $result->body;
    }

    /**
     * 生成自定义菜单
     *
     * @param $token 访问Token
     * @param $menu 菜单json串
     */
    public static function generate_coustom_menu($token, $menu){
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$token}";
        return \handler\common\UrlTool::request($url, 'POST', $menu);
    } 

    /**
     * 同步本地与微信服务器素材
     *
     * @param $access_token 微信公众号access_token
     * @throws \Exception
     */
    public static function syn_material($access_token){
        # 获取素材总数
        $url = "https://api.weixin.qq.com/cgi-bin/material/get_materialcount?access_token={$access_token}";
        $result = \handler\common\UrlTool::request($url);
        $result = json_decode($result->body);

        # 计算分页数量
        $pageTotal = intval(($result->news_count + (20 - 1)) / 20);

        $account_id = \Session::get('WXAccount')->id;
        # 删除当前公众号下所有素材
        \DB::delete('wx_accounts_mp_materials')
            ->where(['account_id' => $account_id, 'menu_keyword' => ''])
            ->execute();

        # 重新获取最新素材
        for($i = 0; $i < $pageTotal; $i ++){
            $data = [
                'type' => 'news',
                'offset' => $i * 20,
                'count' => 20
            ];
            $url = "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token={$access_token}";
            $result = \handler\common\UrlTool::request($url, 'POST', json_encode($data));
            $items = json_decode($result->body)->item;
            foreach ($items as $item){
                $url = "https://api.weixin.qq.com/cgi-bin/material/get_material?access_token={$access_token}";
                $result = \handler\common\UrlTool::request($url, 'POST', json_encode(['media_id' => $item->media_id]));
                $result = json_decode($result->body, true);
                foreach ($result['news_item'] as $data){
                    $data['account_id'] = \Session::get('WXAccount')->id;
                    $data['create_time'] = $result['create_time'];
                    $data['update_time'] = $result['update_time'];
                    $data['updated_at'] = time();
                    $data['thumb_media_id'] = $item->media_id;
                    $material = \Model_WXAccountMpMaterial::find($item->media_id);
                    if(! $material){
                        $material = \Model_WXAccountMpMaterial::forge($data);
                    }else{
                        $material->set($data);
                    }
                    $material->save();
                    break;
                }
            }
        }
    }
}

?>