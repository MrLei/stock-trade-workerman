<?php
/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/6/22
 * Time: 下午7:06
 */

namespace Applications\T2Gateway;


use GatewayWorker\Lib\Context;
use GatewayWorker\Lib\Gateway;
use Monolog\Registry;

/**
 * 统一内容输出类
 * Class Response
 * @package Applications\T2Gateway
 */
class Response
{
	public static function output($data)
	{
		$data['route'] = Context::$route;
		$data['param_sign'] = Context::$param_sign;
		$message = json_encode($data, JSON_UNESCAPED_UNICODE);
		Gateway::sendToCurrentClient($message);

		if (Context::$start_time > 0)
		{
			$cost = intval((microtime(true) - Context::$start_time) * 1000);
			$log = Registry::getInstance('access');
			$log->addInfo("request end", ['cost' => $cost]);
		}
	}
}