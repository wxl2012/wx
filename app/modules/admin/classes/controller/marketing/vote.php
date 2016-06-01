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

    public function action_save($id = 0){
        if(\Input::method() == 'POST'){
            $msg = ['status' => 'err', 'msg' => '', 'errcode' => 10];
            $data = \Input::post();
            $data['start_at'] = $data['start_at'] ? strtotime($data['start_at']) : 0;
            $data['end_at'] = $data['end_at'] ? strtotime($data['end_at']) : 0;
            $data['account_id'] = \Session::get('WXAccount')->id;
            $market = \Model_Marketing::find($id);
            if( ! $market){
                $market = \Model_Marketing::forge();
            }
            $market->limit = \Model_MarketingLimit::forge(['involved_total_num' => 1]);
            $market->set($data);
            if($market->save()){
                $msg = ['status' => 'succ', 'msg' => '', 'errcode' => 0, 'data' => $market->to_array()];
            }

            if(\Input::is_ajax()){
                die(json_encode($msg));
            }
            \Session::set_flash('msg', $msg);
        }
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

    public function action_candidate_delete($id = 0){

        $candidate = \Model_MarketingVoteCandidate::find($id);
        if($candidate && $candidate->delete()){
            die(json_encode(['status' => 'succ', 'msg' => '删除成功', 'errcode' => 0]));
        }

        die(json_encode(['status' => 'err', 'msg' => '删除失败', 'errcode' => 0]));
    }
}
