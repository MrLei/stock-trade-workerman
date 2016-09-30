<?php
/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/6/22
 * Time: 下午2:41
 */

namespace Applications\T2Gateway\Lib;


use GatewayWorker\Lib\Gateway;
use Monolog\Registry;

final class Request
{
	/**
	 * ------------------------------------------用户系列分割线----------------------------------------------
	 */


	/**
	 * 用户登录
	 * @param $fund_account
	 * @param $password
	 * @return array
	 * @throws ResultException
	 */
	public static function login($fund_account, $password)
	{
		Registry::getInstance('access')->addInfo("[T2CMD]p_login start", func_get_args());

		$conn = static::getT2Connection();

		$user_info = $conn->p_login($fund_account, $password);

		static::checkResult($user_info);

		return $user_info[0];
	}

	/**
	 * 用户资金快速查询
	 * @return mixed
	 * @throws ResultException
	 */
	public static function userFundFast()
	{
		Registry::getInstance('access')->addInfo("[T2CMD]p_req332254 start", func_get_args());
		$conn = static::getT2Connection();

		$user_funds = $conn->p_req332254();

		static::checkResult($user_funds);
		return $user_funds[0];
	}

	/**
	 * 客户资金精确查询
	 * zval* req332255();
	 */
	public static function userFund()
	{
		Registry::getInstance('access')->addInfo("[T2CMD]p_req332255 start", func_get_args());

		$conn = static::getT2Connection();

		$user_funds = $conn->p_req332255();

		static::checkResult($user_funds);
		return $user_funds[0];
	}

	/**
	 * ------------------------------------------交易系列分割线----------------------------------------------
	 */


	/**
	 * 股票代码查询
	 * @param $stock_id
	 * @param $query_type
	 * @param $exchange_type
	 * @param string $position_str
	 * @param int $request_num
	 * @return array
	 * @throws ResultException
	 */
	public static function stockQuery($stock_id, $query_type = '0', $exchange_type = '', $position_str = '', $request_num = 10)
	{
		Registry::getInstance('access')->addInfo("[T2CMD]p_req330300 start", func_get_args());

		$conn = static::getT2Connection();

		$stock_info = $conn->p_req330300($stock_id, $query_type, $exchange_type, $position_str, $request_num);

		static::checkResult($stock_info);
		return $stock_info[0];
	}

	/**
	 * 获取股票五档行情
	 * 代码行情查询
	 * zval* req400(char* stock_id, char *exchange_type);
	 * @param $stock_id
	 * @param $exchange_type
	 * @param bool $strict
	 * @return array
	 * @throws ResultException
	 */
	public static function stockInfo($stock_id, $exchange_type, $strict = true)
	{
		Registry::getInstance('access')->addInfo("[T2CMD]p_req400 start", func_get_args());

		$conn = static::getT2Connection();

		$stock_info = $conn->p_req400($stock_id, $exchange_type);

		if(!static::checkResult($stock_info, $strict))
		{
			return [];
		}

		return $stock_info[0];
	}

	/**
	 * 大约可买获取
	 * zval* req333001(char* stock_id, char* exchange_type, double entrust_price);
	 * @param $stock_id
	 * @param $exchange_type
	 * @param $entrust_price
	 * @return array
	 * @throws ResultException
	 */
	public static function tradeCount($stock_id, $exchange_type, $entrust_price)
	{
		Registry::getInstance('access')->addInfo("[T2CMD]p_req333001 start", func_get_args());

		$conn = static::getT2Connection();

		$entrust_price = round($entrust_price, 3);
		$trade_count_info = $conn->p_req333001($stock_id, $exchange_type, $entrust_price);

		static::checkResult($trade_count_info);

		return $trade_count_info[0];
	}

	/**
	 * 普通委托
	 * zval* req333002(char *stock_id, char *exchange_type, int entrust_amount, double entrust_price, char entrust_bs, char * entrust_prop);
	 * @param $stock_id
	 * @param $exchange_type
	 * @param $entrust_amount
	 * @param $entrust_price
	 * @param $entrust_bs
	 * @param $entrust_prop
	 * @return array
	 * @throws ResultException
	 */
	public static function entrust($stock_id, $exchange_type, $entrust_amount, $entrust_price, $entrust_bs, $entrust_prop)
	{
		Registry::getInstance('access')->addInfo("[T2CMD]p_req333002 start", func_get_args());

		$conn = static::getT2Connection();

		$entrust_price = round($entrust_price, 3);
		$entrust_info = $conn->p_req333002($stock_id, $exchange_type, $entrust_amount, $entrust_price, $entrust_bs, $entrust_prop);

		static::checkResult($entrust_info);
		return $entrust_info[0];
	}

