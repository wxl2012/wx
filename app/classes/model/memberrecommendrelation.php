<?php
/**
 * 会员推荐关系数据模型
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
class Model_MemberRecommendRelation extends \Orm\Model{

    /**
     * @var  string  table name to overwrite assumption
     */
    protected static $_table_name = 'members_recommends_relations';

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
        'master' => array(
            'model_to' => 'Model_People',
            'key_from' => 'master_id',
            'key_to'   => 'user_id',
        ),
        'member' => array(
            'model_to' => 'Model_People',
            'key_from' => 'member_id',
            'key_to'   => 'user_id',
        ),
    );
}