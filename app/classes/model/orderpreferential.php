<?php
/**
 * 订单优惠信息数据模型
 *
 * @package    apps
 * @version    1.0
 * @author     Ray
 * @license    MIT License
 * @copyright  2010 - 2014 PMonkey Team
 * @link       http://wangxiaolei.cn
 */

class Model_OrderPreferential extends \Orm\Model
{

    /**
     * @var  string  table name to overwrite assumption
     */
    protected static $_table_name = 'orders_preferential';

    protected static $_primary_key = array('id');

    /**
     * @var array	belongs_to relationships
     */
    protected static $_belongs_to = array(
        'order' => array(
            'model_to' => 'Model_Order',
            'key_from' => 'order_id',
            'key_to'   => 'id'
        ),
        'coupon' => array(
            'model_to' => 'Model_PeopleCoupon',
            'key_from' => 'coupon_id',
            'key_to'   => 'id'
        )
    );
}
