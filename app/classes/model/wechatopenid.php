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
 * @extends  	\Orm\Model
 */

class Model_WechatOpenid extends \Orm\Model
{

	/**
	 * @var  string  table name to overwrite assumption
	 */
	protected static $_table_name = 'wechat_openid';

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
	protected static $_belongs_to = array(
		'wechat' => array(
			'model_to' => 'Model_Wechat',
			'key_from' => 'wechat_id',
			'key_to'   => 'id',
		)
	);

	/**
    * 获取微信信息
    *
    * @param $openid 微信粉丝ID
    */
    public static function getItem($openid){
    	$wechat = \Model_WechatOpenid::query()
    		->where('openid', $openid)
    		->get_one();

    	return $wechat;
    }
}
