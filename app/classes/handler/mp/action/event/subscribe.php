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
namespace handler\mp\action\event;

class Subscribe extends \handler\mp\action\Event {

    private $event_type;
    private $qrcode_key;

    function __construct($eventType = false, $qrkey = false)
    {
        $this->event_type = $eventType;
        $this->qrcode_key = $qrkey;
    }

    public function handle(){

        if($this->event_type == 'SCAN'){
            $this->scan();  //关注状态下扫码
        }else if($this->event_type == 'subscribe'){
            $this->subscribe();    //未关注状态下扫码或正常关注
        }
    }

    /**
     * 扫码操作
     */
    private function scan(){
        $result = \Model_MemberRecommendRelation::addRelation($this->qrcode_key, $this->wechat->user_id, 2);
        \Log::error($result ? '推荐关系已建立' : '推荐关系创建失败');
    }

    /**
     * 关注操作
     */
    private function subscribe(){

        //是否扫码关注
        if($this->qrcode_key){
            $result = \Model_MemberRecommendRelation::addRelation($this->qrcode_key, $this->wechat->user_id, 2);
        }

        

    }

}