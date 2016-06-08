<?php
/**
 * 投票控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace marketing;

class Controller_Vote extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    public function action_rank(){

        $id = \Input::get('id', false);

        if( ! $id){
            die('');
        }

        $params = [
            'title' => '评选排行榜'
        ];

        $vote = \Model_Marketing::find($id);

        if( ! $vote){
            \Session::set_flash('msg', ['status' => 'err', 'msg' => '活动不存在', 'errcode' => 10]);
            return $this->show_message();
        }

        $params['items'] = \Model_MarketingVoteCandidate::query()
            ->where('marketing_id', $id)
            ->order_by(['total_gain' => 'desc'])
            ->get();
        $params['vote'] = $vote;
        
        \View::set_global($params);

        $this->template->content = \View::forge("{$this->theme}/vote/statistics_candidates");
    }
}
