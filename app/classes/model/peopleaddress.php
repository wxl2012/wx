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

class Model_PeopleAddress extends \Orm\Model
{

    /**
     * @var  string  table name to overwrite assumption
     */
    protected static $_table_name = 'peoples_address';

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
        )
    );

    protected static $_belongs_to = array(
        'user' => array(
            'model_to' => 'Model_People',
            'key_from' => 'user_id',
            'key_to'   => 'user_id',
        ),
        'people' => array(
            'model_to' => 'Model_People',
            'key_from' => 'parent_id',
            'key_to'   => 'parent_id',
        )
    );

}