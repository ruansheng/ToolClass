<?php
/**
 * php socket 模拟GET 请求
 * /
define('HOST','www.baidu.com');
define('PORT',80);

$socket=socket_create(AF_INET, SOCK_STREAM, 0);
if(!$socket){
	echo socket_strerror(socket_last_error()).PHP_EOL;
}

$status=socket_connect($socket,HOST,PORT);
if(!$status){
	echo socket_strerror(socket_last_error()).PHP_EOL;
}

$string="GET / HTTP/1.1\r\n";
$string.="Host:".HOST."\r\n";
$string.="Connection:Close\r\n\r\n";

$writeString=socket_write($socket,$string,strlen($string));
if(!$writeString){
	echo socket_strerror(socket_last_error()).PHP_EOL;
}
$data=socket_read($socket,4096);

$sPatternSeperate = '/\r\n\r\n/';
$arMatchResponsePart = preg_split($sPatternSeperate, $data, 2);

echo $arMatchResponsePart[0];


