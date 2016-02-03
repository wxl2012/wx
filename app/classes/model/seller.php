<?php
/**
 * 商家数据模型
 * 
 * @package    apps
 * @version    1.0
 * @author     Ray
 * @license    MIT License
 * @copyright  2010 - 2014 PMonkey Team
 * @link       http://wangxiaolei.cn
 */

class Model_Seller extends \Orm\Model
{

	/**
	 * @var  string  table name to overwrite assumption
	 */
	protected static $_table_name = 'sellers';

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
		),
		'Orm\\Observer_Self' => array(
			'events' => array('before_insert', 'before_update'),
			'property' => 'user_id'
		),
	);

	// EAV container for user metadata
    protected static $_eav = array(
        'metadata' => array(
            'attribute' => 'key',
            'value' => 'value',
        ),
    );

	/**
	 * @var array	has_one relationships
	 */
	protected static $_belongs_to = array(
		'category' => array(
			'model_to' => 'Model_Category',
			'key_from' => 'category_id',
			'key_to'   => 'id'
		),
		'channel' => array(
			'model_to' => 'Model_Category',
			'key_from' => 'channel_id',
			'key_to'   => 'id'
		),
		'country' => array(
			'model_to' => 'Model_Region',
			'key_from' => 'country_id',
			'key_to' => 'id',
		),
		'province' => array(
			'model_to' => 'Model_Region',
			'key_from' => 'province_id',
			'key_to' => 'id',
		),
		'city' => array(
			'model_to' => 'Model_Region',
			'key_from' => 'city_id',
			'key_to'   => 'id',
		),
		'county' => array(
			'model_to' => 'Model_Region',
			'key_from' => 'county_id',
			'key_to'   => 'id',
		)
	);

	/**
	 * @var array	has_many relationships
	 */
	protected static $_has_many = array(
		'metadata' => array(
			'model_to' => '\Model_SellerMetadata',
			'key_from' => 'id',
			'key_to'   => 'parent_id',
			'cascade_delete' => true,
		),
		'wxaccounts' => array(
			'model_to' => 'Model_WXAccount',
			'key_from' => 'id',
			'key_to' => 'seller_id',
		),
		'members' => array(
			'model_to' => 'Model_Member',
			'key_from' => 'id',
			'key_to'   => 'seller_id',
			'cascade_delete' => false,
		),
		'employees' => array(
			'model_to' => 'Model_Employee',
			'key_from' => 'id',
			'key_to'   => 'seller_id',
			'cascade_delete' => false,
		),
		'member_levels' => array(
			'model_to' => 'Model_MemberLevel',
			'key_from' => 'id',
			'key_to'   => 'seller_id',
		),
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
}
