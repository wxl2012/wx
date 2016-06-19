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
 * 微信粉丝帐户相关操作
 *
 * 微信粉丝相关辅助类
 *
 * @package  app
 * @extends  Controller
 */
namespace handler\mp;

class Account {

    function __construct($argument)
    {
        # code...
    }

    /**
     * 根据微信推送的包，创建相关帐户信息
     *
     * @param $openid 微信服务器推送的微信粉丝OpenId
     * @param $account 接受微信服务器推送数据的公众号实体对象
     * @return 创建成功返回微信OpenId数据对象,否则返回False
     */
    public static function createWechatAccount($openid, $account = false){

        if( ! $account){
            return false;
        }

        //创建微信信息
        $wechat = \Model_Wechat::forge([
            'nickname' => $openid
        ]);

        //是否创建用户登录信息
        if(isset($account->is_subscribe_create_user) && $account->is_subscribe_create_user){
            $params = [
                'username' => "wx_{$openid}",
                'password' => "w{$account->id}#{$openid}",
                'email' => "wx_{$openid}@{$account->id}.com",
                'group_id' => isset($account->create_user_default_group) ? $account->create_user_default_group : 0
            ];
            $user_id = \Model_User::createUser($params);
            if( ! $user_id){
                return false;
            }
            
            $wechat->user_id = $user_id;
            
            $params = [
                'parent_id' => $user_id,
                'user_id' => $user_id
            ];
            $people = \Model_People::query()->where($params)->get_one();
            if(! $people){
                $people = \Model_People::forge($params);
                $people->save();
            }

            //是否创建会员信息
            if(isset($account->is_subscribe_create_member) && $account->is_subscribe_create_member){
                $params = [
                    'user_id' => $user_id,
                    'seller_id' => $account->seller_id
                ];
                $member = \Model_Member::query()->where($params)->get_one();
                if( ! $member){
                    $params['no'] = "{$account->seller_id}{$wechat->user_id}" . time();
                    $member = \Model_Member::forge($params);
                    $member->save();
                }
            }

        }

        $wechatOpenid = \Model_WechatOpenid::query()->where('openid', $openid)->get_one();
        if($wechatOpenid){
            return $wechatOpenid;
        }

        //创建微信OpenID记录
        $params = [
            'openid' => $openid,
            'account_id' => $account->id
        ];
        $wechatOpenid = \Model_WechatOpenid::forge($params);
        $wechat->ids = [$wechatOpenid];

        $wechat->save();

        return $wechatOpenid;
    }


}