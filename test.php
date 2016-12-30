<?php

$context = stream_context_create();
//Require verification of peer name
stream_context_set_option($context, 'ssl', 'verify_peer_name', false);
//是否需要验证 SSL 证书
stream_context_set_option($context, 'ssl', 'verify_peer', false);
//tcp不需要，在访问https的可能用的到
stream_context_set_option($context, 'ssl', 'verify_host', false);
$fp = stream_socket_client("ssl://182.92.170.3:8484", $errno, $errstr, 3,STREAM_CLIENT_CONNECT, $context);
if (!$fp) {
	echo "$errstr ($errno)<br />\n";
}
echo fgets($fp, 1024);

$cmd = '{"route":"user/login", "fund_account":"70001172", "password":"111111"}
';

//$cmd = publicKeyEncoding($cmd);


fwrite($fp, $cmd);
while (!feof($fp)) {
	echo fgets($fp, 1024);
}
fclose($fp);


function publicKeyEncoding($sourceStr)
{
	$key = file_get_contents('/Users/caizixin/nginx/server.crt');
	$publicId    = openssl_get_publickey($key);

	if (openssl_public_encrypt($sourceStr, $cryptText, $publicId))
	{
		return base64_encode("".$cryptText);
	}
}
