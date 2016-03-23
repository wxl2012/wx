<?php
/**
 * 预约订单数据数据模型
 * 
 * @package    apps
 * @version    1.0
 * @author     Ray
 * @license    MIT License
 * @copyright  2010 - 2014 PMonkey Team
 * @link       http://wangxiaolei.cn
 */

class Model_OrderReserve extends \Orm\Model
{

	/**
	 * @var  string  table name to overwrite assumption
	 */
	protected static $_table_name = 'orders_bookinfo';

	protected static $_primary_key = array('id');

	/**
	 * @var array	has_one relationships
	 */
	protected static $_has_one = array(
		/*'transport' => array(
			'model_to' => 'Model_OrderTransport',
			'key_from' => 'id',
			'key_to'   => 'order_id',
			'cascade_delete' => false,
		)*/
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
	);

	/**
	 * @var array	has_many relationships
	 */
	protected static $_has_many = array(
	);

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
		)
	);

	/**
	 * @var array	many_many relationships
	 */
	/*protected static $_many_many = array(
		'roles' => array(
			'key_from' => 'id',
			'model_to' => 'Model\\Auth_Role',
			'key_to' => 'id',
			'table_through' => null,
			'key_through_from' => 'group_id',
			'key_through_to' => 'role_id',
		),
		'permissions' => array(
			'key_from' => 'id',
			'model_to' => 'Model\\Auth_Permission',
			'key_to' => 'id',
			'table_through' => null,
			'key_through_from' => 'group_id',
			'key_through_to' => 'perms_id',
		),
	);*/

	public static $_maps = array(
		'type' => array(
			'NONE' => '无类型',
			'REPAIR' => '维修',
			'MAINTENANCE' => '保养',
			'TRY' => '试驾',
			'ACTIVITY' => '车主活动',
		)
	);
}
