<?php

namespace Applications\T2Gateway\Lib;

use Applications\T2Gateway\Config\T2Config;
use GatewayWorker\Lib\Context;

/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/6/22
 * Time: 下午2:28
 */
class SingleT2Connection
{
	private static $instance = [];

	/**
	 * 单例
	 * @param $client_id
	 * @return null|\T2Connection
	 */
	public static function getInstance($client_id = null)
	{
		if(empty($client_id))
		{
			$client_id = Context::$client_id;
		}

		if (!empty(self::$instance[$client_id]))
		{
			return self::$instance[$client_id];
		}

		$conn = new \T2Connection(T2Config::get('connection.'. RUNTIME));
		$ret = $conn->p_connect();
		if ($ret == 0)
		{
			self::$instance[$client_id] = $conn;
		}

		return self::$instance[$client_id];
	}


	/**
	 * 断开T2连接, 释放资源
	 * 静态变量不能unset, 设置为null后貌似自动执行了unset的功能
	 * unset 释放资源
	 * @param $client_id
	 */
	public static function close($client_id)
	{
		unset(self::$instance[$client_id]);
	}
}