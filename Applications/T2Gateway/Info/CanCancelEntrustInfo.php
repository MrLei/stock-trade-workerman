<?php

/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/6/29
 * Time: 下午7:47
 */

namespace Applications\T2Gateway\Info;

use Applications\T2Gateway\Lib\BaseInfo;

class CanCancelEntrustInfo extends BaseInfo
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
			'entrust_price' => '',           //
			'entrust_amount' => '',          //
			'business_price' => '',          //
			'business_amount' => '',         //
			'report_no' => '',               //申请编号
			'report_time' => '',             //申报时间
			'entrust_date' => '',            //
			'entrust_time' => '',            //
			'entrust_type' => '',            //
			'entrust_status' => '',          //
			'entrust_prop' => '',            //
			'cancel_info' => '',             //废单原因
			'position_str' => ''
		];
	}
}
