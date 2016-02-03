<?php
/**
 * 附件表数据模型
 * 
 * @package    apps
 * @version    1.0
 * @author     Ray
 * @license    MIT License
 * @copyright  2010 - 2014 PMonkey Team
 * @link       http://wangxiaolei.cn
 */

class Model_Attachment extends \Orm\Model
{

	/**
	 * @var  string  table name to overwrite assumption
	 */
	protected static $_table_name = 'attachments';

	protected static $_primary_key = array('id');

	/**
	 * @var array	belongs_to relationships
	 */
	protected static $_belongs_to = array(
		'user' => array(
			'model_to' => 'Model_People',
			'key_from' => 'user_id',
			'key_to'   => 'user_id',
		),
		'seller' => array(
			'model_to' => 'Model_Seller',
			'key_from' => 'seller_id',
			'key_to'   => 'id',
		)
	);

}
