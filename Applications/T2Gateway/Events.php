<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
//declare(ticks=1);

use Applications\T2Gateway\Lib\ResultException;
use Applications\T2Gateway\Lib\KeepAlive;
use \GatewayWorker\Lib\Gateway;
use \Applications\T2Gateway\Lib\Request;
use \Applications\T2Gateway\Router;
use \Applications\T2Gateway\Response;
use Monolog\Handler\BufferHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Registry;
use Workerman\Lib\Timer;
use Applications\T2Gateway\Lib\User;
use GatewayWorker\Lib\Context;
/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{

	/**
	 * 日志初始化
	 */
	public static function onWorkerStart()
	{
		//定时器，每10s执行一次，判断用户连接是否超过最大连接时间，如果超过，连接断开
		Timer::add(10, ['\Applications\T2Gateway\Lib\KeepAlive', 'checkAlive']);

		$dir = __DIR__. '/../../log/';
		$infoLogger = new Logger('access');
		$stream = new StreamHandler($dir. 'access.log', Logger::INFO);
		$infoLogger->pushHandler(new BufferHandler($stream, 1, Logger::INFO, true, true));

		$errLogger = new Logger('error');
		$stream = new StreamHandler($dir. 'error.log', Logger::ERROR);
		$errLogger->pushHandler(new BufferHandler($stream, 1, Logger::ERROR, true, true));

		Registry::addLogger($infoLogger, 'access');
		Registry::addLogger($errLogger, 'error');
	}
	/**
	 * 当客户端连接时触发
	 * 如果业务不需此回调可以删除onConnect
	 *
	 * @param int $client_id 连接id
	 */
	public static function onConnect($client_id)
	{
		KeepAlive::addClient($client_id);
		$result['errcode'] = 0;
		Response::output($result);

		Registry::getInstance('access')->addInfo("connected", ['clinet_id' => $client_id]);
	}

	/**
	 * 当客户端发来消息时触发
	 * @param int $client_id 连接id
	 * @param mixed $message 具体消息
	 */
	public static function onMessage($client_id, $message)
	{
		// 向所有人发送
		$message = json_decode($message, true);

		//传入的消息不是一个数组，直接return，忽略该消息
		if(!is_array($message) || !isset($message['route']))
		{
			return;
		}

		$route = $message['route'];

		try
		{
			Context::$start_time = microtime(true);
			$log = Registry::getInstance('access');
			$log->addInfo("request start", $message);

			Context::$param_sign = isset($message['param_sign']) ? $message['param_sign'] : null;

			KeepAlive::updateClient($client_id);
			Router::dispatchRouter($route, $message);
		}
		catch(ResultException $e)
		{
			$e->outputError();
		}
		catch(\Exception $e)
		{
			Response::output(['errcode' =>  FAIL]);
		}
	}


	/**
	 * 当用户断开连接时触发
	 * @param int $client_id 连接id
	 */
	public static function onClose($client_id)
	{
		User::logout($client_id);
	}
}
