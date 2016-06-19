<?php
/**
 * 提现申请数据模型
 *
 * @package    apps
 * @version    1.0
 * @author     Ray
 * @license    MIT License
 * @copyright  2010 - 2014 PMonkey Team
 * @link       http://wangxiaolei.cn
 */

class Model_CashbackApply extends \Orm\Model
{

    /**
     * @var  string  table name to overwrite assumption
     */
    protected static $_table_name = 'cashback_apply';

    protected static $_primary_key = array('id');

    /**
     * @var array	belongs_to relationships
     */
    protected static $_belongs_to = array(
        'parent' => array(
            'model_to' => 'Model_People',
            'key_from' => 'parent_id',
            'key_to'   => 'user_id',
        ),
        'user' => array(
            'model_to' => 'Model_People',
            'key_from' => 'user_id',
            'key_to'   => 'user_id',
        ),
        'bank' => array(
            'model_to' => 'Model_Bank',
            'key_from' => 'bank_id',
            'key_to'   => 'id',
        ),
    );
}
