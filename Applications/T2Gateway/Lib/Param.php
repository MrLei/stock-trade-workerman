<?php
/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/6/28
 * Time: 下午3:55
 */

namespace Applications\T2Gateway\Lib;

class Param
{
	public static function judge($param, $must)
	{
		foreach ($must as $key)
		{
			if (!isset($param[$key]))
			{
				throw new ResultException(PARAM_ERROR, $key);
			}
		}
	}

	public static function get($array, $key, $default = null)
	{
		if (is_array($array) && array_key_exists($key, $array))
		{
			return $array[$key];
		}

		if (($pos = strrpos($key, '.')) !== false)
		{
			$array = static::get($array, substr($key, 0, $pos), $default);
			$key = substr($key, $pos + 1);
		}

		if (is_object($array))
		{
			return $array->$key;
		} elseif (is_array($array))
		{
			return array_key_exists($key, $array) ? $array[$key] : $default;
		} else
		{
			return $default;
		}
	}
}