<?php
/**
 * 菜品数据模型
 *
 * @package    apps
 * @version    1.0
 * @author     Ray
 * @license    MIT License
 * @copyright  2010 - 2014 PMonkey Team
 * @link       http://wangxiaolei.cn
 */

class Model_Dish extends \Orm\Model
{

    /**
     * @var  string  table name to overwrite assumption
     */
    protected static $_table_name = 'dish';

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

    /**
     * @var array	belongs_to relationships
     */
    protected static $_has_one = array(
        'goods' => array(
            'model_to' => 'Model_Goods',
            'key_from' => 'goods_id',
            'key_to'   => 'id'
        )
    );
}
