<?php
/**
 * 订单物流数据模型
 * 
 * @package    apps
 * @version    1.0
 * @author     Ray
 * @license    MIT License
 * @copyright  2010 - 2014 PMonkey Team
 * @link       http://wangxiaolei.cn
 */

class Model_OrderTransport extends \Orm\Model
{

    /**
     * @var  string  table name to overwrite assumption
     */
    protected static $_table_name = 'orders_transport';

    protected static $_primary_key = array('id');

    /**
     * @var array   has_one relationships
     */
    protected static $_has_one = array(
        'order' => array(
            'model_to' => 'Model_Order',
            'key_from' => 'id',
            'key_to'   => 'node_id',
            'cascade_delete' => false,
        ),
    );

    /**
     * @var array   defined observers
     */
    protected static $_observers = array(
        'Orm\\Observer_Typing' => array(
            'events' => array('after_load', 'before_save', 'after_save')
        )
    );

    /**
     * @var array   has_many relationships
     */
    protected static $_belongs_to = array(
        'order' => array(
            'model_to' => 'Model_Order',
            'key_from' => 'id',
            'key_to'   => 'order_id',
        )
    );

    /**
     * @var array   many_many relationships
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
