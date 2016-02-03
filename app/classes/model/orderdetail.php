<?php
/**
 * 订单明细数据模型
 * 
 * @package    apps
 * @version    1.0
 * @author     Ray
 * @license    MIT License
 * @copyright  2010 - 2014 PMonkey Team
 * @link       http://wangxiaolei.cn
 */

class Model_OrderDetail extends \Orm\Model
{

	/**
	 * @var  string  table name to overwrite assumption
	 */
	protected static $_table_name = 'orders_details';

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
		'goods' => array(
			'model_to' => 'Model_Goods',
			'key_from' => 'goods_id',
			'key_to'   => 'id'
		)
	);

	/**
	 * before_insert observer event method
	 */
	public function _event_before_insert()
	{
		// assign the user id that lasted updated this record
		$this->user_id = ($this->user_id = \Auth::get_user_id()) ? $this->user_id[1] : 0;
	}

	/**
	 * before_update observer event method
	 */
	public function _event_before_update()
	{
		$this->_event_before_insert();
	}
}
