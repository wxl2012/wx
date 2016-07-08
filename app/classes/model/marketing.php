<?php
/**
 * 活动数据模型
 *
 * @package    apps
 * @version    1.0
 * @author     Ray
 * @license    MIT License
 * @copyright  2010 - 2014 PMonkey Team
 * @link       http://wangxiaolei.cn
 */

class Model_Marketing extends \Orm\Model
{

    /**
     * @var  string  table name to overwrite assumption
     */
    protected static $_table_name = 'marketing';

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
        ),
        'Orm\\Observer_Self' => array(
            'events' => array('before_insert', 'before_update'),
            'property' => 'user_id'
        ),
    );

    /**
     * @var array   belongs_to relationships
     */
    protected static $_belongs_to = array(
        /*'vote' => array(
            'model_to' => 'Model_MarketingVote',
            'key_from' => 'id',
            'key_to'   => 'marketing_id'
        ),*/
        'seller' => array(
            'model_to' => 'Model_Seller',
            'key_from' => 'seller_id',
            'key_to'   => 'id'
        ),
        'account' => array(
            'model_to' => 'Model_WXAccount',
            'key_from' => 'account_id',
            'key_to'   => 'id'
        ),
        'statistic' => array(
            'model_to' => 'Model_MarketingStatistic',
            'key_from' => 'id',
            'key_to'   => 'marketing_id'
        ),
        'wechatShare' => array(
            'model_to' => 'Model_MarketingWechatShare',
            'key_from' => 'id',
            'key_to'   => 'marketing_id'
        ),
        'limit' => array(
            'model_to' => 'Model_MarketingLimit',
            'key_from' => 'id',
            'key_to'   => 'marketing_id',
            'cascade_save' => true,
        ),
    );

    /**
     * @var array   has_many relationships
     */
    protected static $_has_many = array(
        'records' => array(
            'model_to' => 'Model_MarketingRecord',
            'key_from' => 'id',
            'key_to'   => 'marketing_id'
        ),
        'recordStatistics' => array(
            'model_to' => 'Model_MarketingStatistic',
            'key_from' => 'id',
            'key_to'   => 'marketing_id'
        ),
        'options' => array(
            'model_to' => 'Model_MarketingConfig',
            'key_from' => 'id',
            'key_to'   => 'marketing_id'
        ),
        'candidates' => array(
            'model_to' => 'Model_MarketingVoteCandidate',
            'key_from' => 'id',
            'key_to'   => 'marketing_id'
        )
    );
}
