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
		/*$account = \Model_WXAccount::find(1);
		$re = new handler\mp\Response($account);
		$re->send();
		$account = [
			'id' => 1,
			'is_subscribe_create_user' => true,
			'is_subscribe_create_member' => true,
			'create_user_default_group' => 1
		];
		\handler\mp\Account::createWechatAccount('test', json_decode(json_encode($account)));*/
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
		\Auth::force_login(1);
		//\Auth::logout();
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

	public function action_image(){

		$image = imagecreatefromjpeg(DOCROOT . 'uploads/tmp/bg.jpg');

		$grey = imagecolorallocate($image, 255, 255, 255);

		$font = '/Library/Fonts/Baoli.ttc';

		imagettftext($image, 20, 0, 50, 50, $grey, $font, '81岁');

		imagettftext($image, 20, 0, 50, 100, $grey, $font, '王晨芯的命运是');

		imagettftext($image, 20, 0, 50, 150, $grey, $font, '活到81岁');

		imagettftext($image, 20, 0, 50, 200, $grey, $font, '寿命: 81岁');

		imagettftext($image, 20, 0, 50, 250, $grey, $font, '家庭: 21岁结婚后得');

		imagettftext($image, 20, 0, 50, 300, $grey, $font, '车子: 法拉利458 Speciale');

		imagettftext($image, 20, 0, 50, 350, $grey, $font, '房子: 利奥波德别墅');

		imagepng($image);
	}
}
