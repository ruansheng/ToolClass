<?php
/**
* Socket发数据
* @param 主机 $host
* @param 端口 $port
* @param 发送的数据 $msg
* @return boolean|string
*/
function SendSocketMsg($host,$port,$msg){
	$socket = socket_create(AF_INET,SOCK_STREAM,0);
	$result = socket_connect($socket,$host,$port);
	if ($result == false){
		return false;
	}
	socket_write($socket,$msg,strlen($msg));
	$recv_data = socket_read($socket,1024);
	socket_close ($socket);
	return $recv_data;
}

$result=SendSocketMsg('127.0.0.1',10000,'php');
echo $result;