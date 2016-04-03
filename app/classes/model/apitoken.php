<?php
/**
 * 接口参数数据模型
 *
 * @package    app
 * @version    1.0
 * @author     Ray
 * @license    MIT License
 * @copyright  2014 - 2016 PMonkey Team
 * @link       http://wangxiaolei.cn
 */

class Model_ApiToken extends \Orm\Model
{

    /**
     * @var  string  table name to overwrite assumption
     */
    protected static $_table_name = 'api_tokens';

    protected static $_primary_key = array('id');

    /**
     * @var array   defined observers
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
