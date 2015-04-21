/**
* server.php
*/
<?php
define('HOST','127.0.0.1');
define('PORT',11111);

$socket=socket_create(AF_INET,SOCK_STREAM,0);
if($socket==false){
	echo socket_strerror(socket_last_error()).PHP_EOL;
	exit;
}

$bindFlag=socket_bind($socket,HOST,PORT);
if(!$bindFlag){
	echo socket_strerror(socket_last_error()).PHP_EOL;
	exit;
}

$listenFlag=socket_listen($socket,5);
if(!$listenFlag){
	echo socket_strerror(socket_last_error()).PHP_EOL;
	exit;
}

while(1){
	$newSocket=socket_accept($socket);
	if(!$newSocket){
		echo socket_strerror(socket_last_error()).PHP_EOL;
	}
	
	$buf=socket_read($newSocket,1024);
	echo $buf.PHP_EOL;
	
	$string="hello world !";
	socket_write($newSocket,$string,strlen($string));
	
	socket_close($newSocket);
}

socket_close($socket);
?>


/**
* client.php
*/
<?php
define('HOST','127.0.0.1');
define('PORT',11111);

$socket=socket_create(AF_INET, SOCK_STREAM, 0);
if(!$socket){
	echo socket_strerror(socket_last_error()).PHP_EOL;
}

$status=socket_connect($socket,HOST,PORT);
if(!$status){
	echo socket_strerror(socket_last_error()).PHP_EOL;
}

$string='ruansheng';
$writeString=socket_write($socket,$string,strlen($string));
if(!$writeString){
	echo socket_strerror(socket_last_error()).PHP_EOL;
}
$data=socket_read($socket,1024);

echo 'result data:'.$data.PHP_EOL;
?>
