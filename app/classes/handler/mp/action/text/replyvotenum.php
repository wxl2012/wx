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

class ReplyVoteNum extends \handler\mp\action\Text {

    /**
     * 处理请求
     */
    public function handle(){
        $keyword = str_replace('查询', '', $this->data->Content);
        $candidate = \Model_MarketingVoteCandidate::query()
            ->where('account_id', $this->account->id)
            ->and_where_open()
            ->where('no', $keyword)
            ->or_where('keyword', $keyword)
            ->and_where_close()
            ->get_one();

        if( ! $candidate){
            $this->reply_text('抱歉，该选手不存在！');
        }

        $this->reply_text("{$candidate->no}号选手{$candidate->title}，总票数为{$candidate->total_gain}票");
    }

    private function reply_text($content){
        $response = new \handler\mp\Response($this->account, $this->data);
        $response->text($content);
    }
}