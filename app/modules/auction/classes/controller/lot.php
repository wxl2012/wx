<?php
/**
 * 拍品控制器
 *
 * @package    auction
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace auction;

class Controller_Lot extends Controller_BaseController{

    /**
     * 拍品列表
     */
    public function action_index(){
        $params = [
            'title' => '我关注的'
        ];

        $params['items'] = \Model_Lot::query()->get();

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/lot/index");
    }

    /**
     * 推荐、精选
     */
    public function action_recommend(){
        $params = [
            'title' => '精选拍品'
        ];

        $params['items'] = \Model_Lot::query()->get();

        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/lot/index");
    }

    /**
     * 拍品详情
     */
    public function action_view($id = 0){

        $params = [
            'title' => '精选拍品'
        ];

        $params['item'] = \Model_Lot::find($id);

        \View::set_global($params);

        $this->template->content = \View::forge("{$this->theme}/lot/view");
    }
}