<?php
/**
 * 默认控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace store;

class Controller_Home extends Controller_BaseController {

    public function before(){
        parent::before();
        \Auth::force_login(1);
    }

    public function action_index(){
        die('index');
    }

    public function action_register(){

        $employee = \Model_Employee::query()
            ->where(['user_id' => \Auth::get_user()->id, 'seller_id' => \Session::get('seller')->id])
            ->get_one();

        $store = false;

        if($employee){
            $store = \Model_Store::query()
                ->where(['seller_id' => \Session::get('seller')->id, 'manager_id' => $employee->id])
                ->get_one();
        }

        $create_flag = false;

        if(\Input::method() == 'POST'){
            $data = \Input::post();

            if( ! $employee){
                $employee = \Model_Employee::forge();
            }
            $employee->set([
                'user_id' => \Auth::get_user()->id,
                'seller_id' => \Session::get('seller')->id,
                'no' => time(),
                'work_tel' => $data['work_tel'],
                'work_phone' => $data['work_phone'],
            ]);

            if($employee->save()){
                if( ! $store){
                    $create_flag = true;
                    $store = \Model_Store::forge();
                }
                $store->set([
                    'manager_id' => $employee->id,
                    'seller_id' => \Session::get('seller')->id,
                    'no' => time(),
                    'name' => $data['name'],
                    'tel' => $data['tel'],
                    'phone' => $data['phone'],
                ]);

                if($store->save()){
                    if($create_flag){
                        //发送发货模板消息
                        $params = [
                            'first' => [
                                'value' => '您推荐的一个会员已成功申请店铺!',
                                'color' => '#D02090',
                            ],
                            'keyword1' => [
                                'value' => \Auth::get_user()->username,
                                'color' => '#D02090',
                            ],
                            'keyword2' => [
                                'value' => $data['work_phone'],
                                'color' => '#D02090',
                            ],
                            'keyword3' => [
                                'value' => date('Y年m月d日 H时i分s秒'),
                                'color' => '#D02090',
                            ],
                            'remark' => [
                                'value' => '',
                                'color' => '#D02090'
                            ]
                        ];
                        $this->sendMsgTemplate('x8ykw2fHARq6QYKFWUJZjU3M6beYxoimtKJNWQWF4XQ', $params, 'http://ticket.wangxiaolei.cn');
                    }
                }
            }

        }

        $params = [
            'employee' => $employee,
            'store' => $store,
            'people' => \Model_People::query()->where('parent_id', \Auth::get_user()->id)->get_one()
        ];

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/register");
    }

    /**
     * 发送模板消息
     *
     * @param $no           订单号
     * @param $title        订单标题
     * @param $total_fee    订单金额
     * @param $url          订单链接
     * @return bool
     */
    private function sendMsgTemplate($tmpl_id, $params, $url){
        $seller = \Session::get('seller', false);
        if( ! $seller
            || (isset($seller->is_send_template_msg) && ! $seller->is_send_template_msg)){
            $this->result_message = '商户未设置发送微信模板消息!';
            return false;
        }

        $account = \Session::get('WXAccount', false);
        $to_openid = $this->getParentWechatOpenid();

        $tmpl = new \handler\mp\TemplateMsg($account, $to_openid, $tmpl_id, $url);
        $result = $tmpl->send($params);
        if($result->errcode != 0){
            $this->result_message = '消息发送失败!';
            return false;
        }
    }

    /**
     * 获取当前用户的推荐人的微信OPENID
     * @return bool
     */
    private function getParentWechatOpenid(){
    return 'oqTo9uJao4vdZy5EZH8yQgL_0SY0';
        //获取上级用户
        $members = \Model_MemberRecommendRelation::parentMember(\Auth::get_user()->id);
        if( ! $members){
            return false;
        }
        $member = current($members);
        $to_openid = false;
        //获取上级用户的微信信息
        $wechat = \Model_Wechat::query()->where(['user_id' => $member->master_id])->get_one();
        //获取上级用户的微信OPENID
        foreach ($wechat->ids as $openid){
            if($openid->account_id == \Session::get('WXAccount')->id){
                $to_openid = $openid->openid;
            }
        }

        return $to_openid;
    }
}
