<?php
/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/7/22
 * Time: 下午2:18
 */

namespace Applications\T2Gateway\Lib;


use Applications\T2Gateway\Info\EntrustInfo;
use Applications\T2Gateway\Info\StockHoldInfo;
use Applications\T2Gateway\Info\TradeInfo;
use Applications\T2Gateway\Info\UserFundInfo;

class Stock
{
	public static function userFund()
	{
		$user_fund = Request::userFund();
		$user_hold = Request::stockHold('', '', 1, '');

		$total_income_balance = 0;
		$hold_list = [];
		foreach($user_hold as $hold)
		{
			if($hold['profit_ratio'] > 0)
			{
				$total_income_balance += $hold['income_balance'];
			}

			if($hold['profit_ratio'] < 0)
			{
				$total_income_balance -= $hold['income_balance'];
			}

			$hold_list[] = StockHoldInfo::getStructInfo($hold);
		}
		$user_fund['income_balance'] = $total_income_balance;

		$result['user_fund'] = UserFundInfo::getStructInfo($user_fund);
		$result['user_hold'] = $hold_list;

		return $result;
	}

	public static function todayEntrust($position_str, $request_num)
	{
		$entrust_list = Request::entrustList(1, 0, 0, 0, $position_str, $request_num);

		$result = [];
		foreach($entrust_list as $entrust)
		{
			$result[] = EntrustInfo::getStructInfo($entrust);
		}

		return $result;
	}

	public static function historyEntrust($start_date, $end_date, $position_str, $request_num)
	{
		$entrust_list = Request::entrustHistory($start_date, $end_date, $position_str, $request_num);

		$result = [];
		foreach($entrust_list as $entrust)
		{
			$result[] = EntrustInfo::getStructInfo($entrust);
		}

		return $result;
	}


	public static function todayTrade($position_str, $request_num)
	{
		$trade_list = Request::tradeList(1, 0, 0, $position_str, $request_num);

		$result = [];
		foreach($trade_list as $entrust)
		{
			$result[] = TradeInfo::getStructInfo($entrust);
		}

		return $result;
	}

	public static function historyTrade($start_date, $end_date, $position_str, $request_num)
	{
		$trade_list = Request::tradeHistory($start_date, $end_date, $position_str, $request_num);

		$result = [];
		foreach($trade_list as $entrust)
		{
			$result[] = TradeInfo::getStructInfo($entrust);
		}

		return $result;
	}
}