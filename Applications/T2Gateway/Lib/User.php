<?php
/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/7/15
 * Time: 下午4:57
 */

namespace Applications\T2Gateway\Lib;


use GatewayWorker\Lib\Context;

class User
{
	private static $userInfoList = [];

	/**
	 * 保存用户的信息
	 * @param $client_id
	 * @param $user_info
	 */
	public static function setUserInfo($user_info, $client_id = null)
	{
		if(empty($client_id))
		{
			$client_id = Context::$client_id;
		}
		static::$userInfoList[$client_id] = $user_info;
	}

	/**
	 * 判断用户是否登录
	 * @param $client_id
	 * @return bool
	 */
	public static function isLogin($client_id)
	{
		return isset(static::$userInfoList[$client_id]);
	}

	/**
	 * 校验用户是否登录，如果严格限定，未登录则返回用户未登录错误码
	 * @param $client_id
	 * @param bool|true $strict
	 * @return bool
	 * @throws ResultException
	 */
	public static function checkLogin($client_id = null, $strict = true)
	{
		if(empty($client_id))
		{
			$client_id = Context::$client_id;
		}

		if(!static::isLogin($client_id))
		{
			if($strict)
			{
				throw new ResultException(UN_LOGIN);
			}

			return false;
		}

		return true;
	}

	/**
	 * 1. 断开T2Connection长连接
	 * 2. 删除用户信息
	 * @param $client_id
	 */
	public static function logout($client_id)
	{
		SingleT2Connection::close($client_id);
		unset(static::$userInfoList[$client_id]);
	}
}