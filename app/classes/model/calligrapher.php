<?php
/**
 * 书法家数据模型
 *
 * @package    apps
 * @version    1.0
 * @author     Ray
 * @license    MIT License
 * @copyright  2010 - 2014 PMonkey Team
 * @link       http://wangxiaolei.cn
 */

class Model_Calligrapher extends \Orm\Model
{

    /**
     * @var  string  table name to overwrite assumption
     */
    protected static $_table_name = 'calligraphers';

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

    /**
     * @var array	belongs_to relationships
     */
    protected static $_belongs_to = array(
        'country' => array(
            'model_to' => 'Model_Region',
            'key_from' => 'country_id',
            'key_to'   => 'id'
        ),
        'province' => array(
            'model_to' => 'Model_Region',
            'key_from' => 'province_id',
            'key_to'   => 'id'
        ),
        'city' => array(
            'model_to' => 'Model_Region',
            'key_from' => 'city_id',
            'key_to'   => 'id'
        ),
        'county' => array(
            'model_to' => 'Model_Region',
            'key_from' => 'county_id',
            'key_to'   => 'id'
        ),
        'recorder' => array(
            'model_to' => 'Model_People',
            'key_from' => 'recorder_id',
            'key_to'   => 'id'
        ),
    );

}
