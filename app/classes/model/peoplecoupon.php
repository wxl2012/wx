<?php
/**
 * 用户优惠券数据模型
 *
 * @package    app
 * @version    1.0
 * @author     Ray zyr.wxl@gmail.com
 * @license    MIT License
 * @copyright  2015 PMonkey Team
 * @link       http://mnzone.cn
 *
 * @extends  	\Orm\Model
 */

class Model_PeopleCoupon extends \Orm\Model
{

    /**
     * @var  string  table name to overwrite assumption
     */
    protected static $_table_name = 'peoples_coupons';

    protected static $_primary_key = array('id');

    /**
     * @var array	defined observers
     */
    protected static $_observers = array(
        'Orm\\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'property' => 'created_at',
            'mysql_timestamp' => false
        ),
        'Orm\\Observer_UpdatedAt' => array(
            'events' => array('before_update'),
            'property' => 'updated_at',
            'mysql_timestamp' => false
        ),
        'Orm\\Observer_Typing' => array(
            'events' => array('after_load', 'before_save', 'after_save')
        )
    );

    /**
     * @var array	has_many relationships
     */
    protected static $_belongs_to = array(
        'people' => array(
            'model_to' => 'Model_People',
            'key_from' => 'user_id',
            'key_to'   => 'user_id',
        ),
        'coupon' => array(
            'model_to' => 'Model_Coupon',
            'key_from' => 'conpon_id',
            'key_to'   => 'id',
        ),
        'seller' => array(
            'model_to' => 'Model_Seller',
            'key_from' => 'seller_id',
            'key_to'   => 'id',
        ),
        'order' => array(
            'model_to' => 'Model_Order',
            'key_from' => 'order_id',
            'key_to'   => 'id',
        )

    );
}