<?php
/**
 * 文件管理控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace api;

class Controller_FileManager extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    /**
     * 所有图片
     */
    public function action_images(){
        $items = \Model_Attachment::query()
            ->where(['seller_id' => $this->seller->id, 'type' => 'image']);

        $count = $items->count();
        $config = array(
            'pagination_url' => "/api/filemanager/images",
            'total_items'    => $count,
            'per_page'       => \Input::get('count', 15),
            'uri_segment'    => "start",
            'show_first'     => true,
            'show_last'      => true,
            'name'           => 'bootstrap3_cn'
        );

        $pagination = new \Pagination($config);
        $params = ['status' => 'succ', 'msg' => 'ok', 'errcode' => 0];
        $params['pagination'] = $pagination;
        $params['data'] = $items
            ->rows_offset($pagination->offset)
            ->rows_limit($pagination->per_page)
            ->get();

        $this->response($params, 200);
    }
}
