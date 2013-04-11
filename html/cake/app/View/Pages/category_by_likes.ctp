<?php
App::uses('HttpSocket', 'Network/Http');
$eatdrink_config = Configure :: read('connection');

$http = new HttpSocket();
$spotsArray = array();

$cstring = $eatdrink_config['spots-db']."&s={'likes': -1, 'name': 1}&q={'category':'".$category."'}";
$response = $http->get($cstring);

$json = json_decode($response);

if (isset($json)) {
	foreach ($json as $key => $value) {
		unset($value->category);
		unset($value->loc);
		array_push($spotsArray, $value);
	}
	echo json_encode($spotsArray);
}
?>