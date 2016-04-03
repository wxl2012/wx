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
 * 微信模板消息通知.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_MpTemplate extends Controller_BaseController
{

    public function action_register(){
        $params = [
            'first' => [
                'value' => '帐户注册成功!',
                'color' => '#D02090',
            ],
            'keyword1' => [
                'value' => 'admin',
                'color' => '#D02090',
            ],
            'keyword2' => [
                'value' => '18888888888',
                'color' => '#D02090',
            ],
            'keyword3' => [
                'value' => date('Y年m月d日 H时i分s秒'),
                'color' => '#D02090',
            ],
            'remark' => [
                'value' => '',
                'color' => '#D02090'
            ]
        ];

        $account = \Model_WXAccount::find(1);
        $to_openid = 'oqTo9uJao4vdZy5EZH8yQgL_0SY0';
        $tmpl_id = 'x8ykw2fHARq6QYKFWUJZjU3M6beYxoimtKJNWQWF4XQ';


        $tmpl = new \handler\mp\TemplateMsg($account, $to_openid, $tmpl_id, 'http://www.baidu.com');
        $result = $tmpl->send($params);
        if($result->errcode != 0){
            die('模板消息发送失败');
        }
        die('消息发送成功');
    }

    public function action_buy_success(){
        $params = [
            'first' => [
                'value' => '门票购买成功!',
                'color' => '#D02090',
            ],
            'info' => [
                'value' => '2排3桌',
                'color' => '#D02090',
            ],
            'code' => [
                'value' => \Str::random('alnum', 16),
                'color' => '#D02090',
            ],
            'time' => [
                'value' => date('Y年m月d日 H时i分s秒'),
                'color' => '#D02090',
            ],
            'product' => [
                'value' => '',
                'color' => '#D02090',
            ],
            'remark' => [
                'value' => '',
                'color' => '#D02090'
            ]
        ];

        $account = \Model_WXAccount::find(1);
        $to_openid = 'oqTo9uJao4vdZy5EZH8yQgL_0SY0';
        $tmpl_id = '7ZOy4MVISP9UeD23Lr2FAbJzJBSSC6-iNt91olEhPp4';


        $tmpl = new \handler\mp\TemplateMsg($account, $to_openid, $tmpl_id, 'http://www.baidu.com');
        $result = $tmpl->send($params);
        if($result->errcode != 0){
            die('模板消息发送失败');
        }
        die('消息发送成功');
    }


    public function action_delivery(){
        $params = [
            'first' => [
                'value' => '商品已发货!',
                'color' => '#D02090',
            ],
            'keyword1' => [
                'value' => date('YmdHis'),
                'color' => '#D02090',
            ],
            'keyword2' => [
                'value' => 100,
                'color' => '#D02090',
            ],
            'keyword3' => [
                'value' => '菊花茶,西湖龙井,豪华果盘,精品果盘,百威,哈尔滨啤酒,威尔士香槟',
                'color' => '#D02090',
            ],
            'keyword4' => [
                'value' => '2排2桌',
                'color' => '#D02090',
            ],
            'keyword5' => [
                'value' => '1号员工',
                'color' => '#D02090',
            ],
            'remark' => [
                'value' => '点击查看订单已使用状态',
                'color' => '#D02090'
            ]
        ];

        $account = \Model_WXAccount::find(1);
        $to_openid = 'oqTo9uJao4vdZy5EZH8yQgL_0SY0';
        $tmpl_id = 'kulOjNg1PT5gxUMZM6VV9GwjWCBdkw_xShlgPjzFM34';


        $tmpl = new \handler\mp\TemplateMsg($account, $to_openid, $tmpl_id, 'http://www.baidu.com');
        $result = $tmpl->send($params);
        if($result->errcode != 0){
            die('模板消息发送失败');
        }
        die('消息发送成功');
    }

    public function action_order_create(){
        $params = [
            'first' => [
                'value' => '订单支付成功',
                'color' => '#D02090',
            ],
            'keyword1' => [
                'value' => date('YmdHis'),
                'color' => '#D02090',
            ],
            'keyword2' => [
                'value' => '菊花茶,西湖龙井,豪华果盘,精品果盘,百威,哈尔滨啤酒,威尔士香槟',
                'color' => '#D02090',
            ],
            'keyword3' => [
                'value' => 100,
                'color' => '#D02090',
            ],
            'remark' => [
                'value' => '点击查看订单已使用状态',
                'color' => '#D02090'
            ]
        ];

        $account = \Model_WXAccount::find(1);
        $to_openid = 'oqTo9uJao4vdZy5EZH8yQgL_0SY0';
        $tmpl_id = 'tQ46mymM617VOKpNv6rbg5hBQpXIle8EC64n-ozbSSw';


        $tmpl = new \handler\mp\TemplateMsg($account, $to_openid, $tmpl_id, 'http://www.baidu.com');
        $result = $tmpl->send($params);
        if($result->errcode != 0){
            die('模板消息发送失败');
        }
        die('消息发送成功');
    }
}

?>