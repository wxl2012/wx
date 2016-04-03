<?php
/**
 * 购物车控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace api;

class Controller_Trolley extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    /**
     * 获取购物车信息
     */
    public function action_index(){

        $list = \Model_Trolley::query();
        if(\Input::get('ids', false)){
            $list->where('id', 'IN', \Input::get('ids'));
        }
        $items = $list->where([
            'user_id' => $this->user->id,
            'store_id' => $this->store ? $this->store->id : 0
        ])->get();

        foreach ($items as $item){
            $item->goods;
        }
        return $this->response(['status' => 'succ', 'msg' => '', 'errcode' => 0, 'data' => $items], 200);
    }

    /**
     * 向购物车中添加商品
     */
    public function action_add_item(){
        if(\Input::method() == 'POST'){
            $msg = ['status' => 'err', 'msg' => '', 'errcode' => 10];
            $data = \Input::post();

            $data['store_id'] = $this->store->id;

            $trolley = \Model_Trolley::query()
                ->where([
                    'user_id' => $this->user->id,
                    'goods_id' => $data['goods_id'],
                    'store_id' => $data['store_id']
                ]);

            $item = $trolley->get_one();

            if( ! $item){
                $item = \Model_Trolley::forge();
            }

            $item->set($data);

            if($item->save()){
                $msg = ['status' => 'succ', 'msg' => '', 'errcode' => 0];
            }

            return $this->response($msg, 200);
        }
    }

    /**
     * 从购物车中移除商品
     */
    public function action_remove_item(){

        $msg = ['status' => 'err', 'msg' => '', 'errcode' => 10];

        if(\Input::get('id', false)){

            $count = \DB::delete(\Model_Trolley::table())
                ->where([
                    'id' => \Input::get('id'),
                    'user_id' => $this->user->id,
                    'store_id' => $this->store ? $this->store->id : 0
                ])
                ->execute();

            if($count > 0){
                $msg = ['status' => 'succ', 'msg' => '', 'errcode' => 0];
            }
        }

        return $this->response($msg, 200);
    }

    /**
     * 清空购物车
     */
    public function action_remove_all(){
        $count = \DB::delete(\Model_Trolley::table())
            ->where('user_id', $this->user->id)
            ->execute();

        if($count > 0){
            $msg = ['status' => 'succ', 'msg' => '', 'errcode' => 0];
        }

        return $this->response($msg, 200);
    }
}
