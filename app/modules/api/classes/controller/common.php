<?php
/**
 * 常用控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace api;

class Controller_Common extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    /**
     * 获取省份
     */
    public function action_region(){
        $id = \Input::get('id', false);
        if( ! $id){
            return $this->response(['status' => 'err', 'msg' => '缺少必要参数', 'errcode' => 0], 200);
        }

        $item = \Model_Region::find($id);

        $items = $item->children()->get();

        return $this->response(['status' => 'succ', 'msg' => '', 'errcode' => 0, 'data' => $items], 200);
    }
}
