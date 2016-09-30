<?php

namespace Applications\T2Gateway;
use GatewayWorker\Lib\Context;

/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/6/22
 * Time: 下午5:34
 */
class Router
{
	private static $controller_base_space = '\\Applications\\T2Gateway\\Controller\\';
	private static $action_prefix = 'action';
	private static $controller_prefix  = 'Controller';


	public static function dispatchRouter($route, $param)
	{
		if ($route === '')
		{
			$route = 'site/index';
		}

		$route = trim($route, '/');
		if (strpos($route, '//') !== false)
		{
			$route = 'site/index';
		}

		if (strpos($route, '/') !== false)
		{
			list ($id, $action) = explode('/', $route, 2);
		}
		else
		{
			$id = $route;
			$action = 'index';
		}

		$id = ucfirst($id);
		if (!class_exists(self::$controller_base_space . $id. self::$controller_prefix))
		{
			$id = 'site';
		}

		if (!is_callable(self::buildCallableRoute($id, $action)))
		{
			$action = 'index';
			if (!is_callable(self::buildCallableRoute($id, $action)))
			{
				$id = 'site';
			}
		}

		Context::$route = strtolower($id). "/". strtolower($action);
		call_user_func(self::buildCallableRoute($id, $action), $param);
	}

	private static function buildCallableRoute($id, $action)
	{
		$id = ucfirst($id);
		$function = '';
		$list = explode('-', $action);
		foreach ($list as $name)
		{
			$function .= ucfirst($name);
		}

		$id = $id. self::$controller_prefix;
		return self::$controller_base_space . $id . "::" . self::$action_prefix . $function;
	}

}