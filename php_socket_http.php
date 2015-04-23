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

/*
HTTP/1.1 200 OK Date: Thu, 23 Apr 2015 10:43:23 GMT Content-Type: text/html Content-Length: 14613 Last-Modified: Wed, 03 Sep 2014 02:48:32 GMT Connection: Close Vary: Accept-Encoding Set-Cookie: BAIDUID=2B1E61769FFE882F890568BF389E1C4B:FG=1; expires=Thu, 31-Dec-37 23:55:55 GMT; max-age=2147483647; path=/; domain=.baidu.com Set-Cookie: BIDUPSID=2B1E61769FFE882F890568BF389E1C4B; expires=Thu, 31-Dec-37 23:55:55 GMT; max-age=2147483647; path=/; domain=.baidu.com Set-Cookie: BDSVRTM=0; path=/ P3P: CP=" OTI DSP COR IVA OUR IND COM " Server: BWS/1.1 X-UA-Compatible: IE=Edge,chrome=1 Pragma: no-cache Cache-control: no-cache BDPAGETYPE: 1 BDQID: 0xce9bd12b000005ef BDUSERID: 0 Accept-Ranges: bytes
*/