	/**
	 * //预约委托登记
	 * zval* req333140(char *stock_id, char *exchange_type, int entrust_amount, double entrust_price, char entrust_bs, char * entrust_prop, int valid_date, int begin_date, char adventrust_type);
	 * @param $stock_id
	 * @param $exchange_type
	 * @param $entrust_amount
	 * @param $entrust_price
	 * @param $entrust_bs
	 * @param $entrust_prop
	 * @param $valid_date
	 * @param $begin_date
	 * @param $adventrust_type
	 * @return
	 * @throws ResultException
	 */
	public static function previewEntrust($stock_id, $exchange_type, $entrust_amount, $entrust_price, $entrust_bs, $entrust_prop, $valid_date, $begin_date, $adventrust_type)
	{
		Registry::getInstance('access')->addInfo("[T2CMD]p_req333140 start", func_get_args());

		$conn = static::getT2Connection();

		$entrust_price = round($entrust_price, 3);
		$entrust_info = $conn->p_req333140($stock_id, $exchange_type, $entrust_amount, $entrust_price, $entrust_bs, $entrust_prop, $valid_date, $begin_date, $adventrust_type);

		static::checkResult($entrust_info);
		return $entrust_info[0];
	}

	/**
	 * 委托撤单
	 * zval* req333017(int entrust_no);
	 * @param $entrust_no
	 * @return
	 * @throws ResultException
	 */
	public static function cancelEntrust($entrust_no)
	{
		Registry::getInstance('access')->addInfo("[T2CMD]p_req333017 start", func_get_args());

		$conn = static::getT2Connection();

		$entrust_info = $conn->p_req333017($entrust_no);

		static::checkResult($entrust_info);
		return $entrust_info[0];
	}

	/**
	 * 预约委托撤单
	 * zval* req333142(int entrust_no, int entrust_date, char *exchange_type);
	 * @param $entrust_no
	 * @param $entrust_date
	 * @param $exchange_type
	 */
	public static function cancelPreviewEntrust($entrust_no, $entrust_date, $exchange_type)
	{
		Registry::getInstance('access')->addInfo("[T2CMD]p_req333142 start", func_get_args());

		$conn = static::getT2Connection();

		$entrust_info = $conn->p_req333142($entrust_no, $entrust_date, $exchange_type);

		static::checkResult($entrust_info);
		return $entrust_info[0];
	}

	/**
	 * 轮询委托序号，判断返回结果
	 * @param $bank_no
	 * @param $entrust_no
	 * @param $action_in
	 * @param $position_str
	 * @param $request_num
	 * @return mixed
	 * @throws ResultException
	 */
	public static function pollingEntrustNo($bank_no, $entrust_no, $action_in, $position_str, $request_num)
	{
		Registry::getInstance('access')->addInfo("[T2CMD]p_req332250 start", func_get_args());

		$conn = static::getT2Connection();

		$entrust_info = $conn->p_req332250($bank_no, $entrust_no, $action_in, $position_str, $request_num);

		static::checkResult($entrust_info);
		return $entrust_info[0];
	}


	/**
	 * ------------------------------------------查询系列分割线----------------------------------------------
	 */


	/**
	 * 证券持仓查询
	 * zval* req333104(char *stock_id, char *exchange_type, char query_mode, char *position_str, int request_num);
	 * @param $stock_id
	 * @param $exchange_type
	 * @param $query_mode
	 * @param $position_str
	 * @param $request_num
	 * @return
	 * @throws ResultException
	 */
	public static function stockHold($stock_id, $exchange_type, $query_mode, $position_str = '', $request_num = 100)
	{
		Registry::getInstance('access')->addInfo("[T2CMD]p_req333104 start", func_get_args());

		$conn = static::getT2Connection();

		$hold_list = $conn->p_req333104($stock_id, $exchange_type, $query_mode, $position_str, $request_num);

		static::checkResult($hold_list);

		return $hold_list;
	}

	/**
	 * 证券委托查询
	 * zval* req333100(char sort_direction, char *position_str, int request_num);
	 * @param $sort_direction 0正常 1倒叙
	 * @param $position_str
	 * @param $request_num
	 */
	public static function canCancelEntrustList($sort_direction, $position_str, $request_num)
	{
		Registry::getInstance('access')->addInfo("[T2CMD]p_req333100 start", func_get_args());

		$conn = static::getT2Connection();

		$entrust_list = $conn->p_req333100($sort_direction, $position_str, $request_num);

		static::checkResult($entrust_list);
		return $entrust_list;
	}

