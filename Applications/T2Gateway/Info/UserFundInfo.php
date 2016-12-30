<?php

/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/6/29
 * Time: 下午7:47
 */

namespace Applications\T2Gateway\Info;

use Applications\T2Gateway\Lib\BaseInfo;

class UserFundInfo extends BaseInfo
{
	public static function getAttributes()
	{
		return [
			'enable_balance' => '',               //可用资金
			'frozen_balance' => '',               //冻结资金
			'fetch_balance' => '',                //可取资金
			'market_value' => '',                 //总市值
			'asset_balance' => '',                //资产值，总资产
			'income_balance' => '',                //浮动盈亏
			'entrust_buy_balance' => '',           //委托买入金额
		];
	}
}