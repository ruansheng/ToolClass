<?php
class Log {
	
	private static $handler;
	
	private static $filepath='./';
	
	private static $filename='./';
	
	public static function write($filename,$filepath,$content){
		$file=self::getFileName($filename,$filepath);
		$url=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	    $log_format="[".date('Y-m-d H:i:s',time())."]:"."\t".$url."\t".$content.PHP_EOL;
		file_put_contents($file,$log_format,FILE_APPEND);
	} 
	
	private function getFileName($filename,$filepath){
		if($filename==''){
			$filename=self::$filename;
		}
		if($filepath==''){
			$filepath=self::$filepath;
		}
		
		$file=$filepath.date('Y-m-d',time()).'_'.$filename.'.log';
		if(!is_dir($filepath)){
			@mkdir($filepath,0777,true);
		}
		if(!is_file($file)){
			$ht=fopen($file,'w+');
			fclose($ht);
		}
		return $file;
	}
	
}