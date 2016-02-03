<?php
/**
 * 会员数据模型
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
class Model_Member extends \Orm\Model{

    /**
     * @var  string  table name to overwrite assumption
     */
    protected static $_table_name = 'members';

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
        'level' => array(
            'model_to' => 'Model_MemberLevel',
            'key_from' => 'level_id',
            'key_to'   => 'id',
        )
    );

    /**
     * @var array	has_one relationships
     */
    protected static $_has_one = array(
        'people' => array(
            'model_to' => 'Model_People',
            'key_from' => 'user_id',
            'key_to'   => 'user_id',
        )
    );

    /**
     * @var array	has_many relationships
     */
    protected static $_has_many = array(
        // 'cashRecords' => array(
        // 	'model_to' => 'Model_MemberTrade',
        // 	'key_from' => 'id',
        // 	'key_to'   => 'member_id',
        // ),
        // 'scoreRecords' => array(
        // 	'model_to' => 'Model_MemberTrade',
        // 	'key_from' => 'id',
        // 	'key_to'   => 'member_id',
        // ),
    );

    public static $_maps = array(
        'status' => array(
            'NONE' => '无状态',
            'NORMAL' => '正常',
            'PENDING_REVIEW' => '待审核',
            'APPROVED' => '审核通过',
            'FREEZE' => '冻结'
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