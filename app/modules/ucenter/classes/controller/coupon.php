<?php
/**
 * 我的优惠券控制器
 *
 * @package    app
 * @version    1.0
 * @author     Ray 33705910@qq.com
 * @license    MIT License
 * @copyright  2013 - 2015 Ray
 * @link       http://wangxiaolei.cn
 */

namespace ucenter;

class Controller_Coupon extends Controller_BaseController {

    public function before(){
        parent::before();
    }

    /**
     * 我的优惠券
     */
    public function action_index(){
        $params = [
            'title' => '我的优惠券'
        ];

        $items = \Model_PeopleCoupon::query()
            ->where(['parent_id' => \Auth::get_user()->id])
            ->get();

        $params['items'] = $items;
        \View::set_global($params);
        $this->template->content = \View::forge("{$this->theme}/coupon/index");
    }
}
