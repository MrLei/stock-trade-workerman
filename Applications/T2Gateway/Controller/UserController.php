<?php
/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/6/22
 * Time: 下午6:53
 */

namespace Applications\T2Gateway\Controller;


use Applications\T2Gateway\Info\UserInfo;
use Applications\T2Gateway\Lib\Param;
use Applications\T2Gateway\Lib\Request;
use Applications\T2Gateway\Lib\Stock;
use Applications\T2Gateway\Lib\User;
use Applications\T2Gateway\Response;
use GatewayWorker\Lib\Gateway;

/**
 * Class UserController
 *
 * @category  API
 * @package Applications\T2Gateway\Controller
 */
class UserController
{
	/**
	 * 用户登录
	 * @api
	 * @param $param
	 * @throws \Applications\T2Gateway\Lib\ResultException
	 */
	public static function actionLogin($param)
	{
		$must = ['fund_account', 'password'];
		Param::judge($param, $must);

		$fund_account = Param::get($param, 'fund_account');
		$password = Param::get($param, 'password');

		$user_info = Request::login($fund_account, $password);

		$result['errcode'] = SUCCESS;
		$result['user_info'] = UserInfo::getStructInfo($user_info);
		User::setUserInfo($user_info);

		Response::output($result);
	}


	/**
	 * 退出，断开连接
	 * @throws \Exception
	 */
	public static function actionLogout()
	{
		Gateway::closeCurrentClient();
	}
}