<?php
/**
 * 微信公众平台推送的关注事件消息处理类
 *
 * @package    Fuel
 * @version    1.7
 * @author     Ray zyr.wxl@gmail.com
 * @license    MIT License
 * @copyright  2015 PMonkey Team
 * @link       http://mnzone.cn
 */
namespace handler\mp\action;

class Subscribe extends Event {

    private $event_type;
    private $qrcode_key;

    function __construct($argument = false)
    {
        $this->event_type = $argument;
    }

    public function handle(){
        if(isset($this->data->EventKey) && isset($this->data->Ticket)){
            $this->qrcode_key = str_replace('qrscene_', '', $this->data->EventKey);
            //扫码关注
            if($this->event_type == 'SCAN'){
                $this->subscribe_scan();
            }else{
                $this->none_scan();
            }
        }else{
            //正常关注
            $this->normal();
        }
    }

    /**
     * 扫码关注操作（未关注）
     */
    private function none_scan(){
        \Log::error("未关注时的扫码关注操作:none_scan()");

        $result = \Model_MemberRecommendRelation::addRelation($this->qrcode_key, $this->wechat->user_id, 2);
        \Log::error($result ? '推荐关系已建立' : '推荐关系创建失败');
    }

    /**
     * 扫码关注操作（已关注）
     */
    private function subscribe_scan(){
        \Log::error("已关注时的扫码关注操作:subscribe_scan()");
        $result = \Model_MemberRecommendRelation::addRelation($this->qrcode_key, $this->wechat->user_id, 2);
        \Log::error($result ? '推荐关系已建立' : '推荐关系创建失败');
    }

    /**
     * 正常关注操作
     */
    private function normal(){
        \Log::error("正常关注操作:normal()");
    }

}