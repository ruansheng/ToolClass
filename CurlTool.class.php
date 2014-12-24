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
	private $handler;
	
	/**
	 * 默认HTTP设置
	 * @var array
	 */
	private $defaultOptions=array(
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
	private $httpsOptions=array(
			//不验证证书
			CURLOPT_SSL_VERIFYPEER=>false,
			//不验证证书
			CURLOPT_SSL_VERIFYHOST=>false 
	);
	
	/**
	 * 请求结果码
	 * @var int
	 */
	private $errno=0;
	
	/**
	 * 请求结果字符串信息
	 * @var string
	 */
	private $errmsg='';
	
	/**
	 * 构造函数
	 */
	public function __construct(){
		$this->handler= curl_init();
		$this->init();
	}
	
	/**
	 * 初始化 set HTTP选项
	 */
	private function init(){
		curl_setopt_array($this->handler,$this->defaultOptions);
	}
	
	/**
	 * set HTTPS选项
	 */
	public function https(){
		curl_setopt_array($this->handler,$this->httpsOptions);
		return $this;
	}
	
	/**
	 * 封装执行请求
	 */
	private function request($url){
		curl_setopt($this->handler,CURLOPT_URL,$url);
		$result = curl_exec($this->handler);
		$this->setErrno();
		return $result;
	}
	
	/**
	 * 设置post参数
	 */
	public function data($data){
		curl_setopt($this->handler, CURLOPT_POST, 1);
		curl_setopt($this->handler, CURLOPT_POSTFIELDS,$data);
		return $this;
	}
	
	/**
	 * 设置请求头
	 */
	public function header($data){
		curl_setopt($this->handler, CURLOPT_HTTPHEADER,$data); //设置头信息
		return $this;
	}
	
	/**
	 * GET 请求
	 * @param string $url
	 * @return mixed
	 */
	public function get($url){
		$result=$this->request($url);
		$this->close();
		return $result;
	}

	/**
	 * POST 请求
	 */
	public function post($url){
		$result=$this->request($url);
		$this->close();
		return $result;
	}
	
	/**
	 * 设置 请求结果码
	 */
	private function setErrno(){
		if(curl_errno($this->handler)){
			$this->errno=curl_errno($this->handler);
			$this->errmsg=curl_error($this->handler);
		}
	}
	
	/**
	 * 获取 请求结果码
	 */
	public function getErrno(){
		return $this->errno;
	}
	
	/**
	 * 获取 请求结果字符串信息
	 */
	public function getErrmsg(){
		return $this->errmsg;
	}
	
	/**
	 * 关闭 curl句柄
	 */
	private function close(){
		curl_close($this->handler);
	}
}

$curl=new Curl();
echo $curl->data(array('name'=>'ruansheng'))->post("http://www.qwbcg.com/");
echo $curl->getErrmsg();
