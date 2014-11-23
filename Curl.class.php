<?php
/**
 * Curl Class
 * @author ruansheng
 */
class Curl {
	
	/**
	 * 操作句柄
	 * @var mixed
	 */
	private static $handler;
	
	/**
	 * 默认HTTP设置
	 * @var array
	 */
	private static $defaultOptions=array(
			//连接等待时间
			CURLOPT_CONNECTTIMEOUT => 30, 
			//最长请求时间
			CURLOPT_TIMEOUT => 60,  
			//文件流的形式返回
			CURLOPT_RETURNTRANSFER => 1,  
			//每次都用新连接代替缓存中的连接
			CURLOPT_FRESH_CONNECT => true  
	);
	
	/**
	 * HHTPS 设置
	 * @var mixed
	 */
	private static $httpsOptions=array(
			//不验证证书
			CURLOPT_SSL_VERIFYPEER=>false,
			//不验证证书
			CURLOPT_SSL_VERIFYHOST=>false 
	);
	
	/**
	 * 请求结果码
	 * @var int
	 */
	private static $errno=0;
	
	/**
	 * 请求结果字符串信息
	 * @var string
	 */
	private static $errmsg='';
	
	/**
	 * 初始化 set HTTP选项
	 */
	private static function init(){
		curl_setopt_array(self::$handler,self::$defaultOptions);
	}
	
	/**
	 * set HTTPS选项
	 */
	private static function setHttps(){
		curl_setopt_array(self::$handler,self::$httpsOptions);
	}
	
	/**
	 * 封装执行请求
	 */
	private static function request($method,$url,$data=array()){
		self::$handler= curl_init();
		curl_setopt(self::$handler,CURLOPT_URL,$url);
		self::init();
		self::setHttps();
		if($method=='post'){
			curl_setopt(self::$handler, CURLOPT_POST, 1);
			curl_setopt(self::$handler, CURLOPT_POSTFIELDS,$data);
		}
		$result = curl_exec(self::$handler);
		self::setErrno();
		return $result;
	}
	
	/**
	 * GET 请求
	 * @param string $url
	 * @return mixed
	 */
	public static function get($url){
		$result=self::request('get',$url);
		self::close();
		return $result;
	}

	/**
	 * POST 请求
	 */
	public static function post($url,$data=array()){
		$result=self::request('get',$url);
		self::close();
		return $result;
	}
	
	/**
	 * 设置 请求结果码
	 */
	private static function setErrno(){
		if(curl_errno(self::$handler)){
			self::$errno=curl_errno(self::$handler);
			self::$errmsg=curl_error(self::$handler);
		}
	}
	
	/**
	 * 获取 请求结果码
	 */
	public static function getErrno(){
		return self::$errno;
	}
	
	/**
	 * 获取 请求结果字符串信息
	 */
	public static function getErrmsg(){
		return self::$errmsg;
	}
	
	/**
	 * 关闭 curl句柄
	 */
	private static function close(){
		curl_close(self::$handler);
	}
	
}
