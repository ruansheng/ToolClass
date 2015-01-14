<?php
/**
 * 拉链法解决HashTable冲突
 */

/**
 * HashNode
 * @author ruansheng
 */
class HashNode {
	/**
	 * key
	 * @var string
	 */
	public $key;
	
	/**
	 * value
	 * @var mixed
	 */
	public $value;
	
	/**
	 * 指针
	 * @var *
	 */
	public $nextNode;
	
	/**
	 * 构造函数
	 */
	public function __construct($key,$value,$nextNode=NULL){
		$this->key=$key;
		$this->value=$value;
		$this->nextNode=$nextNode;
	}
}

/**
 * HashTable
 * @author ruansheng
 */
class HashTable {
	
	/**
	 * 存放数据的数组
	 * @var array
	 */
	private $buckets;
	
	/**
	 * 数组空间长度
	 * @var int
	 */
	private $size=10;
	
	/**
	 * 构造函数
	 */
	public function __construct(){
		$this->buckets=new SplFixedArray($this->size);
	}
	
	/**
	 * hash函数
	 * @param string $key
	 * @return number
	 */
	private function hashfunc($key){
		$strlen=strlen($key);
		$hashval=0;
		for($i=0;$i<$strlen;$i++){
			$hashval+=ord($key[$i]);
		}
		return $hashval % $this->size;
	}
	
	/**
	 * 插入
	 * @param string $key
	 * @param mixed $val
	 */
	public function insert($key,$val){
		$index=$this->hashfunc($key);
		/* 新创建一个节点 */
		if(isset($this->buckets[$index])){
			$newNode=new HashNode($key, $val,$this->buckets[$index]);
		}else{
			$newNode=new HashNode($key, $val,NULL);
		}
		$this->buckets[$index]=$newNode; /*保存新节点*/
	}
	
	/**
	 * 查找
	 * @param string $key
	 */
	public function find($key){
		$index=$this->hashfunc($key);
		$current=$this->buckets[$index];
		while(isset($current)){
			if($current->key==$key){
				return $current->value;
			}
			$current=$current->nextNode;
		}
		return NULL;
	}
	
}

//example:
$ht=new HashTable();
//insert
$ht->insert("key1","aaaa");
$ht->insert("key12","bbbb");
$ht->insert("key13","cccc");
$ht->insert("key14","dddd");

//find
echo $ht->find("key1");
echo "<br/>";
echo $ht->find("key12");
echo "<br/>";
echo $ht->find("key13");
echo "<br/>";
echo $ht->find("key14");


/*输出结果*/
/*
aaaa
bbbb
cccc
dddd
SplFixedArray Object
(
[0] => HashNode Object
(
[key] => key14
[value] => dddd
[nextNode] =>
)

[1] =>
[2] =>
[3] =>
[4] =>
[5] =>
[6] =>
[7] =>
[8] => HashNode Object
(
[key] => key12
[value] => bbbb
[nextNode] => HashNode Object
(
[key] => key1
[value] => aaaa
[nextNode] =>
)

)

[9] => HashNode Object
(
[key] => key13
[value] => cccc
[nextNode] =>
)

)
*/