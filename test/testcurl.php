<?php
include '../Curl.class.php';

function testget($url){
	return Curl::get($url);
}

function testpost($url){
	return Curl::post($url);
}

$url='http://www.qwbcg.com';
//echo testget($url);
echo testpost($url);
