<?php

/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/6/29
 * Time: 下午7:47
 */

namespace Applications\T2Gateway\Info;

use Applications\T2Gateway\Lib\BaseInfo;

class BankTransferInfo extends BaseInfo
{
	public static function getAttributes()
	{
		return [
			'init_date' => '',
			'bank_no' => '',
			'bank_name' => '',
			'entrust_no' => '',
			'business_type' => '',
			'money_type' => '',
			'occur_balance' => '',
			'bktrans_status' => '',
			'position_str' => '',
		];
	}
}