<?php
$config = [
	'lib_t2sdk_file' => '/Users/caizixin/php/extension/libt2sdk.so',
	'ini_file' => '/Users/caizixin/php/extension/t2sdk.ini',
//	'fund_account' => '70001172',
//	'password' => '111111',
];

$obj = new T2Connection($config);
echo 123;
var_dump($obj->p_connect());
echo 345;
var_dump($obj->p_login('70960283', '111111'));
//var_dump($obj->p_login('70001172', '111111'));
//var_dump($obj->p_req333001('dsf600036', '1', 18.1));
//var_dump($obj->p_req330300('781724', '0', '', '', 1));
//$data = $obj->p_req400('600036', '1');
//var_dump($obj->p_req333002('000666', '2', '100', '19.1', '1', '0'));
//var_dump($obj->p_req333140('600036', '1', 100, 18.1, '1', '0', 20160720, 20160720, '1'));
//var_dump($obj->p_req333142(212, 20160713, ''));

//$data = $obj->p_req333104('002809', '2', '1', '', 50);var_dump($data);
//$data = $obj->p_req333101('0', 0, '0', '0', '', 10);
//$data = $obj->p_req333100('0', '', 10);
//$data = $obj->p_req333102('0', '3', '0', ' ', 10);
//$data = $obj->p_req333103('', 10);
var_dump($data);
//var_dump($obj->p_req333017(7));
//var_dump($obj->p_req332200('1', '2', 1000, '', ''));
//var_dump($obj->p_req332253('1', '', ''));
//var_dump($obj->p_req332250('1', 8, 0, '', 10));
//var_dump($obj->p_req332254());
//var_dump($obj->p_req332255());
//var_dump($obj->p_req331157());

$start_date = 20150101;
$end_date = 20160727;
//var_dump($obj->p_req339204($start_date, $end_date, '1', 0, '', 10));

//var_dump($obj->p_req339200($start_date, $end_date, '', 10));

//var_dump($obj->p_req339300($start_date, $end_date, '', 1));

//var_dump($obj->p_req339304($start_date, $end_date, '', 10));
//var_dump($obj->p_req339303($start_date, $end_date, '', 10));

unset($obj);

var_dump(iconv('gbk', 'utf8', $data['errorMsg']), 123);

