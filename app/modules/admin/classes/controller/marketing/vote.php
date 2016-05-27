<?php
/**
 * 后台管理基础控制器
 *
 * @package  app
 * @extends  Controller
 */
namespace admin;

class Controller_Marketing_Vote extends Controller_BaseController
{
    public function before(){
        parent::before();

        \View::set_global(['controller_name' => '投票管理']);
    }

    public function action_index(){
        $params = array(
            'title' => "投票管理",
            'menu' => 'vote',
            'action_name' => '投票活动列表'
        );

        $params['items'] = \Model_Marketing::query()->where(['account_id' => \Session::get('WXAccount')->id])->get();

        \View::set_global($params);
        $this->template->content = \View::forge("ace/marketing/vote/index");
    }

    public function action_candidates($id = 0){
        $params = array(
            'title' => "被投项目管理",
            'menu' => 'vote',
            'action_name' => '被投项目列表'
        );

        if(\Input::method() == 'POST'){
            $data = \Input::post();
            $cid = $data['id'];
            unset($data['id']);
            $candidate = false;
            if($cid){
                $candidate = \Model_MarketingVoteCandidate::find($cid);
            }else{
                $candidate = \Model_MarketingVoteCandidate::forge();
            }
            $candidate->set($data);
            if($candidate->save()){
                die(json_encode(['status' => 'succ', 'msg' => '', 'errcode' => 0, 'data' => $candidate->to_array()]));
            }
        }

        $params['marketing'] = \Model_Marketing::find($id);
        $params['items'] = \Model_MarketingVoteCandidate::query()->where('marketing_id', $id)->get();

        \View::set_global($params);
        $this->template->content = \View::forge("ace/marketing/vote/candidates");
    }
}
