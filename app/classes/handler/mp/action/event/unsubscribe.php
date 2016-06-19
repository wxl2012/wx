<?php
/**
 * 微信公众平台推送的取消关注事件消息处理类
 *
 * @package    Fuel
 * @version    1.7
 * @author     Ray zyr.wxl@gmail.com
 * @license    MIT License
 * @copyright  2015 PMonkey Team
 * @link       http://mnzone.cn
 */
namespace handler\mp\action\event;

class UnSubscribe extends \handler\mp\action\Event {

    function __construct($argument = false)
    {
        # code...
    }

    function handle(){
        $where = [
            'openid' => $this->data->FromUserName,
        ];

        $result = \DB::delete("marketing_records")
            ->where($where)
            ->execute();

    }

}