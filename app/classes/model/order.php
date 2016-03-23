<?php
/**
 * 订单数据模型
 * 
 * @package    apps
 * @version    1.0
 * @author     Ray
 * @license    MIT License
 * @copyright  2010 - 2014 PMonkey Team
 * @link       http://wangxiaolei.cn
 */

class Model_Order extends \Orm\Model
{

	/**
	 * @var  string  table name to overwrite assumption
	 */
	protected static $_table_name = 'orders';

	protected static $_primary_key = array('id');

	/**
	 * @var array	has_one relationships
	 */
	protected static $_has_one = array(
		'reserve' => array(
			'model_to' => 'Model_OrderReserve',
			'key_from' => 'id',
			'key_to'   => 'order_id',
			'cascade_delete' => false,
		)
	);

	/**
	 * @var array	belongs_to relationships
	 */
	protected static $_belongs_to = array(
		'buyer' => array(
			'model_to' => 'Model_People',
			'key_from' => 'buyer_id',
			'key_to'   => 'parent_id',
		),
		'seller' => array(
			'model_to' => 'Model_Seller',
			'key_from' => 'from_id',
			'key_to'   => 'id',
			'cascade_delete' => false,
		),
	);

	/**
	 * @var array	has_many relationships
	 */
	protected static $_has_many = array(
		'details' => array(
			'model_to' => 'Model_OrderDetail',
			'key_from' => 'id',
			'key_to'   => 'order_id',
		),
		'rates' => array(
			'model_to' => 'Model_OrderRate',
			'key_from' => 'id',
			'key_to'   => 'order_id',
		),
		'trades' => array(
			'model_to' => 'Model_OrderTrade',
			'key_from' => 'id',
			'key_to'   => 'order_id',
		),
		'transports' => array(
			'model_to' => 'Model_OrderTransport',
			'key_from' => 'id',
			'key_to'   => 'order_id'
		),
		'accounts' => array(
			'model_to' => 'Model_GoodsAccount',
			'key_from' => 'id',
			'key_to'   => 'order_id'
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
		),
		'Orm\\Observer_Typing' => array(
			'events' => array('after_load', 'before_save', 'after_save')
		),
		'Orm\\Observer_Self' => array(
			'events' => array('before_insert'),
			'property' => 'user_id'
		),
	);

	/**
	 * @var array	many_many relationships
	 */
	/*protected static $_many_many = array(
		'roles' => array(
			'key_from' => 'id',
			'model_to' => 'Model\\Auth_Role',
			'key_to' => 'id',
			'table_through' => null,
			'key_through_from' => 'group_id',
			'key_through_to' => 'role_id',
		),
		'permissions' => array(
			'key_from' => 'id',
			'model_to' => 'Model\\Auth_Permission',
			'key_to' => 'id',
			'table_through' => null,
			'key_through_from' => 'group_id',
			'key_through_to' => 'perms_id',
		),
	);*/

	public static $_maps = array(
		'type' => array(
			'NONE' => '无类型',
			'SELL' => '销售单',
			'PURCHASE' => '进货单',
			'DELIVER' => '出库单',
			'STORAGE' => '入库单',
			'RETURNED' => '退货单',
			'BARTER' => '换货单',
			'INVOICE' => '发货单',
			'BOOK' => '预约单',
			'REFUND' => '退款',
			'RECHARGE' => '充值',
			'TAKEAWAY' => '外卖单',
		),
		'status' => array(
			'NONE' => '无状态',
			'WAIT_PAYMENT' => '待支付',
			'PAYMENT_ERROR' => '支付失败',
			'PAYMENT_SUCCESS' => '支付完成',
			'SELLER_CANCEL' => '商户取消',
			'USER_CANCEL' => '用户取消',
			'WAIT_SURE' => '待确认',
			'SURE' => '确认',
			'WAIT_SHIPPED' => '待发货',
            'SHIPPED' => '已发货',
            'FORRECEIVABLES' =>  '待收款',
            'REFUNDMENT' =>  '退款中',
			'RECEIVED' => '已签收',
			'CHECKED' => '核对完成',
			'SYSTEM_STOP' => '系统中止',
			'FINISH' => '已完成'
		),
		'payment' => array(
			'NONE' => '未指定',
			'alipay' => '支付宝',
			'tenpay' => '财付通',
			'bank' => '网银',
			'paypal' => '贝宝(Paypal)',
			'card' => '游戏点卡/手机充值卡',
			'balance' => '会员帐户余额',
			'offline' => '现金',
			'peerpay' => '代付'
		),
		'labels' => array(
			'NONE' => 'default',
			'WAIT_PAYMENT' => 'warning',
			'PAYMENT_ERROR' => 'danger',
			'PAYMENT_SUCCESS' => 'success',
			'SELLER_CANCEL' => 'danger',
			'USER_CANCEL' => 'danger',
			'WAIT_SURE' => 'warning',
			'SURE' => 'info',
			'WAIT_SHIPPED' => 'warning',
			'SHIPPED' => 'info',
			'FORRECEIVABLES' =>  'warning',
			'REFUNDMENT' =>  'danger',
			'RECEIVED' => 'primary',
			'CHECKED' => 'primary',
			'SYSTEM_STOP' => 'danger',
			'FINISH' => 'success'
		)
	);

