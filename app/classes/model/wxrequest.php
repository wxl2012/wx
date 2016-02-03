<?php
/**
 * 微信粉丝openid数据模型
 *
 * @package    app
 * @version    1.0
 * @author     Ray zyr.wxl@gmail.com
 * @license    MIT License
 * @copyright  2015 PMonkey Team
 * @link       http://mnzone.cn
 *
 * @extends		\Orm\Model
 */
class Model_WXRequest extends \Orm\Model {

    protected static $_table_name = 'wx_requests_records';

    protected static $_primary_key = array('id');

    protected static $_belongs_to = array(
        'wechat' => array(
            'key_from' => 'wechat_id',
            'model_to' => 'Model_Wechat',
            'key_to' => 'id',
        ),
        'account' => array(
            'key_from' => 'account_id',
            'model_to' => 'Model_WXAccount',
            'key_to' => 'id',
        ),
    );

    protected static $_maps = array(
        'status' => array(
            'NONE' => '无状态'
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