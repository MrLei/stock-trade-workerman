<?php
/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/7/19
 * Time: 下午2:10
 */

namespace Applications\T2Gateway\Controller;


use Applications\T2Gateway\Lib\Common;
use Applications\T2Gateway\Lib\Param;
use Applications\T2Gateway\Lib\Request;
use Applications\T2Gateway\Lib\Stock;
use Applications\T2Gateway\Lib\User;
use Applications\T2Gateway\Response;


/**
 * 查询类接口
 *
 * @category API
 * @package Applications\T2Gateway\Controller
 */
class QueryController
{

	/**
	 * 用户资金查询
	 * @throws \Applications\T2Gateway\Lib\ResultException
	 */
	public static function actionFund()
	{
		User::checkLogin();

		$user_fund = Stock::userFund();

		$result['errcode'] = SUCCESS;
		$result['result'] = $user_fund;

		Response::output($result);
	}

	/**
	 * 可撤单委托列表
	 * @param $param
	 * @throws \Applications\T2Gateway\Lib\ResultException
	 */
	public static function actionCanCancelEntrust($param)
	{
		User::checkLogin();

		$sort_direction = Param::get($param, 'sort_direction', '0');
		$position_str = Param::get($param, 'position_str', '');
		$request_num = Param::get($param, 'request_num', 10);

		$entrust_list = Request::canCancelEntrustList($sort_direction, $position_str, $request_num);
		Common::walkBuildStruct($entrust_list, 'CanCancelEntrustInfo');

		$result['errcode'] = SUCCESS;
		$result['entrust_list'] = $entrust_list;

		Response::output($result);
	}

	/**
	 * 当日委托
	 * @param $param
	 * @throws \Applications\T2Gateway\Lib\ResultException
	 */
	public static function actionTodayEntrust($param)
	{
		User::checkLogin();

		$position_str = Param::get($param, 'position_str', '');
		$request_num = Param::get($param, 'request_num', 10);

		$entrust_list = Stock::todayEntrust($position_str, $request_num);

		$result['errcode'] = SUCCESS;
		$result['entrust_list'] = $entrust_list;

		Response::output($result);
	}

	/**
	 * 历史委托
	 * @param $param
	 * @throws \Applications\T2Gateway\Lib\ResultException
	 */
	public static function actionHistoryEntrust($param)
	{
		User::checkLogin();

		$start_date = Param::get($param, 'start_date');
		$end_date = Param::get($param, 'end_data');
		$position_str = Param::get($param, 'position_str', '');
		$request_num = Param::get($param, 'request_num', 10);

		if(empty($end_date))
		{
			$end_date = date('Ymd', strtotime('+1 days'));
		}
		if(empty($start_date))
		{
			$start_date = date('Ymd', strtotime('-7 days', strtotime($end_date)));
		}

		$entrust_list = Stock::historyEntrust($start_date, $end_date, $position_str, $request_num);

		$result['errcode'] = SUCCESS;
		$result['entrust_list'] = $entrust_list;

		Response::output($result);
	}

	/**
	 * 当日成交
	 * @param $param
	 * @throws \Applications\T2Gateway\Lib\ResultException
	 */
	public static function actionTodayTrade($param)
	{
		User::checkLogin();

		$position_str = Param::get($param, 'position_str', '');
		$request_num = Param::get($param, 'request_num', 10);

		$trade_list = Stock::todayTrade($position_str, $request_num);

		$result['errcode'] = SUCCESS;
		$result['trade_list'] = $trade_list;

		Response::output($result);
	}

	/**
	 * 历史成交
	 * @param $param
	 * @throws \Applications\T2Gateway\Lib\ResultException
	 */
	public static function actionHistoryTrade($param)
	{
		User::checkLogin();

		$start_date = Param::get($param, 'start_date');
		$end_date = Param::get($param, 'end_data');
		$position_str = Param::get($param, 'position_str', '');
		$request_num = Param::get($param, 'request_num', 10);

		if(empty($end_date))
		{
			$end_date = date('Ymd', strtotime('+1 days'));
		}
		if(empty($start_date))
		{
			$start_date = date('Ymd', strtotime('-7 days', strtotime($end_date)));
		}

		$trade_list = Stock::historyTrade($start_date, $end_date, $position_str, $request_num);

		$result['errcode'] = SUCCESS;
		$result['trade_list'] = $trade_list;

		Response::output($result);
	}


	/**
	 * 历史资金流水
	 * @param $param
	 */
	public static function actionFundHistory($param)
	{
		User::checkLogin();

		$start_date = Param::get($param, 'start_date');
		$end_date = Param::get($param, 'end_data');
		$position_str = Param::get($param, 'position_str', '');
		$request_num = Param::get($param, 'request_num', 10);

		if(empty($end_date))
		{
			$end_date = date('Ymd', strtotime('+1 days'));
		}
		if(empty($start_date))
		{
			$start_date = date('Ymd', strtotime('-7 days', strtotime($end_date)));
		}

		$fund_list = Request::fundHistory($start_date, $end_date, $position_str, $request_num);
		Common::walkBuildStruct($fund_list, 'FundInfo');

		$result['errcode'] = SUCCESS;
		$result['fund_list'] = $fund_list;

		Response::output($result);
	}

	/**
	 * 历史交割单查询
	 * @param $param
	 */
	public static function actionDeliveryHistory($param)
	{
		User::checkLogin();

		$start_date = Param::get($param, 'start_date');
		$end_date = Param::get($param, 'end_data');
		$position_str = Param::get($param, 'position_str', '');
		$request_num = Param::get($param, 'request_num', 10);

		if(empty($end_date))
		{
			$end_date = date('Ymd', strtotime('+1 days'));
		}
		if(empty($start_date))
		{
			$start_date = date('Ymd', strtotime('-7 days', strtotime($end_date)));
		}

		$delivery_list = Request::deliveryHistory($start_date, $end_date, $position_str, $request_num);
		Common::walkBuildStruct($delivery_list, 'DeliveryInfo');

		$result['errcode'] = SUCCESS;
		$result['delivery_list'] = $delivery_list;

		Response::output($result);
	}
}
