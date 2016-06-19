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
 * 控制器: 行政区域管理控制器
 * 功  能: 区域查询
 *
 * @package  app
 * @extends  Controller
 */
namespace calligrapher;

class Controller_Region extends Controller_BaseController {

    /**
     * 书法家首页控制器
     *
     * @access  public
     * @return  Response
     */
    public function action_index()
    {
        $region = \Model_Region::find(1);
        if(\Input::get('id', false)){
            $region = \Model_Region::find(\Input::get('id'));
        }
        $regions = $region->children()->get();

        $items = [];
        foreach($regions as $key => $value){
            array_push($items, $value->to_array());
        }
        die(json_encode(['status' => 'succ', 'msg' => '', 'data' => $items]));
    }
}