	/**
	 * 证券委托查询
	 * zval* req333101(char sort_direction, int action_in, char query_type, char query_mode, char *position_str, int request_num);
	 * @param $sort_direction 0正常 1倒叙
	 * @param $action_in
	 * @param $query_type
	 * @param $query_mode
	 * @param $position_str
	 * @param $request_num
	 */
	public static function entrustList($sort_direction, $action_in, $query_type, $query_mode, $position_str, $request_num)
	{
		Registry::getInstance('access')->addInfo("[T2CMD]p_req333101 start", func_get_args());

		$conn = static::getT2Connection();

		$entrust_list = $conn->p_req333101($sort_direction, $action_in, $query_type, $query_mode, $position_str, $request_num);

		static::checkResult($entrust_list);
		return $entrust_list;
	}

	/**
	 * 历史证券委托查询
	 * zval* req339303(int start_date, int end_date, char *position_str, int request_num);
	 * @param $start_date
	 * @param $end_date
	 * @param $position_str
	 * @param $request_num
	 * @return
	 * @throws ResultException
	 */
	public static function entrustHistory($start_date, $end_date, $position_str, $request_num)
	{
		Registry::getInstance('access')->addInfo("[T2CMD]p_req339303 start", func_get_args());

		$conn = static::getT2Connection();

		$entrust_list = $conn->p_req339303($start_date, $end_date, $position_str, $request_num);

		static::checkResult($entrust_list);
		return $entrust_list;
	}


	/**
	 * 证券成交查询
	 * zval* req333102(char sort_direction, char query_type, char query_mode, char *position_str, int request_num);
	 * @param $sort_direction
	 * @param $query_type
	 * @param $query_mode
	 * @param $position_str
	 * @param $request_num
	 * @return
	 * @throws ResultException
	 */
	public static function tradeList($sort_direction, $query_type, $query_mode, $position_str, $request_num)
	{
		Registry::getInstance('access')->addInfo("[T2CMD]p_req333102 start", func_get_args());

		$conn = static::getT2Connection();

		$trade_list = $conn->p_req333102($sort_direction, $query_type, $query_mode, $position_str, $request_num);

		static::checkResult($trade_list);
		return $trade_list;
	}

	/**
	 * 历史证券成交查询
	 * zval* req339304(int start_date, int end_date, char *position_str, int request_num);
	 * @param $start_date
	 * @param $end_date
	 * @param $position
	 * @param $request_num
	 */
	public static function tradeHistory($start_date, $end_date, $position, $request_num)
	{
		Registry::getInstance('access')->addInfo("[T2CMD]p_req339304 start", func_get_args());

		$conn = static::getT2Connection();

		$trade_list = $conn->p_req339304($start_date, $end_date, $position, $request_num);

		static::checkResult($trade_list);
		return $trade_list;
	}

	/**
	 * 证券持仓快速查询
	 * zval* req333103(char *position_str, int request_num);
	 * @param $position_str
	 * @param $request_num
	 * @return
	 * @throws ResultException
	 */
	public static function fastHoldStock($position_str, $request_num)
	{
		Registry::getInstance('access')->addInfo("[T2CMD]p_req333103 start", func_get_args());

		$conn = static::getT2Connection();

		$hold_list = $conn->p_req333103($position_str, $request_num);

		static::checkResult($hold_list);
		return $hold_list;
	}

	/**
	 * 历史资金流水查询
	 * zval* req339200(int start_date, int end_date, char *position_str, int request_num);
	 * @param $start_date
	 * @param $end_date
	 * @param $position_str
	 * @param $request_num
	 */
	public static function fundHistory($start_date, $end_date, $position_str, $request_num)
	{
		Registry::getInstance('access')->addInfo("[T2CMD]p_req339200 start", func_get_args());

		$conn = static::getT2Connection();

		$entrust = $conn->p_req339200($start_date, $end_date, $position_str, $request_num);

		static::checkResult($entrust);
		return $entrust;
	}

	/**
	 * 历史交割信息查询
	 * zval* req339300(int start_date, int end_date, char *position_str, int request_num);
	 * @param $start_date
	 * @param $end_date
	 * @param $position_str
	 * @param $request_num
	 * @return
	 * @throws ResultException
	 */
	public static function deliveryHistory($start_date, $end_date, $position_str, $request_num)
	{
		Registry::getInstance('access')->addInfo("[T2CMD]p_req339300 start", func_get_args());

		$conn = static::getT2Connection();

		$entrust = $conn->p_req339300($start_date, $end_date, $position_str, $request_num);

		static::checkResult($entrust);
		return $entrust;
	}


	/**
	 * ------------------------------------------银行系列分割线----------------------------------------------
	 */




