<?php
/**
 * mmseg old.txt转unigram.txt
 */

$file='./old.txt';
$unigram="./unigram.txt";

/**
 * 记录unigram.txt词典基础文件
 * @param string $unigram
 * @param string $str
 */
function ulog($unigram,$str){
	file_put_contents($unigram,$str.PHP_EOL,FILE_APPEND);
}

/**
 * 执行读取txt文件
 * @param string $file
 * @param string $unigram
 */
function run($file,$unigram){
	$handler=fopen($file,'r');
	while(!feof($handler)){
		$line=fgets($handler,1024);
		$line=trim($line);
		$str1=$line.'	1';
		$str2='x:1';
		ulog($unigram,$str1);
		ulog($unigram,$str2);
		echo $str1.PHP_EOL;
		echo $str2.PHP_EOL;
	}
	fclose($handler);
}

//main
run($file,$unigram);

/*
old.txt:

电脑IT
笔记本
宠物用品
狗用品
猫用品
美容化妆
彩妆
面部


unigram.txt:

电脑IT	1
x:1
笔记本	1
x:1
宠物用品	1
x:1
狗用品	1
x:1
猫用品	1
x:1
美容化妆	1
x:1
彩妆	1
x:1
面部	1
x:1
粉底	1
x:1
母婴用品	1

*/