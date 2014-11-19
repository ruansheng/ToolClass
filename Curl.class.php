<?php
/**
 * Curl Class
 * @author ruansheng
 */
class Curl {
	
	private static $defaultOptions=array(
			CURLOPT_CONNECTTIMEOUT => 30,  //连接等待时间
			CURLOPT_TIMEOUT => 60,  //最长请求时间
			CURLOPT_RETURNTRANSFER => 1,  //文件流的形式返回
			CURLOPT_FRESH_CONNECT => true  //每次都用新连接代替缓存中的连接
	);
	
	private static $options=array(
		
	);
	
	public static function get(){
		
	}

	public static function post(){
	
	}
	
	public static function setCookie(){
	
	}
	
}
