<?php
/**
 * 问题数据模型
 *
 * @package    apps
 * @version    1.0
 * @author     Ray
 * @license    MIT License
 * @copyright  2010 - 2014 PMonkey Team
 * @link       http://wangxiaolei.cn
 */

class Model_Question extends \Orm\Model
{

    /**
     * @var  string  table name to overwrite assumption
     */
    protected static $_table_name = 'questions';

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
     * @var array	has_one relationships
     */
    protected static $_belongs_to = array(
        'bank' => array(
            'model_to' => 'Model_QuestionBank',
            'key_from' => 'bank_id',
            'key_to'   => 'id'
        )
    );

    /**
     * @var array	has_many relationships
     */
    protected static $_has_many = array(
        'answers' => array(
            'model_to' => 'Model_QuestionAnswer',
            'key_from' => 'id',
            'key_to'   => 'question_id',
        )
    );
}