	/**
	 * 客户银行账户查询
	 * @return mixed
	 * @throws ResultException
	 */
	public static function bankInfo()
	{
		Registry::getInstance('access')->addInfo("[T2CMD]p_req331157 start", func_get_args());

		$conn = static::getT2Connection();

		$bank_fund = $conn->p_req331157();

		static::checkResult($bank_fund);
		return $bank_fund;
	}

	/**
	 * 银行余额查询
	 * @param $bank_no
	 * @param $fund_password
	 * @param $bank_password
	 * @return mixed
	 * @throws ResultException
	 */
	public static function bankBalance($bank_no, $fund_password, $bank_password)
	{
		Registry::getInstance('access')->addInfo("[T2CMD]p_req332253 start", func_get_args());

		$conn = static::getT2Connection();

		$entrust = $conn->p_req332253($bank_no, $fund_password, $bank_password);

		static::checkResult($entrust);
		return $entrust[0];
	}

	/**
	 * 银行转账
	 * zval* req332200(char *bank_no, char transfer_direction, double occur_balance, char *fund_password, char *bank_password);
	 * @param $bank_no
	 * @param $transfer_direction 1–银行转证券 2- 证券转银行
	 * @param $occur_balance
	 * @param $fund_password
	 * @param $bank_password
	 */
	public static function bankTransfer($bank_no, $transfer_direction, $occur_balance, $fund_password, $bank_password)
	{
		Registry::getInstance('access')->addInfo("[T2CMD]p_req332200 start", func_get_args());

		$conn = static::getT2Connection();

		$entrust = $conn->p_req332200($bank_no, $transfer_direction, $occur_balance, $fund_password, $bank_password);

		static::checkResult($entrust);
		return $entrust[0];
	}



	/**
	 * 历史转账流水查询
	 * zval* req339204(int start_date, int end_date, char *bank_no, int action_in, char *position_str, int request_num)
	 * @param $start_date
	 * @param $end_date
	 * @param $bank_no
	 * @param $action_in
	 * @param $position_str
	 * @param $request_num
	 */
	public static function transferHistory($start_date, $end_date, $bank_no, $action_in, $position_str, $request_num)
	{
		Registry::getInstance('access')->addInfo("[T2CMD]p_req339204 start", func_get_args());

		$conn = static::getT2Connection();

		$entrust = $conn->p_req339204($start_date, $end_date, $bank_no, $action_in, $position_str, $request_num);

		static::checkResult($entrust);
		return $entrust;
	}


	/**
	 * ------------------------------------------通用代码分割线----------------------------------------------
	 */


	/**
	 * @param bool|true $strict
	 * @return bool|null|\T2Connection
	 * @throws ResultException
	 * @throws \Exception
	 */
	public static function getT2Connection($strict = true)
	{
		$conn = SingleT2Connection::getInstance();
		if(!$conn instanceof \T2Connection)
		{
			//如果找不到T2Connection，那么直接断开连接，需要用户重新建立长连接
			if($strict)
			{
				Gateway::closeCurrentClient();
				throw new ResultException(CONNECTION_CLOSE);
			}

			return false;
		}

		return $conn;
	}


	/**
	 * 将返回数据转换成utf8, 并校验返回的结果是否正确
	 * @param $result
	 * @param bool|true $strict
	 * @return bool
	 * @throws ResultException
	 */
	public static function checkResult(&$result, $strict = true)
	{
		$result = static::gbkToUtf8($result);

		if(!is_array($result))
		{
			if($strict)
			{
				throw new ResultException(FAIL, '请求T2失败');
			}

			return false;
		}

		if(static::checkError($result))
		{
			if($strict)
			{
				throw new ResultException($result['error_no'], $result['error_info']);
			}

			$result['errcode'] = $result['error_no'];
			$result['errmsg'] = $result['error_info'];

			unset($result['error_no']);
			unset($result['error_info']);
			return false;
		}

		return true;
	}

	public static function checkError($result)
	{
		if(isset($result[0]))
		{
			$result = $result[0];
		}

		return isset($result['error_no']) && $result['error_no'] != 0;
	}

	/**
	 * @param $data
	 * @return array
	 */
	public static function gbkToUtf8($data)
	{
		if (!is_array($data))
		{
			return iconv('gbk', 'utf-8', $data);
		}

		foreach($data as &$value)
		{
			if(is_array($value))
			{
				$value = static::gbkToUtf8($value);
			}
			else
			{
				$value = iconv('gbk', 'utf-8', $value);
				$value = trim($value);
			}
		}

		return $data;

//		return array_filter($data, function ($value)
//		{
//			if(is_array($value))
//			{
//				return static::gbkToUtf8($value);
//			}
//
//			return iconv('gbk', 'utf-8', $value);
//		});
	}
}