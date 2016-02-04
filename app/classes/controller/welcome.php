<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2015 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Welcome extends Controller
{
	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
		$account = \Model_WXAccount::find(1);
		$re = new handler\mp\Response($account);
		$re->send();
		$account = [
			'id' => 1,
			'is_subscribe_create_user' => true,
			'is_subscribe_create_member' => true,
			'create_user_default_group' => 1
		];
		\handler\mp\Account::createWechatAccount('test', json_decode(json_encode($account)));
		return Response::forge(View::forge('welcome/index'));
	}

	/**
	 * A typical "Hello, Bob!" type example.  This uses a Presenter to
	 * show how to use them.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_hello()
	{
		return Response::forge(Presenter::forge('welcome/hello'));
	}

	/**
	 * The 404 action for the application.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_404()
	{
		return Response::forge(Presenter::forge('welcome/404'), 404);
	}

	public function action_test(){
		$members = \Model_MemberRecommendRelation::parentMember(3);
		$index = 1;
		foreach($members as $member){
			$data = [
				'master_id' => $index > 1 ? $member->master_id : $member->member_id,
				'member_id' => 4,
				'depth' => 1,
				'from' => 'QRCODE'
			];
			$relation = \Model_MemberRecommendRelation::forge($data);
			$relation->save();
			$index ++;
		}
	}
}
