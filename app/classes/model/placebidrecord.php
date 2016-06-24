<?php
/**
 * 拍品参与记录数据模型
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
class Model_PlaceBidRecord extends \Orm\Model{

    /**
     * @var  string  table name to overwrite assumption
     */
    protected static $_table_name = 'place_bid_records';

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
     * @var array	has_one relationships
     */
    protected static $_belongs_to = array(
        'lot' => array(
            'model_to' => 'Model_Lot',
            'key_from' => 'lot_id',
            'key_to'   => 'id',
        ),
        'buyer' => array(
            'model_to' => 'Model_People',
            'key_from' => 'buyer_id',
            'key_to'   => 'parent_id',
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