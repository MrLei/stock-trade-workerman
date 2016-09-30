<?php
/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/7/15
 * Time: 上午11:30
 */

namespace Applications\T2Gateway\Lib;


use GatewayWorker\Lib\Gateway;

class KeepAlive
{
	private static $client_access_time_mapping = [];


	public static function checkAlive()
	{
		foreach(self::$client_access_time_mapping as $client_id => $access_time)
		{
			self::checkOneAlive($client_id, $access_time);
		}
	}

	/**
	 * 判断用户连接是否超过最大连接时间，如果超过，连接断开
	 * @param $client_id
	 * @param $access_time
	 */
	public static function checkOneAlive($client_id, $access_time)
	{
		$now = time();
		if($now - $access_time > MAX_CONNECTION_LASTING_TIME)
		{
			Gateway::closeClient($client_id);
		}
	}

	public static function addClient($client_id)
	{
		self::$client_access_time_mapping[$client_id] = time();
	}

	public static function updateClient($client_id)
	{
		self::$client_access_time_mapping[$client_id] = time();
	}
}