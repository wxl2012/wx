<?php
/**
 * 微信公众帐户数据模型
 *
 * @package    app
 * @version    1.0
 * @author     Ray zyr.wxl@gmail.com
 * @license    MIT License
 * @copyright  2015 PMonkey Team
 * @link       http://mnzone.cn
 *
 * @extends     \Orm\Model
 */

class Model_WXAccountMpMaterial extends \Orm\Model
{

    /**
     * @var  string  table name to overwrite assumption
     */
    protected static $_table_name = 'wx_accounts_mp_materials';

    protected static $_primary_key = array('thumb_media_id');

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

    /**
     * @var array   belongs_to relationships
     */
    protected static $_belongs_to = array(
        'account' => array(
            'model_to' => 'Model_WXAccount',
            'key_from' => 'account_id',
            'key_to'   => 'id',
        )
    );
}