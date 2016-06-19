<?php
/**
 * 菜品控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace api;

class Controller_Dish extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    /**
     * 菜品列表
     */
    public function action_list(){

        $items = \Model_Dish::query()
            ->related('goods')
            ->where([
                'goods.is_deleted' => 0,
            ])
            ->and_where_open()
            ->where('goods.published_at', 0)
            ->or_where('goods.published_at', '<', time())
            ->and_where_close()
            ->and_where_open()
            ->where('goods.expire_at', 0)
            ->or_where('goods.expire_at', '>', time())
            ->and_where_close();

        //分页查询
        $count = $items->count();
        $config = array(
            'pagination_url' => "/api/dish/list",
            'total_items'    => $count,
            'per_page'       => \Input::get('count', 10),
            'uri_segment'    => 'start',
            'show_first'     => true,
            'show_last'      => true,
            'name'           => 'bootstrap3_cn' . (\Input::is_ajax() ? '_ajax' : '')
        );

        $pagination = new \Pagination($config);

        $items->order_by(['goods.sort' => 'desc', 'goods.created_at' => 'desc', 'goods.id' => 'desc']);
        $list = $items
            ->rows_offset($pagination->offset)
            ->rows_limit($pagination->per_page)
            ->get();
        foreach ($list as $dish){
            $dish->goods->category;
        }

        return $this->response(['status' => 'succ', 'msg' => '', 'errcode' => 0, 'data' => $list, 'total_page' => $pagination->__get('total_pages'), 'current_page' => $pagination->__get('current_page') ? $pagination->__get('current_page') : 1], 200);
    }
}
