<?php

/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/6/29
 * Time: 下午7:47
 */

namespace Applications\T2Gateway\Info;

use Applications\T2Gateway\Lib\BaseInfo;

class FundInfo extends BaseInfo
{
	public static function getAttributes()
	{
		return [
			'init_date' => '',
			'serial_no' => '',
			'entrust_no' => '',
			'business_flag' => '',
			'business_name' => '',
			'occur_balance' => '',           //发生金额
			'post_balance' => '',
			'position_str' => '',
			'money_type' => '',
			'remark' => '',
			'fund_account' => '',
			'bank_no' => '',
			'bank_name' => '',
		];
	}
}