	/**
	 * before_insert observer event method
	 */
	public function _event_before_insert()
	{
		// assign the user id that lasted updated this record
		if(! $this->user_id){
			$this->user_id = ($this->user_id = \Auth::get_user_id()) ? $this->user_id[1] : 0;
		}
		
	}

	/**
	 * before_update observer event method
	 */
	public function _event_before_update()
	{
		$this->_event_before_insert();
	}

	/**
	 * 创建订单对象
	 * @return static
	 */
	public static function get_order(){
		$data = \Input::post();

		if( ! static::valid_data()){
			return false;
		}


		$order = \Model_Order::forge($data);
		$order->order_no = static::get_order_on();
		return $order;
	}

	/**
	 * 验证订单数据是否合法
	 *
	 * @return bool
	 */
	public static function valid_data(){
		$data = \Input::post();

		//验证数据合法性
		$fields = ['money', 'order_type', 'order_status'];
		$flag = true;
		foreach($fields as $field){
			if( ! isset($data[$field]) || ! $data[$field]){
				$flag = false;
				break;
			}
		}

		return $flag;
	}

	/**
	 * 生成订单号
	 *
	 * @return string
	 */
	public static function get_order_on(){
		$seller = \Session::get('seller', false);
		$wechat = \Session::get('wechat', false);
		$wxaccount = \Session::get('WXAccount', false);
		$user = \Auth::check() ? \Auth::get_user() : false;

		$seller = $seller ? $seller->id : 0;
		$user_id = $user ? $user->id : 0;
		$wechat_id = $wechat ? $wechat->id : 0;
		$account_id = $wxaccount ? $wxaccount->id : 0;
		$date = date('YmdHis');
		return "{$date}{$user_id}{$wechat_id}{$seller}{$account_id}";
	}

	/**
	 * 发货操作
	 * @param int $id 订单ID
	 */
	public static function delivery($id = 0){

		$msg = false;
		$order = \Model_Order::find($id);
		if(! $order){
			$msg = ['status' => 'err', 'msg' => '未找到订单,发货失败', 'title' => '错误'];
		}else if(in_array($order->order_status, ['NONE', 'WAIT_PAYMENT'])){
			$msg = ['status' => 'err', 'msg' => '订单未付款,发货失败', 'title' => '错误'];
		}else if($order->order_status != 'PAYMENT_SUCCESS'){
			$msg = ['status' => 'err', 'msg' => '订单状态异常,发货失败', 'title' => '错误'];
		}

		if($msg){
			\Session::set_flash('msg', $msg);
			return false;
		}

		//微信发货
		$account = \Session::get('WXAccount', false);
		if( ! $account){
			$account = \Model_WXAccount::find(1);
		}

		if($account->temp_token_valid < time()){
			$result = \handler\mp\Tool::generate_token($account->app_id, $account->app_secret);
			$account->temp_token = $result['token'];
			$account->temp_token_valid = $result['valid'];
			$account->save();
		}

		$delivery_count = 0;
		foreach($order->details as $detail){
			$sn = \Model_GoodsAccount::query()
				->where(['goods_id' => $detail->goods_id, 'status' => 'NONE'])
				->get_one();
			if(! $sn){
				$delivery_count ++;
				continue;
			}

			if($order->buyer_openid) {

				$remark = "订单号：{$order->order_no}\n用户名：{$sn->account}\n密码：{$sn->password}";
				$data = \handler\mp\TemplateMsg::get_buy_goods_success($detail->goods->name, $remark);
				$params = \handler\mp\TemplateMsg::get_base_params($order->buyer_openid, "ARlIzufqpUc8tvCTAVswkny-_AYwYatkxiw42MOa_uA", "http://mall.doujao.com", $data);
				$flag = \handler\mp\TemplateMsg::send_msg($account->temp_token, $params);
				if ($flag) {
					$sn->status = 'USED';
					$sn->order_id = $order->id;
					$sn->save();
				}

				$detail->is_delivery = 1;
				$detail->save();
			}
		}

		if($delivery_count > 0){
			\Session::set_flash('msg', ['status' => 'err', 'msg' => "{$delivery_count}件商品发货失败.原因:库存不足!请联系客服.", 'title' => '错误']);
			return false;
		}

		$order->order_status = 'FINISH';
		$order->save();
		return true;
	}
}
