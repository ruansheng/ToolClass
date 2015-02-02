<?php

/**
 * Mongodb service
 * @author ruansheng
 */
class MongodbService {

	/**
	 * host
	 * @var string
	 */
	private static $host='127.0.0.1';
	
	/**
	 * port
	 * @var int
	 */
	private static $port=27017;
	
	/**
	 *  Mongodb handler
	 * @var resource
	 */
	private static $handler;
	
	/**
	 * DB
	 * @var resource
	 */
	private static $db;
	
	/**
	 * Collection
	 * @var resource
	 */
	private $collection;
	
    /**
     * getInstance
     */
    public static function getInstance(){
		if(!(self::$handler instanceof self)){
			$signal=new MongodbService();
			self::$handler=$signal->connect();
		}
		return $signal;
    }
    
    /**
     * new Mongodb
     * @return resource
     */
    private function connect(){
    		$server='mongodb://'.self::$host.':'.self::$port;
    		$mongodb=new MongoClient($server);
    		return $mongodb;
    }
    
    /**
     * show dbs
     */
    public function getDBs(){
    		return self::$handler->listDBs();
    }
    
    /**
     * selectDB
     * @param resource $db
     * @return self
     */
    public function selectDB($db){
		self::$db=self::$handler->selectDB($db);
		return self;
    }
    
    /**
     * select set
     * @param array $collection
     * @return self 
     */
    public function selectCollection($collection){
    		self::$collection=self::$db->$collection;
    		return self;
    }
    
    /**
     * add set value
     * @param string $key
     */
    public function insert($document){
	    	$collection=self::$collection;
	    	$collection->insert($document);
	    	return true;
    }	
    
    /**
     * select all
     * @return $array
     */
    public function selectAll(){
	    	$collection=self::$collection;
	    	$cursor = $collection->find();
	    	
	    	$result=array();
	    	foreach ($cursor as $document) {
	    		array_push($result,$document);
	    	}
	    	return $result;
    }
    
}

####  example   ####

$document = array( "title" => "Calvin and Hobbes", "author" => "Bill Watterson" );

$m=MongodbService::getInstance();
$dbs=$m->getDBs();

echo "<pre>";
print_r($dbs);
echo "</pre>";

