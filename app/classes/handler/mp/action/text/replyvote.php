<?php

/**
 * 微信公众平台推送的文本消息处理类
 *
 * 投票
 *
 * @package    Fuel
 * @version    1.7
 * @author     Ray zyr.wxl@gmail.com
 * @license    MIT License
 * @copyright  2015 PMonkey Team
 * @link       http://mnzone.cn
 */
namespace handler\mp\action\text;

class ReplyVote extends \handler\mp\action\Text {

    /**
     * 处理请求
     */
    public function handle(){
        if( ! is_numeric($this->data->Content)){
            return false;
        }

        $candidate = \Model_MarketingVoteCandidate::query()
            ->where('no', $this->data->Content)
            ->or_where('keyword', $this->data->Content)
            ->get_one();

        if( ! $candidate){
            $this->reply_text('抱歉，该编码不存在！');
        }

        $market = $candidate->vote->parent;
        $statistic = \Model_MarketingRecordStatistic::query()
            ->where(['openid' => $this->data->FromUserName, 'marketing_id' => $market->id])
            ->get_one();

        if($statistic && $market->limit){
            if($market->limit->involved_total_num && $market->limit->involved_total_num <= $statistic->total_num){
                $this->reply_text("您最多能投{$market->limit->involved_total_num}次票!");
            }
        }

        # 新增参与明细
        $record = \Model_MarketingRecord::forge([
            'openid' => $this->data->FromUserName,
            'marketing_id' => $market->id,
            'target_id' => $candidate->id,
            'updated_at' => time()
        ]);
        $record->save();

        $candidate->total_gain += 1;

        $this->reply_text("投票成功，{$candidate->no}号选手{$candidate->title}加1票，现总票数为{$candidate->total_gain}票，谢谢！");
    }

    private function reply_text($content){
        $response = new \handler\mp\Response($this->account, $this->data);
        $response->text($content);
    }
}