<?php

/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/6/29
 * Time: 下午7:47
 */

namespace Applications\T2Gateway\Info;

use Applications\T2Gateway\Lib\BaseInfo;

class StockInfo extends BaseInfo
{
	public static function getAttributes()
	{
		return [
			'stock_code' => '',
			'exchange_type' => '',
			'stock_name' => '',
			'buy_unit' => '',
			'up_price' => '',
			'down_price' => '',
			'high_amount' => '',
			'delist_flag' => '',
			'low_balance' => '',
			'high_balance' => '',
		];
	}
}