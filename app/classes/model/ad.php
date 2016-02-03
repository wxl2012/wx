<?php
/**
 * 广告数据模型
 * 
 * @package    app
 * @version    1.0
 * @author     Ray
 * @license    MIT License
 * @copyright  2014 - 2016 PMonkey Team
 * @link       http://wangxiaolei.cn
 */

class Model_Ad extends \Orm\Model
{

    /**
     * @var  string  table name to overwrite assumption
     */
    protected static $_table_name = 'advertisements';

    protected static $_primary_key = array('id');

    /**
     * @var array   defined observers
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

    /**
     * @var array belongs_to relationships
     */
    protected static $_belongs_to = array(        
        'position' => array(
            'model_to' => 'Model_AdPosition',
            'key_from' => 'position_id',
            'key_to'   => 'id',
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
