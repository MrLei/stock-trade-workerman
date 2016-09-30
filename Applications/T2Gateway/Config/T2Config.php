<?php
/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/6/22
 * Time: 下午3:27
 */

namespace Applications\T2Gateway\Config;

class T2Config
{
	public static $connection = [
		'test' => [
			'lib_t2sdk_file' => '/Users/caizixin/php/extension/libt2sdk.so',
			'ini_file' => '/Users/caizixin/php/extension/t2sdk.ini',
		],
		'qa' => [
			'lib_t2sdk_file' => '/data/work/php/extension/libt2sdk.so',
			'ini_file' => '/data/work/php/extension/t2sdk.ini',
		],
		'online' => [
			'lib_t2sdk_file' => '/data/work/php/extension/libt2sdk.so',
			'ini_file' => '/data/work/php/extension/t2sdk.ini',
		],
	];

	public static $trade = [
		'whiteList' => [

		],
		'blackList' => [
			'2016-04-04',
			'2016-05-02',
			'2016-06-09',
			'2016-06-10',
			'2016-09-15',
			'2016-10-01',
			'2016-10-02',
			'2016-10-03',
			'2016-10-04',
			'2016-10-05',
			'2016-10-06',
			'2016-10-07',
		],

		'tradeTime' => [
			'09:30:00' => '11:30:00',
			'13:00:00' => '15:00:00',
		],
		'orderTime' => [
			'00:00:00' => '09:25:00',
			'09:30:00' => '15:00:00',
		],
		'revokeTime' => [
			'00:00:00' => '09:20:00',
			'09:30:00' => '15:00:00',
			'20:00:00' => '23:59:59',
		],
		'auctionTime' => [
			'00:00:00' => '09:25:00',
			'20:00:00' => '23:59:59',
		],
	];

	public static function get($field, $data = [], $default = null)
	{
		if (is_array($data) && array_key_exists($field, $data))
		{
			return $data[$field];
		}

		if (property_exists(static::class, $field))
		{
			return static::$$field;
		}

		if (($pos = strrpos($field, ".")) !== false)
		{
			$data = static::get(substr($field, 0, $pos), $data, $default);
			$field = substr($field, $pos + 1);
		}

		if (is_array($data))
		{
			return array_key_exists($field, $data) ? $data[$field] : $default;
		}
		else
		{
			return $default;
		}
	}
}