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
 * 模  块: 书法名字数据库模块
 * 控制器: 书法家查询控制器
 * 功  能: 书法家查询,书法家列表,书法家详情等操作
 *
 * @package  app
 * @extends  Controller
 */
namespace calligrapher;

class Controller_Home extends Controller_BaseController
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
        if($keyword){
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
        }


        $this->template->title = '书法名家数据库';
        $this->template->content = \View::forge("{$this->theme}/index");
    }

    /**
     * 查看书法家详情
     * @param int $id 书法家ID
     */
    public function action_view($id = 0){

        $params['item'] = \Model_Calligrapher::find($id);
        \View::set_global($params);

        $this->template->title = '书法名家数据库';
        $this->template->content = \View::forge("{$this->theme}/view");
    }
}
