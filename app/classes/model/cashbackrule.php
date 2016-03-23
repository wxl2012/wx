<?php
/**
 * 订单分红规则数据模型
 *
 * @package    apps
 * @version    1.0
 * @author     Ray
 * @license    MIT License
 * @copyright  2010 - 2014 PMonkey Team
 * @link       http://wangxiaolei.cn
 */

class Model_CashbackRule extends \Orm\Model
{

    /**
     * @var  string  table name to overwrite assumption
     */
    protected static $_table_name = 'cashback_rules';

    protected static $_primary_key = array('id');

    /**
     * @var array	belongs_to relationships
     */
    protected static $_belongs_to = array(
        'seller' => array(
            'model_to' => 'Model_Seller',
            'key_from' => 'seller_id',
            'key_to'   => 'id',
        )
    );

    /**
     * @var array	has_many relationships
     */
    protected static $_has_many = array(
        'items' => array(
            'model_to' => 'Model_CashbackRuleItem',
            'key_from' => 'id',
            'key_to'   => 'rule_id',
        )
    );

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
}
