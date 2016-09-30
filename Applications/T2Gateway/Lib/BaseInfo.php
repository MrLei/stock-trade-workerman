<?php
/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/6/29
 * Time: 下午7:39
 */

namespace Applications\T2Gateway\Lib;


class BaseInfo
{
	public static $structInfo = null;

	public static function getStructInfo($info)
	{
		static::init();

		if(empty($info))
		{
			return null;
		}

		$attributes = static::getAttributes();
		$object = false;
		if (is_object($info))
		{
			$object = true;
		}
		else
		{
			if (!is_array($info))
			{
				return null;
			}
		}

		$structInfo = [];
		foreach ($attributes as $key => $value)
		{
			$attribute = null;
			if ($object)
			{
				if ($attribute === null && property_exists($info, $key))
				{
					$attribute = $info->$key;
				}
			}
			else
			{
				$attribute = isset($info[$key]) ? $info[$key] : null;
			}

			if ($attribute !== null)
			{
				if (is_int($value))
				{
					$structInfo[$key] = (int)$attribute;
				}
				elseif (is_float($value))
				{
					$structInfo[$key] = (float)$attribute;
				}
				elseif (is_bool($value))
				{
					$structInfo[$key] = (bool)$attribute;
				}
				elseif (is_array($value))
				{
					$structInfo[$key] = (array)$attribute;
				}
				else
				{
					$structInfo[$key] = (string)$attribute;
				}
			}
			else
			{
				$structInfo[$key] = $value;
			}
		}

		static::$structInfo = $structInfo;

		static::after();

		return static::$structInfo;
	}

	public static function init()
	{

	}

	public static function after()
	{

	}

	public static function getAttributes()
	{
		return [];
	}

}