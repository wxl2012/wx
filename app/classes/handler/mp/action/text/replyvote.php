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

        $item = false;

        //获取被投票人数据
        $key = "candidates{$this->account->id}";
        $candidates = \Cache::get($key);
        foreach ($candidates as $itemKey => $candidate){
            if($candidate->no == $this->data->Content
                || $candidate->keyword == $this->data->Content){
                $item = $candidate;
                break;
            }
        }

        if( ! $item){
            $this->reply_text('抱歉，该编号的选手不存在，回复“查询+编号”如“查询209”,查询其他选手成绩。');
        }

        $market = \Cache::get("marketing_{$item->marketing_id}");

        if($market->start_at > time() || $market->end_at < time()){
            $this->reply_text('抱歉，该编号的选手不在开放时间段，该选手总票数为:' . $item->total_gain);
        }

        //获取参与情况
        $statistic = false;
        try {
            $statistic = \Cache::get("{$this->data->FromUserName}{$market->id}");
        } catch (\CacheNotFoundException $e) {
            $statistic = \Model_MarketingRecordStatistic::forge([
                'openid' => $this->data->FromUserName,
                'marketing_id' => $market->id
            ]);
        }

        //检查参与数量
        if($statistic && $market->limit){
            if($market->limit->involved_total_num && $market->limit->involved_total_num <= $statistic->total_num){
                $this->reply_text("您最多只能投{$market->limit->involved_total_num}次票，回复“查询+编号”如“查询209”,查询其他选手成绩。");
            }
        }

        //保存参与次数统计
        $statistic->day_num += 1;
        $statistic->total_num += 0;
        \Cache::set("{$this->data->FromUserName}{$market->id}", $statistic, 365);

        //记录被投票项数量
        $item->total_gain += 1;
        $candidates[$itemKey] = $item;
        \Cache::set($key, $candidates, 365);

        $this->reply_text("投票成功，{$item->no}号选手{$item->title}票数加1，总票数为{$item->total_gain}票!\n\n回复“查询+编号”如“查询209”,查询其他选手成绩。");
    }

    private function reply_text($content){
        $response = new \handler\mp\Response($this->account, $this->data);
        $response->text($content);
    }
}