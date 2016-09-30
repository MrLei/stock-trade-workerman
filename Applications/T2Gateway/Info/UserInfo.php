<?php

/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/6/29
 * Time: 下午7:47
 */

namespace Applications\T2Gateway\Info;

use Applications\T2Gateway\Lib\BaseInfo;

class UserInfo extends BaseInfo
{
	public static function getAttributes()
	{
		return [
			'client_id' => '',
			'client_name' => '',
			'user_token' => '',
		];
	}
}