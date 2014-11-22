<?php
/**
 * Curl Class
 * @author ruansheng
 */
class Curl {
	
	private static $handler;
	
	private static $defaultOptions=array(
			CURLOPT_CONNECTTIMEOUT => 30,  //连接等待时间
			CURLOPT_TIMEOUT => 60,  //最长请求时间
			CURLOPT_RETURNTRANSFER => 1,  //文件流的形式返回
			CURLOPT_FRESH_CONNECT => true  //每次都用新连接代替缓存中的连接
	);
	
	private static $options=array(
		
	);
	
	public static function init(){
		curl_setopt_array(self::$handler,self::$defaultOptions);
	}
	
	/**
	 * GET 请求
	 * @param string $url
	 * @return mixed
	 */
	public static function get($url){
		self::$handler= curl_init();
		curl_setopt(self::$handler,CURLOPT_URL,$url);
		self::init();
		$result = curl_exec(self::$handler);
		self::close();
		return $result;
	}

	/**
	 * POST 请求
	 */
	public static function post($url,$data=array()){
		self::$handler= curl_init();
		curl_setopt(self::$handler,CURLOPT_URL,$url);
		self::init();
		curl_setopt(self::$handler, CURLOPT_POST, 1);
		curl_setopt(self::$handler, CURLOPT_POSTFIELDS,$data);
		$result = curl_exec(self::$handler);
		self::close();
		return $result;
	}
	
	public static function setCookie(){
		
	}
	
	public static function close(){
		curl_close(self::$handler);
	}
	
}
