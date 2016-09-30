<?php

/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/6/29
 * Time: 下午7:47
 */

namespace Applications\T2Gateway\Info;

use Applications\T2Gateway\Lib\BaseInfo;

class EntrustInfo extends BaseInfo
{
	public static function getAttributes()
	{
		return [
			'entrust_no' => '',
			'stock_account' => '',
			'stock_code' => '',                 //
			'exchange_type' => '',              //
			'stock_name' => '',                 //
			'entrust_bs' => '',                 //买卖方向
			'entrust_price' => '',            //
			'entrust_amount' => '',              //
			'business_price' => '',           //
			'business_amount' => '',             //
			'entrust_date' => '',                //
			'entrust_time' => '',                //
			'entrust_type' => '',               //
			'entrust_status' => '',             //
			'withdraw_amount' => '',             //撤单数量
			'position_str' => ''
		];
	}
}