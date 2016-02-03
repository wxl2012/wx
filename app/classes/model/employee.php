<?php
/**
 * 商家职员数据模型
 * 
 * @package    apps
 * @version    1.0
 * @author     Ray
 * @license    MIT License
 * @copyright  2010 - 2014 PMonkey Team
 * @link       http://wangxiaolei.cn
 */

class Model_Employee extends \Orm\Model
{

	/**
	 * @var  string  table name to overwrite assumption
	 */
	protected static $_table_name = 'employees';

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

	// EAV container for user metadata
    protected static $_eav = array(
        'metadata' => array(
            'attribute' => 'key',
            'value' => 'value',
        ),
    );

	/**
	 * @var array	belongs_to relationships
	 */
	protected static $_belongs_to = array(
		'people' => array(
			'model_to' => 'Model_People',
			'key_from' => 'user_id',
			'key_to'   => 'user_id',
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
	/*protected static $_has_many = array(
		'users' => array(
			'model_to' => 'Model\\Auth_User',
			'key_from' => 'id',
			'key_to'   => 'group_id',
		),
		'grouppermission' => array(
			'model_to' => 'Model\\Auth_Grouppermission',
			'key_from' => 'id',
			'key_to'   => 'group_id',
			'cascade_delete' => false,
		),
	);*/

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

	/**
	 * @var array	has_many relationships
	 */
	protected static $_has_many = array(
		'metadata' => array(
			'model_to' => '\Model_EmployeeMtadata',
			'key_from' => 'id',
			'key_to'   => 'parent_id',
			'cascade_delete' => true,
		)
	);


	/**
	 * before_insert observer event method
	 */
	public function _event_before_insert()
	{
		// assign the user id that lasted updated this record
		//$this->user_id = ($this->user_id = \Auth::get_user_id()) ? $this->user_id[1] : 0;
	}

	/**
	 * before_update observer event method
	 */
	public function _event_before_update()
	{
		$this->_event_before_insert();
	}

	/**
	* 根据查询条件、排序条件获取数据
	* @param $fields String 显示字段列表
	* @param $params Array 查询条件
	* @param $tables Array 多表查询
	* @param $order_by Array 排序字段(array('字段名' => 'ASC|DESC'))
	* @param $limit int 限制条数
	* @param $page int 分页状态(0.不分页 1.分页)
	*/
	public static function getItems($fields = '*', $params = array(), $tables = array(), $order_by = array(), $limit = 0, $page = 0){
		$items = Model_Employee::query();
		//判断是否多表查询
		if($tables){
			$items->related($tables);
		}
		
		if( ! isset($params['is_delete'])){
			$params['is_delete'] = 0;
		}

		//判断是否有查询条件
		if($params){
			foreach ($params as $key => $value) {
				if(is_array($value)){
					$items->where($key, $value[0], $value[1]);
				}else{
					$items->where($key, $value);
				}
				
			}
		}

		//判断是否有排序条件
		if($order_by){
			foreach ($order_by as $key => $value) {
				if(is_numeric($key)){
					$items->order_by($value);
				}else{
					$items->order_by($key, $value);
				}				
			}
		}

		if($limit){
			$items->limit($limit);
		}
		
		//判断是否分页
		if($page){
			return $items;
		}else{
			return $items->get();
		}
	}
}
