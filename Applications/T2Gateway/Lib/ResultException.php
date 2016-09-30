<?php
/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/6/28
 * Time: 下午4:27
 */

namespace Applications\T2Gateway\Lib;

use Applications\T2Gateway\Response;

class ResultException extends \Exception
{
	public function __construct($errcode, $message = '')
	{
		parent::__construct($message);
		$this->errcode = $errcode;
	}


	public function outputError()
	{
		$errcode = $this->errcode;
		$errmsg = $this->getMessage();

		$ret['errcode'] = $errcode;
		$ret['result'] = null;
		$ret['errmsg'] = $errmsg;

		Response::output($ret);
	}
}