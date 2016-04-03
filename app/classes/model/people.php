<?php
/**
 * 用户详细数据模型
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

class Model_People extends \Orm\Model
{

    /**
     * @var  string  table name to overwrite assumption
     */
    protected static $_table_name = 'peoples';

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
        'properties' => array(
            'attribute' => 'key',
            'value' => 'value',
        ),
    );

    /**
     * @var array	has_one relationships
     */
    protected static $_has_one = array(
        /*'employee' => array(
            'model_to' => 'Model_Employee',
            'key_from' => 'user_id',
            'key_to'   => 'user_id',
        ),*/
        'user' => array(
            'model_to' => 'Model_User',
            'key_from' => 'user_id',
            'key_to'   => 'id',
        ),
        'parent' => array(
            'model_to' => 'Model_User',
            'key_from' => 'parent_id',
            'key_to'   => 'id',
        ),
        'wechat' => array(
            'model_to' => 'Model_Wechat',
            'key_from' => 'parent_id',
            'key_to'   => 'user_id',
        ),
    );

    /**
     * @var array	has_many relationships
     */
    protected static $_has_many = array(
        'members' => array(
            'model_to' => 'Model_Member',
            'key_from' => 'parent_id',
            'key_to'   => 'user_id',
        ),
        'orders' => array(
            'model_to' => 'Model_Order',
            'key_from' => 'parent_id',
            'key_to'   => 'buyer_id',
        ),
        'properties' => array(
            'model_to' => 'Model_PeoplePropertie',
            'key_from' => 'parent_id',
            'key_to'   => 'parent_id',
        ),
        'address' => array(
            'model_to' => 'Model_PeopleAddress',
            'key_from' => 'parent_id',
            'key_to'   => 'parent_id',
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
}