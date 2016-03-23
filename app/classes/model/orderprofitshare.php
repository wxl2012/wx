<?php
/**
 * 订单分红数据模型
 *
 * @package    apps
 * @version    1.0
 * @author     Ray
 * @license    MIT License
 * @copyright  2010 - 2014 PMonkey Team
 * @link       http://wangxiaolei.cn
 */

class Model_OrderProfitShare extends \Orm\Model
{

    /**
     * @var  string  table name to overwrite assumption
     */
    protected static $_table_name = 'orders_profits_shares';

    protected static $_primary_key = array('id');

    /**
     * @var array	defined observers
     */
    protected static $_observers = array(
        'Orm\\Observer_Typing' => array(
            'events' => array('after_load', 'before_save', 'after_save')
        )
    );

    /**
     * @var array	belongs_to relationships
     */
    protected static $_belongs_to = array(
        'order' => array(
            'model_to' => 'Model_Order',
            'key_from' => 'order_id',
            'key_to'   => 'id'
        ),
        'user' => array(
            'model_to' => 'Model_People',
            'key_from' => 'user_id',
            'key_to'   => 'parent_id'
        ),
        'member' => array(
            'model_to' => 'Model_Member',
            'key_from' => 'member_id',
            'key_to'   => 'id'
        ),
    );
}
