<?php
/**
 * 商品数据模型
 * 
 * @package    apps
 * @version    1.0
 * @author     Ray
 * @license    MIT License
 * @copyright  2010 - 2014 PMonkey Team
 * @link       http://wangxiaolei.cn
 */

class Model_Goods extends \Orm\Model
{

	/**
	 * @var  string  table name to overwrite assumption
	 */
	protected static $_table_name = 'goods';

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
		'Orm\\Observer_Self' => array(
			'events' => array('before_insert', 'before_update'),
			'property' => 'user_id'
		),
	);

	protected static $_has_one = array(
		'dish' => array(
			'model_to' => 'Model_Dish',
			'key_from' => 'id',
			'key_to'   => 'goods_id'
		)
	);

	/**
	 * @var array	belongs_to relationships
	 */
	protected static $_belongs_to = array(
		'spec' => array(
			'model_to' => 'Model_Category',
			'key_from' => 'spec_id',
			'key_to'   => 'id'
		),
		'category' => array(
			'model_to' => 'Model_Category',
			'key_from' => 'category_id',
			'key_to'   => 'id'
		),
		'seller' => array(
			'model_to' => 'Model_Seller',
			'key_from' => 'seller_id',
			'key_to'   => 'id'
		)
	);

	/**
	 * @var array	has_many relationships
	 */
	protected static $_has_many = array(
		'attachments' => array(
			'model_to' => 'Model_GoodsGallery',
			'key_from' => 'id',
			'key_to'   => 'goods_id',
		)
	);
}
