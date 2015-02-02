<?php
include '../ImageResize.class.php';

$options=array(
	'mode'=>4,
	'percent'=>0.5,
);
$filePath='3.jpg';

$Image=new ImageResize($options);
$Image->outPutImage($filePath);