<?php
/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/6/23
 * Time: 上午10:37
 */

namespace Applications\T2Gateway\Controller;


use Applications\T2Gateway\Info\QuotationInfo;
use Applications\T2Gateway\Lib\Param;
use Applications\T2Gateway\Lib\Request;
use Applications\T2Gateway\Lib\ResultException;
use Applications\T2Gateway\Lib\Trade;
use Applications\T2Gateway\Lib\User;
use Applications\T2Gateway\Response;


/**
 * 交易类接口
 *
 * @category API
 * @package Applications\T2Gateway\Controller
 */
class TradeController
{
	/**
	 * 股票代码查询
	 * zval* req330300(char *stock_id, char *exchange_type);
	 * @param $param
	 * @throws \Applications\T2Gateway\Lib\ResultException
	 */
	public static function actionStockQuery($param)
	{
		User::checkLogin();

		$must = ['stock_id'];
		Param::judge($param, $must);

		$stock_id = Param::get($param, 'stock_id');
		$query_type = Param::get($param, 'query_type', '2');
		$exchange_type = Param::get($param, 'exchange_type', '');
		$position_str = Param::get($param, 'position_str', '');
		$request_num = Param::get($param, 'request_num', 10);

		$stock_info = Request::stockQuery($stock_id, $query_type, $exchange_type, $position_str, $request_num);

		$result['errcode'] = SUCCESS;
		$result['stock_info'] = $stock_info;

		Response::output($result);
	}


	/**
	 * 股票五档行情查询
	 * @param $param
	 * @throws \Applications\T2Gateway\Lib\ResultException
	 */
	public static function actionStockInfo($param)
	{
		$must = ['stock_id', 'exchange_type'];
		Param::judge($param, $must);

		$stock_id = Param::get($param, 'stock_id');
		$exchange_type = Param::get($param, 'exchange_type');

		$quotation = Request::stockInfo($stock_id, $exchange_type);

		$result['errcode'] = 0;
		$result['quotation'] = QuotationInfo::getStructInfo($quotation);

		Response::output($result);
	}

	/**
	 * 股票交易买入确认
	 * @param $param
	 * @throws ResultException
	 */
	public static function actionStockEnsure($param)
	{
		$must = ['stock_id'];
		Param::judge($param, $must);

		$stock_id = Param::get($param, 'stock_id');

		$stock_info = Trade::ensure($stock_id);

		$result['errcode'] = 0;
		$result['result'] = $stock_info;

		Response::output($result);
	}

	/**
	 * 股票交易卖出确认
	 * @param $param
	 * @throws ResultException
	 */
	public static function actionSellEnsure($param)
	{
		$must = ['stock_id'];
		Param::judge($param, $must);

		$stock_id = Param::get($param, 'stock_id');

		$stock_info = Trade::sellEnsure($stock_id);

		$result['errcode'] = 0;
		$result['result'] = $stock_info;

		Response::output($result);
	}

	/**
	 * 大约可买获取
	 * @param $param
	 * @throws \Applications\T2Gateway\Lib\ResultException
	 */
	public static function actionTradeCount($param)
	{
		User::checkLogin();

		$must = ['stock_id', 'exchange_type', 'entrust_price'];
		Param::judge($param, $must);

		$stock_id = Param::get($param, 'stock_id');
		$exchange_type = Param::get($param, 'exchange_type');
		$entrust_price = Param::get($param, 'entrust_price');

		$trade_count_info = Request::tradeCount($stock_id, $exchange_type, $entrust_price);

		$result['errcode'] = SUCCESS;
		$result['trade_count'] = $trade_count_info;

		Response::output($result);
	}

