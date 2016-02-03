<?php
/**
 * 广告位数据模型
 * 
 * @package    app
 * @version    1.0
 * @author     Ray
 * @license    MIT License
 * @copyright  2014 - 2016 PMonkey Team
 * @link       http://wangxiaolei.cn
 */

class Model_AdPosition extends \Orm\Model
{

    /**
     * @var  string  table name to overwrite assumption
     */
    protected static $_table_name = 'advertisements_positions';

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

    /**
     * @var array   has_many relationships
     */
    protected static $_has_many = array(        
        'items' => array(
            'model_to' => 'Model_Ad',
            'key_from' => 'id',
            'key_to'   => 'position_id',
        )
        
    );

    public static $_maps = array(
        'type' => array(
            'NONE' => '无',
            'IMAGE' => '图片广告',
            'TEXT' => '文字广告',
            'FLASH' => 'Flash广告',
            'IFRAME' => 'IFrame广告'
        )
    );

    /**
    * 根据关键字获取广告位
    * @param $key 广告位调用关键字
    **/
    public static function getAdByKey($key){
        $position = \Model_AdPosition::query()
            ->related('items', array('where' => array('is_delete' => 0)))
            ->where('key', $key)
            ->where('is_delete', 0)
            ->get_one();
        return $position;
    }
}
