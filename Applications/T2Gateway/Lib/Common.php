<?php
/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/7/25
 * Time: 下午5:16
 */

namespace Applications\T2Gateway\Lib;


class Common
{
	public static $struct_info_base = 'Applications\\T2Gateway\\Info\\';

	public static function walkBuildStruct(&$info, $struct)
	{
		if(!is_array($info) || empty($info))
		{
			$info = [];
			return;
		}

		array_walk($info, __NAMESPACE__. '\\Common::buildStruct', $struct);
	}

	public static function buildStruct(&$value, $key, $struct)
	{
		$class = static::$struct_info_base. $struct;
		if(!class_exists($class))
		{
			$value = null;
			return;
		}

		$value = call_user_func([$class, 'getStructInfo'], $value);
	}
}