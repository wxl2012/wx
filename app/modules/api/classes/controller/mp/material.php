<?php
/**
 * 微信公众平台素材管理控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace api;

class Controller_MP_Material extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    /**
     * 素材列表
     */
    public function action_index(){
        $id = \Input::get('id', false);
        if( ! $id){
            return $this->response(['status' => 'err', 'msg' => '缺少必要参数', 'errcode' => 0], 200);
        }

        $items = \Model_WXAccountMpMaterial::query()
            ->where('account_id', $id);

        $count = $items->count();
        $config = array(
            'pagination_url' => "/api/mp/material",
            'total_items'    => $count,
            'per_page'       => \Input::get('count', 10),
            'uri_segment'    => 'start',
            'show_first'     => true,
            'show_last'      => true,
            'name'           => 'bootstrap3_cn' . (\Input::is_ajax() ? '_ajax' : '')
        );

        $pagination = new \Pagination($config);
        $params['pagination'] = (string)$pagination;
        $params['data'] = $items
            ->rows_offset($pagination->offset)
            ->rows_limit($pagination->per_page)
            ->get();

        return $this->response(array_merge(['status' => 'succ', 'msg' => '', 'errcode' => 0], $params), 200);
    }
}
