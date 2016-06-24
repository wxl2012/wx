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

    /**
     * 投票列表
     */
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

    /**
     * 编辑保存被投票项目
     * @param int $id
     * @throws \Exception
     * @throws \FuelException
     */
    public function action_save($id = 0){
        if(\Input::method() == 'POST'){
            $msg = ['status' => 'err', 'msg' => '', 'errcode' => 10];
            $data = \Input::post();
            $data['start_at'] = $data['start_at'] ? strtotime($data['start_at']) : 0;
            $data['end_at'] = $data['end_at'] ? strtotime($data['end_at']) : 0;
            $data['account_id'] = \Session::get('WXAccount')->id;
            $data['seller_id'] = \Session::get('WXAccount')->seller_id;
            $data['type'] = 'VOTE';
            $market = \Model_Marketing::find($id);
            if( ! $market){
                $market = \Model_Marketing::forge();
            }
            $market->set($data);

            if($market->save()){
                $limit = \Model_MarketingLimit::forge(['involved_total_num' => 1, 'marketing_id' => $market->id]);
                $limit->save();
                $msg = ['status' => 'succ', 'msg' => '', 'errcode' => 0, 'data' => $market->to_array()];
            }

            if(\Input::is_ajax()){
                die(json_encode($msg));
            }
            \Session::set_flash('msg', $msg);
        }
    }

    /**
     * 查看某投票活动下的所有被投票项目
     *
     * @param int $id
     * @throws \Exception
     * @throws \FuelException
     */
    public function action_candidates($id = 0){
        $params = array(
            'title' => "被投项目管理",
            'menu' => 'vote',
            'action_name' => '被投项目列表'
        );

        if(\Input::method() == 'POST'){
            $data = \Input::post();
            $data['account_id'] = \Session::get('WXAccount')->id;
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

    /**
     * 删除被投票项目
     *
     * @param int $id
     * @throws \Exception
     */
    public function action_candidate_delete($id = 0){

        $candidate = \Model_MarketingVoteCandidate::find($id);
        if($candidate && $candidate->delete()){
            die(json_encode(['status' => 'succ', 'msg' => '删除成功', 'errcode' => 0]));
        }

        die(json_encode(['status' => 'err', 'msg' => '删除失败', 'errcode' => 0]));
    }

    /**
     * 将mysql数据同步至redis缓存中
     */
    public function action_syn_redis(){

        /*$items = \Model_Marketing::query()->where(['account_id' => \Session::get('WXAccount')->id])->get();


        foreach ($items as $item) {
            //同步活动数据
            $key = "marketing_{$item->id}";
            \Cache::set($key, [
                'id' => $item->id,
                'start_at' => $item->start_at,
                'end_at' => $item->end_at,
                'involved_total_num' => $item->limit->involved_total_num
            ]);
            //同步被投票项数据
            foreach ($item->candidates as $candidate){
                \Cache::set(md5("candidate_{$candidate->no}"), [
                    'id' => $candidate->no,
                    'total_gain' => $candidate->total_gain,
                    'name' => $candidate->title,
                    'marketing' => $item->id,
                ]);

            }
        }

        //同步投票数据
        $items = \Model_MarketingRecordStatistic::query()->get();
        foreach ($items as $item){
            $key = md5("record_{$item->openid}_{$candidate->marketing_id}");
            \Cache::set($key, [
                'openid' => $item->openid,
                'marketing' => $item->marketing_id,
                'total_num' => $item->total_num
            ]);
        }

        die(json_encode(['status' => 'succ']));*/
    }
}
