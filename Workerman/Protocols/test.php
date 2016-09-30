<?php
/**
 * Created by PhpStorm.
 * User: caizixin
 * Date: 16/7/14
 * Time: 下午3:37
 */

require_once('Rsa.php');
use Workerman\Protocols;

$data= [
	'route' => 'user/login',
	'fund_account' => '70960283',
	'password' => '111111',
];

output($data);

$data= [
	'route' => 'bank/balance',
	'bank_no' => '1',
	'fund_password' => '',
	'bank_password' => '',
];
//output($data);

$data = [
	'route' => 'trade/polling-entrust-no',
	'bank_no' => '1',
	'entrust_no' => 1,
];
//output($data);

$data = [
	'route' => 'trade/stock-query',
	'stock_id' => '600036',
];
output($data);

//$data = ['route' => 'user/logout'];
//$data = ['route' => 'bank/index'];


function output($data)
{
	$data = json_encode($data);

	//$data = '{"route":"trade/stock-query","stock_id":"600036","exchange_type":"1"}';

	$encodeStr = Protocols\Rsa::publicKeyEncoding($data);

	var_dump($encodeStr);

	var_dump(Protocols\Rsa::privateKeyDecoding($encodeStr));
}
