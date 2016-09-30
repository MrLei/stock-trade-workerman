<?php

/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/6/29
 * Time: 下午7:47
 */

namespace Applications\T2Gateway\Info;

use Applications\T2Gateway\Lib\BaseInfo;

class DeliveryInfo extends BaseInfo
{
	public static function getAttributes()
	{
		return [
			'init_date' => '',
			'serial_no' => '',
			'entrust_no' => '',
			'stock_account' => '',
			'stock_code' => '',
			'exchange_type' => '',
			'stock_name' => '',
			'entrust_bs' => '',             //买卖方向
			'business_price' => '',
			'business_time' => '',
			'business_status' => '',        //业务状态
			'business_amount' => '',
			'occur_amount' => '',            //发生数量
			'occur_balance' => '',        //发生金额
			'fare0' => '',                //佣金
			'fare1' => '',                //印花税
			'fare2' => '',                //过户费
			'fare3' => '',                //费用3
			'farex' => '',                //费用x
			'position_str' => ''
		];
	}
}