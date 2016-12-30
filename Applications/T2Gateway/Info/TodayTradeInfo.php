<?php

/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/6/29
 * Time: 下午7:47
 */

namespace Applications\T2Gateway\Info;

use Applications\T2Gateway\Lib\BaseInfo;

class TodayTradeInfo extends BaseInfo
{
	public static function getAttributes()
	{
		return [
			'serial_no' => '',
			'date' => '',
			'exchange_type' => '',
			'fund_account' => '',
			'stock_account' => '',
			'stock_code' => '',
			'stock_name' => '',
			'entrust_bs' => '',             //买卖方向
			'business_price' => '',
			'business_time' => '',
			'business_amount' => '',
			'real_type' => '',
			'real_status' => '',
			'business_balance' => '',
			'business_times' => '',
			'entrust_no' => '',
			'report_no' => '',
			'entrust_prop' => '',
			'business_no' => '',
			'position_str' => '',
		];
	}
}