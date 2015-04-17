<?php
/**
 * @desc 根据两点间的经纬度计算距离
 * @param float $lng1 经度值1
 * @param float $lat1 纬度值1
 * @param float $lng2 经度值2
 * @param float $lat2 纬度值2
 * @return int  单位:米
 */
function getDistance($lng1,$lat1, $lng2,$lat2)
{
	$earthRadius = 6367000; //approximate radius of earth in meters

	$lat1 = ($lat1 * pi() ) / 180;
	$lng1 = ($lng1 * pi() ) / 180;

	$lat2 = ($lat2 * pi() ) / 180;
	$lng2 = ($lng2 * pi() ) / 180;

	$calcLongitude = $lng2 - $lng1;
	$calcLatitude = $lat2 - $lat1;
	$stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);
	$stepTwo = 2 * asin(min(1, sqrt($stepOne)));
	$calculatedDistance = $earthRadius * $stepTwo;

	return round($calculatedDistance);
}

//------------------------- php mongodb -------------------------------------

$mongo=new Mongo("mongodb://127.0.0.1:27017",array('connect'=>true));
$db = $mongo->test; //得到一个db对象

/*
$db->sphere->insert(array("id"=>1,"loc" =>array('type'=>'Point','coordinates'=>array(116.232656,40.000328))));
$db->sphere->insert(array("id"=>2,"loc" =>array('type'=>'Point','coordinates'=>array(116.47872,39.961405))));
$db->sphere->insert(array("id"=>3,"loc" =>array('type'=>'Point','coordinates'=>array(116.555759,39.877293))));
$db->sphere->insert(array("id"=>4,"loc" =>array('type'=>'Point','coordinates'=>array(116.217134,39.867104))));
$db->sphere->insert(array("id"=>5,"loc" =>array('type'=>'Point','coordinates'=>array(116.380985,39.823672))));
$db->sphere->insert(array("id"=>6,"loc" =>array('type'=>'Point','coordinates'=>array(116.400532,39.914492))));
$db->sphere->insert(array("id"=>7,"loc" =>array('type'=>'Point','coordinates'=>array(116.328667,39.901209))));
$db->sphere->insert(array("id"=>8,"loc" =>array('type'=>'Point','coordinates'=>array(116.417204,39.889252))));
$db->sphere->insert(array("id"=>9,"loc" =>array('type'=>'Point','coordinates'=>array(116.452849,39.938395))));
$db->sphere->insert(array("id"=>10,"loc" =>array('type'=>'Point','coordinates'=>array(116.233806,39.912279))));
$db->sphere->insert(array("id"=>11,"loc" =>array('type'=>'Point','coordinates'=>array(116.317169,39.948131))));
$db->sphere->insert(array("id"=>12,"loc" =>array('type'=>'Point','coordinates'=>array(116.320619,39.976446))));
$db->sphere->insert(array("id"=>13,"loc" =>array('type'=>'Point','coordinates'=>array(116.394783,40.002096))));
$db->sphere->insert(array("id"=>14,"loc" =>array('type'=>'Point','coordinates'=>array(116.519539,39.991041))));
$db->sphere->insert(array("id"=>15,"loc" =>array('type'=>'Point','coordinates'=>array(116.329817,40.004749))));
$db->sphere->insert(array("id"=>16,"loc" =>array('type'=>'Point','coordinates'=>array(116.371211,39.982638))));
$db->sphere->insert(array("id"=>17,"loc" =>array('type'=>'Point','coordinates'=>array(116.325793,39.991926))));
$db->sphere->insert(array("id"=>18,"loc" =>array('type'=>'Point','coordinates'=>array(116.31027,39.92733))));
$db->sphere->insert(array("id"=>19,"loc" =>array('type'=>'Point','coordinates'=>array(116.387884,39.934855))));
$db->sphere->insert(array("id"=>20,"loc" =>array('type'=>'Point','coordinates'=>array(116.410305,39.967599))));
*/

$map=array(
	"loc"=>array(
			'$near'=>array(
					'$geometry'=>array(
							'type'=>'Point',
							'coordinates'=>array(116.325793,39.991926),
					),
					'$maxDistance'=>10000,
			)
	)
);
$cursor = $db->sphere->find($map);

foreach ($cursor as $doc) {
	$dis=getDistance(116.325793,39.991926,$doc['loc']['coordinates'][0],$doc['loc']['coordinates'][1]);
	echo $dis."<br/>";
	echo '<pre>';
	 print_r($doc);
	echo '</pre>';
}


/*输出结果
0
Array
(
    [_id] => MongoId Object
        (
            [$id] => 5530ace649f18e11020041b7
        )

    [id] => 17
    [loc] => Array
        (
            [type] => Point
            [coordinates] => Array
                (
                    [0] => 116.325793
                    [1] => 39.991926
                )

        )

)
1466
Array
(
    [_id] => MongoId Object
        (
            [$id] => 5530ace649f18e11020041b5
        )

    [id] => 15
    [loc] => Array
        (
            [type] => Point
            [coordinates] => Array
                (
                    [0] => 116.329817
                    [1] => 40.004749
                )

        )

)
1776
Array
(
    [_id] => MongoId Object
        (
            [$id] => 5530ace649f18e11020041b2
        )

    [id] => 12
    [loc] => Array
        (
            [type] => Point
            [coordinates] => Array
                (
                    [0] => 116.320619
                    [1] => 39.976446
                )

        )

)
4002
Array
(
    [_id] => MongoId Object
        (
            [$id] => 5530ace649f18e11020041b6
        )

    [id] => 16
    [loc] => Array
        (
            [type] => Point
            [coordinates] => Array
                (
                    [0] => 116.371211
                    [1] => 39.982638
                )

        )

)
4922
Array
(
    [_id] => MongoId Object
        (
            [$id] => 5530ace649f18e11020041b1
        )

    [id] => 11
    [loc] => Array
        (
            [type] => Point
            [coordinates] => Array
                (
                    [0] => 116.317169
                    [1] => 39.948131
                )

        )

)
5981
Array
(
    [_id] => MongoId Object
        (
            [$id] => 5530ace649f18e11020041b3
        )

    [id] => 13
    [loc] => Array
        (
            [type] => Point
            [coordinates] => Array
                (
                    [0] => 116.394783
                    [1] => 40.002096
                )

        )

)
7299
Array
(
    [_id] => MongoId Object
        (
            [$id] => 5530ace649f18e11020041b8
        )

    [id] => 18
    [loc] => Array
        (
            [type] => Point
            [coordinates] => Array
                (
                    [0] => 116.31027
                    [1] => 39.92733
                )

        )

)
7687
Array
(
    [_id] => MongoId Object
        (
            [$id] => 5530ace649f18e11020041ba
        )

    [id] => 20
    [loc] => Array
        (
            [type] => Point
            [coordinates] => Array
                (
                    [0] => 116.410305
                    [1] => 39.967599
                )

        )

)
7984
Array
(
    [_id] => MongoId Object
        (
            [$id] => 5530ace649f18e11020041a7
        )

    [id] => 1
    [loc] => Array
        (
            [type] => Point
            [coordinates] => Array
                (
                    [0] => 116.232656
                    [1] => 40.000328
                )

        )

)
8258
Array
(
    [_id] => MongoId Object
        (
            [$id] => 5530ace649f18e11020041b9
        )

    [id] => 19
    [loc] => Array
        (
            [type] => Point
            [coordinates] => Array
                (
                    [0] => 116.387884
                    [1] => 39.934855
                )

        )

)
*/
