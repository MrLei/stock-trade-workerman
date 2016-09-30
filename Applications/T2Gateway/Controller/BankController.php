<?php
/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/7/15
 * Time: 下午9:17
 */

namespace Applications\T2Gateway\Controller;


use Applications\T2Gateway\Info\BankInfo;
use Applications\T2Gateway\Info\UserFundInfo;
use Applications\T2Gateway\Lib\Common;
use Applications\T2Gateway\Lib\Param;
use Applications\T2Gateway\Lib\Request;
use Applications\T2Gateway\Lib\User;
use Applications\T2Gateway\Response;

/**
 * 银行类接口
 *
 * @category API
 * @package Applications\T2Gateway\Controller
 */
class BankController
{
	/**
	 * 客户银行账户查询
	 * @throws \Applications\T2Gateway\Lib\ResultException
	 */
	public static function actionInfo()
	{
		User::checkLogin();

		$bank_info = Request::bankInfo();
		Common::walkBuildStruct($bank_info, 'BankInfo');

		$result['errcode'] = SUCCESS;
		$result['bank_info'] = $bank_info;

		Response::output($result);
	}

	/**
	 * 客户银行账户查询
	 * @throws \Applications\T2Gateway\Lib\ResultException
	 */
	public static function actionFundInfo()
	{
		User::checkLogin();

		$bank_info = Request::bankInfo();
		Common::walkBuildStruct($bank_info, 'BankInfo');

		$fund_info = Request::userFund();

		$result['errcode'] = SUCCESS;
		$result['bank_info'] = $bank_info;
		$result['fund_info'] = UserFundInfo::getStructInfo($fund_info);

		Response::output($result);
	}

	/**
	 * 银行余额查询
	 * @param $param
	 * @throws \Applications\T2Gateway\Lib\ResultException
	 */
	public static function actionBalance($param)
	{
		User::checkLogin();

		$must = ['bank_no'];
		Param::judge($param, $must);

		$bank_no = Param::get($param, 'bank_no');
		$fund_password = Param::get($param, 'fund_password');
		$bank_password = Param::get($param, 'bank_password');

		$entrust = Request::bankBalance($bank_no, $fund_password, $bank_password);

		$result['errcode'] = SUCCESS;
		$result['entrust'] = $entrust;

		Response::output($result);
	}

	/**
	 * 银行转账
	 * @param $param
	 * @throws \Applications\T2Gateway\Lib\ResultException
	 */
	public static function actionTransfer($param)
	{
		User::checkLogin();

		$must = ['bank_no', 'transfer_direction', 'occur_balance'];
		Param::judge($param, $must);

		$bank_no = Param::get($param, 'bank_no');
		$transfer_direction = Param::get($param, 'transfer_direction');
		$occur_balance = Param::get($param, 'occur_balance');
		$fund_password = Param::get($param, 'fund_password');
		$bank_password = Param::get($param, 'bank_password');

		$entrust = Request::bankTransfer($bank_no, $transfer_direction, $occur_balance, $fund_password, $bank_password);

		$result['errcode'] = SUCCESS;
		$result['entrust'] = $entrust;

		Response::output($result);
	}

	/**
	 * 历史转账流水查询
	 * @param $param
	 */
	public static function actionTransferHistory($param)
	{
		User::checkLogin();

		$bank_no = Param::get($param, 'bank_no');
		$action_in = Param::get($param, 'action_in');
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
			$start_date = date('Ymd', strtotime('-1 days', strtotime($end_date)));
		}

		$transfer = Request::transferHistory($start_date, $end_date, $bank_no, $action_in, $position_str, $request_num);
		Common::walkBuildStruct($transfer, 'BankTransferInfo');

		$result['errcode'] = SUCCESS;
		$result['transfer'] = $transfer;

		Response::output($result);
	}


}