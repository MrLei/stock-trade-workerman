<?php

/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/6/29
 * Time: 下午7:47
 */

namespace Applications\T2Gateway\Info;

use Applications\T2Gateway\Lib\BaseInfo;

class StockHoldInfo extends BaseInfo
{
	public static function getAttributes()
	{
		return [
			'stock_code' => '',
			'exchange_type' => '',
			'stock_name' => '',
			'hold_amount' => '',
			'current_amount' => '',
			'enable_amount' => '',
			'frozen_amount' => '',
			'last_price' => '',
			'cost_price' => '',
			'market_value' => '',
			'income_balance' => '',
			'delist_flag' => '',
			'profit_ratio' => '',
			'position_str' => '',
		];
	}
}