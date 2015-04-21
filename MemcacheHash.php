<?php
class memcacheHash{

	private static $_node = array();

	private static $_nodeData = array();

	private static $_keyNode = 0;

	private static $_memcache = null;

	private $_virtualNodeNum = 200;

	/**
	 * construct
	 * @throws Exception
	 */
	private function __construct() {
		$config = array(//五个memcache服务器
			'127.0.0.1:11211',
			'127.0.0.1:11212',
			'127.0.0.1:11213',
			'127.0.0.1:11214',
			'127.0.0.1:11215'
		);
		if (!$config){
			throw new Exception('Cache config NULL');
		}
		foreach ($config as $key => $value) {
			for ($i = 0; $i < $this->_virtualNodeNum; $i++) {
				self::$_node[sprintf("%u", crc32($value . '_' . $i))] = $value . '_' . $i;//循环为每个memcache服务器创建200个虚拟节点
			}
		}
		ksort(self::$_node);//创建出来的1000个虚拟节点按照键名从小到大排序
	}

	/**
	 * signal mode method
	 * @return Ambigous <NULL, memcacheHash>
	 */
	public static function getInstance(){
		static $memcacheObj = null;
		if(!is_object($memcacheObj)){
			$memcacheObj=new self();
		}
		return $memcacheObj;
	} 
	
	/**
	 * 连接memcahe服务器
	 * @param string $key
	 * @throws Exception
	 * @return Memcache
	 */
	private static function _connectMemcache($key){
		self::$_nodeData=array_keys(self::$_node);
		self::$_keyNode=sprintf('%u',crc32($key));
		$nodeKey=self::_findServerNode();
		if(self::$_keyNode>end(self::$_nodeData)){
			self::$_keyNode=end(self::$_nodeData);
			$nodeKey2=self::_findServerNode();
			if(abs($nodeKey2-self::$_keyNode)<abs($nodeKey-self::$_keyNode)){
				$nodeKey=$nodeKey2;
			}
		}
		
		list($config,$num)=explode('_',self::$_node[$nodeKey]);
		if(!$config){
			throw new Exception('Cache config Error');
		}
		
		if(!isset(self::$_memcache[$config])){
			self::$_memcache[$config]=new Memcache;
			list($host,$port)=explode(':',$config);
			self::$_memcache[$config]->connect($host,$port);
		}
		
		return self::$_memcache[$config];
	}
	
	/**
	 * 找出对应的虚拟节点
	 * 如果超出环，从头再用二分法查找一个最近的，然后环的头尾做判断，取最接近的节点  
	 */
	private static function _findServerNode($m=0,$b=0){
		$total=count(self::$_nodeData);
		if($total!=0&&$b==0){
			$b=$total-1;
		}
		if($m<$b){
			$avg=intval(($m+$b)/2);
			if(self::$_nodeData[$avg]==self::$_keyNode){
				return self::$_nodeData[$avg];
			}else if(self::$_keyNode<self::$_nodeData[$avg]&&($avg-1>=0)){
				return self::_findServerNode($avg+1,$b);
			}else{
				return self::_findServerNode($avg+1,$b);
			}
		}
		if(abs(self::$_nodeData[$b]-self::$_keyNode)<abs(self::$_nodeData[$m]-self::$_keyNode)){
			return self::$_nodeData[$b];
		}else{
			return self::$_nodeData[$m];
		}
	}
	
	/**
	 * set key value
	 * @param string $key
	 * @param string $value
	 * @param number $expire
	 * @return boolean
	 */
	public static function set($key,$value,$expire=0){
		return self::_connectMemcache($key)->set($key,json_encode($value),$expire);
	}
	
	
	public static function test(){
		echo '<pre>';
			print_r(self::$_node);
		echo '</pre>';
	} 
}

//test
$Obj=MemcacheHash::getInstance();
$Obj::test();
