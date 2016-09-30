<?php

/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/6/29
 * Time: 下午7:47
 */

namespace Applications\T2Gateway\Info;

use Applications\T2Gateway\Lib\BaseInfo;

class BankInfo extends BaseInfo
{
	public static function getAttributes()
	{
		return [
			'open_date' => '',
			'fund_account' => '',
			'money_type' => '',
			'bank_no' => '',
			'bank_name' => '',
			'bank_account' => '',
			'bkaccount_status' => '',
		];
	}
}