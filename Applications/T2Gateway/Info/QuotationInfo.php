<?php

/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/6/29
 * Time: 下午7:47
 */

namespace Applications\T2Gateway\Info;

use Applications\T2Gateway\Lib\BaseInfo;

class QuotationInfo extends BaseInfo
{
	public static function getAttributes()
	{
		return [
			'last_price' => '',
			'open_price' => '',
			'close_price' => '',
			'high_price' => '',
			'low_price' => '',
			'buy_price1' => '',
			'buy_price2' => '',
			'buy_price3' => '',
			'buy_price4' => '',
			'buy_price5' => '',
			'sale_price1' => '',
			'sale_price2' => '',
			'sale_price3' => '',
			'sale_price4' => '',
			'sale_price5' => '',
			'buy_amount1' => '',
			'buy_amount2' => '',
			'buy_amount3' => '',
			'buy_amount4' => '',
			'buy_amount5' => '',
			'sale_amount1' => '',
			'sale_amount2' => '',
			'sale_amount3' => '',
			'sale_amount4' => '',
			'sale_amount5' => '',
			'stock_name' => '',
			'stock_interest' => '',
		];
	}
}