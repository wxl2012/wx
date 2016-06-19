<?php
/**
 * 登录用户数据模型
 * 
 * @package    app
 * @version    1.0
 * @author     Ray zyr.wxl@gmail.com
 * @license    MIT License
 * @copyright  2015 PMonkey Team
 * @link       http://mnzone.cn
 *
 * @extends  	\Orm\Auth_User
 */

class Model_User extends \Auth\Model\Auth_User
{

	/**
	 * @var array	has_many relationships
	 */
	protected static $_has_one = array(
		'people' => array(
			'model_to' => 'Model_People',
			'key_from' => 'id',
			'key_to'   => 'parent_id',
		),
		'wechat' => array(
			'model_to' => 'Model_Wechat',
			'key_from' => 'user_id',
			'key_to'   => 'user_id',
		),
	);

	public static function createUser($data){
		$user_id = 0;

		if( ! isset($data['profile_fields'])){
			$data['profile_fields'] = [];
		}

		try{

			$user = \Model_User::query()->where('username', $data['username'])->get_one();
			if($user){
				return $user->id;
			}

			$user_id = \Auth::create_user(
				$data['username'],
				$data['password'],
				$data['email'],
				$data['group_id'],
				$data['profile_fields']
			);

		}catch(\SimpleUserUpdateException $e){
			$user = \Model_User::query()->where('username', $data['username'])->get_one();
			$user_id = $user->id;
		}

		return $user_id;
	}
}
