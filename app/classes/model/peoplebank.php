<?php
/**
 * 用户收款帐户数据模型
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

class Model_PeopleBank extends \Orm\Model
{

    /**
     * @var  string  table name to overwrite assumption
     */
    protected static $_table_name = 'peoples_banks';

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
            'key_from' => 'parent_id',
            'key_to'   => 'user_id',
        ),
        'bank' => array(
            'model_to' => 'Model_Bank',
            'key_from' => 'bank_id',
            'key_to'   => 'id',
        ),
        'country' => array(
            'model_to' => 'Model_Region',
            'key_from' => 'country_id',
            'key_to'   => 'id',
        ),
        'province' => array(
            'model_to' => 'Model_Region',
            'key_from' => 'province_id',
            'key_to'   => 'id',
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

}