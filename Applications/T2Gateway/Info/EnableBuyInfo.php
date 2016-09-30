<?php

/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/6/29
 * Time: 下午7:47
 */

namespace Applications\T2Gateway\Info;

use Applications\T2Gateway\Lib\BaseInfo;

class EnableBuyInfo extends BaseInfo
{
	public static function getAttributes()
	{
		return [
			'enable_amount' => '',
			'store_unit' => '',
			'enable_buy_amount' => '',
			'high_amount' => '',
		];
	}
}