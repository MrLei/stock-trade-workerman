<?php

/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/6/22
 * Time: 下午5:32
 */

namespace Applications\T2Gateway\Controller;

use Applications\T2Gateway\Response;

/**
 * 默认错误
 *
 * @access private
 * @package Applications\T2Gateway\Controller
 */
class SiteController
{
	/**
	 * 默认错误
	 * @param $param
	 */
	public static function actionIndex($param)
	{
		$result['errcode'] = FAIL;
		$result['errmsg'] = 'route error';
		Response::output($result);
	}
}