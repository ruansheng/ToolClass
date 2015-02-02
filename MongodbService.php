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
     * distinect
     * @param string $key
     */
    public function distinect($where){
	    	$collection=self::$collection;
	    	$flag=$collection->distinect($where);
	    	return $flag;
    }
    
    /**
     * drop collection
     * @param string $key
     */
    public function dropCollection(){
	    	$collection=self::$collection;
	    	$flag=$collection->drop();
	    	return $flag;
    }
    
    /**
     * collection count
     * @param string $key
     */
    public function count($where){
	    	$collection=self::$collection;
	    	$count=$collection->count($where);
	    	return $count;
    }
    
    /**
     * add set value
     * @param string $key
     */
    public function insert($document){
	    	$collection=self::$collection;
	    $flag=$collection->insert($document);
	    	return $flag;
    }

    /**
     * update value
     * @param string $key
     */
    public function update($where,$document){
	    	$collection=self::$collection;
	    	$flag=$collection->update($where,$document);
	    	return $flag;
    }
    
    /**
     * save set value
     * @param string $key
     */
    public function save($document){
	    	$collection=self::$collection;
	    	$flag=$collection->save($document);
	    	return $flag;
    }
    
    /**
     * delete value
     * @param string $key
     */
    public function delete($where,$justOne=true){
	    	$collection=self::$collection;
	    	$flag=$collection->remove($where,array('justOne'=>$justOne));
	    	return $flag;
    }
    
    /**
     * select all
     * @return $array
     */
    public function findOne($where,$field){
	    	$collection=self::$collection;
	    	$row = $collection->findOne($where,$field);
	    	return $row;
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

