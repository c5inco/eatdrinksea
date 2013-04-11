<?php
App::uses('HttpSocket', 'Network/Http');
$eatdrink_config = Configure :: read('connection');

$http = new HttpSocket();
$spotsArray = array();

$data = array(
	"geoNear" => "Spots",
	"near" => array($long, $lat),
	"num" => 10,
	"query" => array("category" => $category)
);
$datajson = json_encode($data);
$cstring = $eatdrink_config['run-cmd'];
$response = $http->request(array(
	'method' => 'POST',
	'uri' => $cstring,
	'header' => array(
		'Content-Type' => 'application/json'
		),
	'body' => $datajson
));

$json = json_decode($response);

if (isset($json)) {
	foreach ($json->{'results'} as $key => $value) {
		unset($value->obj->category);
		unset($value->obj->loc);
		array_push($spotsArray, $value->obj);
	}
	echo json_encode($spotsArray);
}
?>