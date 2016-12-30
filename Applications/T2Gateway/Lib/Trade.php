<?php
/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/7/21
 * Time: 下午3:46
 */

namespace Applications\T2Gateway\Lib;


use Applications\T2Gateway\Config\T2Config;
use Applications\T2Gateway\Info\EnableBuyInfo;
use Applications\T2Gateway\Info\QuotationInfo;
use Applications\T2Gateway\Info\StockHoldInfo;
use Applications\T2Gateway\Info\StockInfo;

class Trade
{
	public static function ensure($stock_id, $price)
	{
		$stock_info = Request::stockQuery($stock_id);

		//如果获取不到价格，那么使用传入的价格
		$quotation = Request::stockInfo($stock_id, $stock_info['exchange_type'], false);
		if(!empty($quotation))
		{
			$price = $quotation['last_price'];
		}

		$enableBuyInfo = null;
		if(!empty($price))
		{
			$enableBuyInfo = Request::tradeCount($stock_id, $stock_info['exchange_type'], $price);
		}

		$result['stock_info'] = StockInfo::getStructInfo($stock_info);
		$result['quotation'] = QuotationInfo::getStructInfo($quotation);
		$result['enable_buy_info'] = EnableBuyInfo::getStructInfo($enableBuyInfo);

		return $result;
	}

	public static function sellEnsure($stock_id)
	{
		$stock_info = Request::stockQuery($stock_id);
		$quotation = Request::stockInfo($stock_id, $stock_info['exchange_type'], false);

		//$price = $quotation['last_price'];
		//$enableBuyInfo = Request::tradeCount($stock_id, $stock_info['exchange_type'], $price);

		$user_hold = Request::stockHold($stock_id, $stock_info['exchange_type'], 1);
		Common::walkBuildStruct($user_hold, 'StockHoldInfo');

		$result['stock_info'] = StockInfo::getStructInfo($stock_info);
		$result['quotation'] = QuotationInfo::getStructInfo($quotation);
		$result['user_hold'] = $user_hold;

		return $result;
	}

	/**
	 * 是否是交易日
	 * @param null $day
	 * @return bool
	 */
	public static function isTradeDay($day = null)
	{
		if(empty($day))
		{
			$day = date('Y-m-d');
		}
		$week = date('w');

		$whiteList = T2Config::get('trade.whiteList');
		$blackList = T2Config::get('trade.blackList');

		if (!in_array($day, $whiteList))
		{
			if (in_array($day, $blackList))
			{
				return false;
			}
			if (in_array($week, [0, 6]))
			{
				return false;
			}
		}

		return true;
	}

	/**
	 * 当前是否是交易时间
	 * @return bool
	 */
	public static function isTradeTime()
	{
		$time = date('H:i:s');

		$isTradeDay = static::isTradeDay();
		if (!$isTradeDay)
		{
			return false;
		}

		$tradeTime = T2Config::get('trade.tradeTime');
		foreach ($tradeTime as $startTime => $endTime)
		{
			if ($time > $startTime && $time < $endTime)
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * 当前是否是委托时间
	 * @return bool
	 */
	public static function isOrderTime()
	{
		$time = date('H:i:s');

		$isTradeDay = static::isTradeDay();
		if (!$isTradeDay)
		{
			return true;
		}

		$orderTime = T2Config::get('trade.orderTime');
		foreach ($orderTime as $startTime => $endTime)
		{
			if ($time > $startTime && $time < $endTime)
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * 当前是否是撤单时间
	 * @return bool
	 */
	public static function isRevokeTime()
	{
		$time = date('H:i:s');

		$isTradeDay = static::isTradeDay();
		if (!$isTradeDay)
		{
			return true;
		}

		$revokeTime = T2Config::get('trade.revokeTime');
		foreach ($revokeTime as $startTime => $endTime)
		{
			if ($time > $startTime && $time < $endTime)
			{
				return true;
			}
		}

		return false;
	}

	public static function isAuctionTime()
	{
		$time = date('H:i:s');

		$isTradeDay = static::isTradeDay();
		if (!$isTradeDay)
		{
			return true;
		}

		$auctionTime = T2Config::get('trade.auctionTime');
		foreach ($auctionTime as $startTime => $endTime)
		{
			if ($time > $startTime && $time < $endTime)
			{
				return true;
			}
		}

		return false;
	}
}