	/**
	 * 委托
	 * @param $param
	 * @throws ResultException
	 */
	public static function actionEntrust($param)
	{
		User::checkLogin();

		$must = ['stock_id', 'exchange_type', 'entrust_amount', 'entrust_price', 'entrust_bs', 'entrust_prop'];
		Param::judge($param, $must);

		$stock_id = Param::get($param, 'stock_id');
		$exchange_type = Param::get($param, 'exchange_type');
		$entrust_amount = Param::get($param, 'entrust_amount');
		$entrust_price = Param::get($param, 'entrust_price');
		$entrust_bs = Param::get($param, 'entrust_bs');
		$entrust_prop = Param::get($param, 'entrust_prop');

		if(!Trade::isTradeTime())
		{
			throw new ResultException(TRADE_TIME_INVALID);
		}

		$entrust_info = Request::entrust($stock_id, $exchange_type, $entrust_amount, $entrust_price, $entrust_bs, $entrust_prop);

		$result['errcode'] = SUCCESS;
		$result['entrust'] = $entrust_info;

		Response::output($result);
	}

	/**
	 * 预约委托
	 * @param $param
	 * @throws ResultException
	 */
	public static function actionPreviewEntrust($param)
	{
		User::checkLogin();

		$must = ['stock_id', 'exchange_type', 'entrust_amount', 'entrust_price', 'entrust_bs', 'valid_date', 'adventrust_type'];
		Param::judge($param, $must);

		$stock_id = Param::get($param, 'stock_id');
		$exchange_type = Param::get($param, 'exchange_type');
		$entrust_amount = Param::get($param, 'entrust_amount');
		$entrust_price = Param::get($param, 'entrust_price');
		$entrust_bs = Param::get($param, 'entrust_bs');
		$entrust_prop = Param::get($param, 'entrust_prop', '0');
		$valid_date = Param::get($param, 'valid_date', '0');
		$begin_date = Param::get($param, 'begin_date', '0');
		$adventrust_type = Param::get($param, 'adventrust_type', '0');

		$entrust_info = Request::previewEntrust($stock_id, $exchange_type, $entrust_amount, $entrust_price, $entrust_bs, $entrust_prop, $valid_date, $begin_date, $adventrust_type);

		$result['errcode'] = SUCCESS;
		$result['entrust'] = $entrust_info;

		Response::output($result);
	}

	/**
	 * 委托撤单
	 * @param $param
	 * @throws ResultException
	 */
	public static function actionCancelEntrust($param)
	{
		User::checkLogin();

		$must = ['entrust_no'];
		Param::judge($param, $must);

		$entrust_no = Param::get($param, 'entrust_no');

		$entrust_info = Request::cancelEntrust($entrust_no);

		$result['errcode'] = SUCCESS;
		$result['entrust'] = $entrust_info;

		Response::output($result);
	}

	/**
	 * 预约委托撤单
	 * @param $param
	 * @throws ResultException
	 */
	public static function actionCancelPreEntrust($param)
	{
		User::checkLogin();

		$must = ['entrust_no', 'entrust_date', 'exchange_type'];
		Param::judge($param, $must);

		$entrust_no = Param::get($param, 'entrust_no');
		$entrust_date = Param::get($param, 'entrust_date');
		$exchange_type = Param::get($param, 'exchange_type');

		$entrust_info = Request::cancelPreviewEntrust($entrust_no, $entrust_date, $exchange_type);

		$result['errcode'] = SUCCESS;
		$result['entrust'] = $entrust_info;

		Response::output($result);
	}

	/**
	 * 轮询委托号，查看委托结果
	 * @param $param
	 * @throws ResultException
	 */
	public static function actionPollingEntrustNo($param)
	{
		User::checkLogin();

		$must = ['bank_no', 'entrust_no'];
		Param::judge($param, $must);

		$bank_no = Param::get($param, 'bank_no');
		$entrust_no = Param::get($param, 'entrust_no');
		$action_in = Param::get($param, 'action_in', 0);
		$position_str = Param::get($param, 'position_str', '');
		$request_num = Param::get($param, 'request_num', 10);

		$entrust_info = Request::pollingEntrustNo($bank_no, $entrust_no, $action_in, $position_str, $request_num);

		$result['errcode'] = SUCCESS;
		$result['info'] = $entrust_info;

		Response::output($result);
	}
}