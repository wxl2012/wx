<?php
/**
 * 基于FuelPHP的微信第三方程序库
 *
 * @package    Fuel
 * @version    1.7
 * @author     Ray zyr.wxl@gmail.com
 * @license    MIT License
 * @copyright  2015 PMonkey Team
 * @link       http://mnzone.cn
 */

/**
 *
 * @package  app
 * @extends  Controller
 */

namespace admin;

class Controller_Calligrapher extends \Controller_Base
{

    /**
     * 书法家首页控制器
     *
     * @access  public
     * @return  Response
     */
    public function action_index()
    {
        $keyword = \Input::get('keyword', false);
        $items = \Model_Calligrapher::query()
            ->related(['country', 'province', 'city', 'county']);
        if($keyword){
            $items->or_where('country.name', 'like', $keyword);
            $items->or_where('province.name', 'like', $keyword);
            $items->or_where('city.name', 'like', $keyword);
            $items->or_where('county.name', 'like', $keyword);
            $items->or_where('name', 'like', $keyword);
        }
        $params['items'] = $items->get();
        \View::set_global($params);
        $this->template->title = '书法名家数据库';
        $this->template->content = \View::forge("{$this->theme}/calligrapher/index");
    }

    /**
     * 查看书法家详情
     * @param int $id 书法家ID
     */
    public function action_view($id = 0){

        $params['item'] = \Model_Calligrapher::find($id);
        \View::set_global($params);

        $this->template->title = '书法名家数据库';
        $this->template->content = \View::forge("{$this->theme}/calligrapher/view");
    }

    /**
     * 保存书法家信息
     * @param int $id 书法家ID
     */
    public function action_save($id = 0){

        $item = \Model_Calligrapher::find($id);
        if(\Input::method() == 'POST'){
            $msg = ['status' => 'succ', 'msg' => '', 'errcode' => 0];
            $data = \Input::post();
            $data['birthday'] = $data['birthday'] ? strtotime($data['birthday']) : 0;
            if( ! $item){
                $item = \Model_Calligrapher::forge($data);
            }

            $item->set($data);

            if($item->save()){
                \Session::set_flash('msg', $msg);
            }
        }

        $params['item'] = $item;
        \View::set_global($params);

        $this->template->title = '书法名家数据库';
        $this->template->content = \View::forge("{$this->theme}/calligrapher/details");
    }
}
