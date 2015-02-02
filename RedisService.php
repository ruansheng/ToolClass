<?php

/**
 * redis service
 * @author ruansheng
 */
class RedisService {

	/**
	 * host
	 * @var string
	 */
	private static $host='127.0.0.1';
	
	/**
	 * port
	 * @var int
	 */
	private static $port=6379;
	
	/**
	 *  redis handler
	 * @var resource
	 */
	private static $handler;
	
    /**
     * getInstance
     */
    public static function getInstance(){
		if(!(self::$handler instanceof self)){
			$signal=new RedisService();
			self::$handler=$signal->connect();
		}
		return $signal;
    }
    
    /**
     * new Redis
     * @return resource
     */
    private function connect(){
    		$redis=new Redis();
    		$redis->connect(self::$host,self::$port);
    		return $redis;
    }
    
    /**
     * get set value
     * @param string $key
     */
    public function getSet($key){
    		
    }
    
    /**
     * add set value
     * @param string $key
     */
    public function addSet($key,$val){
    		
    }	
    
    /**
     * rm set value
     * @param string $key
     */
    public function rmSet($key){
    
    }
    
}
