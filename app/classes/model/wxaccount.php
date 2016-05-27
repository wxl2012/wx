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

class Model_WXAccount extends \Orm\Model
{

    /**
     * @var  string  table name to overwrite assumption
     */
    protected static $_table_name = 'wx_accounts';

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

    // EAV container for user metadata
    protected static $_eav = array(
        'metadata' => array(
            'attribute' => 'key',
            'value' => 'value',
        ),
    );

    /**
     * @var array   has_many relationships
     */
    protected static $_has_many = array(
        'metadata' => array(
            'model_to' => '\Model_WXAccountMetadata',
            'key_from' => 'id',
            'key_to'   => 'parent_id'
        )
    );

    /**
     * @var array   belongs_to relationships
     */
    protected static $_belongs_to = array(
        'seller' => array(
            'model_to' => 'Model_Seller',
            'key_from' => 'seller_id',
            'key_to'   => 'id',
        ),
        /*'sale' => array(
            'model_to' => 'Model_Sale',
            'key_from' => 'sale_id',
            'key_to'   => 'id',
            'cascade_delete' => false,
        ),*/
    );

    public static $_maps = array(
        'type' => array(
            'NONE' => '无',
            'service' => '服务号',
            'subscribe' => '订阅号',
            'company' => '企业号',
        ),
        'status' => array(
            'NONE' => '未认证',
            'AUTH' => '已认证'
        ),
        'status_label' => array(
            'NONE' => 'danger',
            'AUTH' => 'success'
        )
    );

    public static function createAccount($data){

        if( ! isset($data['is_subscribe_create_user'])){
            $data['is_subscribe_create_user'] = false;
        }
        if( ! isset($data['is_subscribe_create_member'])){
            $data['is_subscribe_create_member'] = false;
        }
        if( ! isset($data['create_user_default_group'])){
            $data['create_user_default_group'] = 1;
        }

        $account = \Model_WXAccount::forge($data);
        if( ! $account->save()){
            return false;
        }

        return $account;
    }

    /**
     * 检测token是否过期,过期则重新获取token
     * @throws Exception
     */
    public function checkToken(){
        if($this->temp_token_valid <= time()){
            $token = \handler\mp\Tool::generate_token($this->app_id, $this->app_secret);

            $this->temp_token = $token['token'];
            $this->temp_token_valid = $token['valid'];
            $this->save();
            \Session::set('WXAccount', $this);
        }
    }
}