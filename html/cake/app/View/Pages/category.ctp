<?php 
echo $this->element('categoryHeader');

App::uses('HttpSocket', 'Network/Http');
$eatdrink_config = Configure :: read('connection');
$eatdrinkConnectionString = $eatdrink_config['spotsdb'];

$http = new HttpSocket();
$response = $http->get($eatdrinkConnectionString);


$json = json_decode($response);

$spotsArray = array();

$selectedCategory = $category;

//Grab the spots for a specific category
foreach ($json as $key => $value) { 
	if ($json[$key]->category == $selectedCategory)
	{
     	array_push($spotsArray, $json[$key]);
    }
}

//print out all the spots for that category that was filtered out
foreach($spotsArray as $key => $spot)
{
	//echo '<div class="labelField"></div>';
	echo '<section class="spotCard">';
	echo '<div class="inner">';
	echo '<div class="displayField spotName"><a href="'.$spotsArray[$key]->website.'">'.$spotsArray[$key]->name.'</a></div>';
	echo '<div class="displayField spotAddress"><a href="'.$spotsArray[$key]->addressURL.'">'.$spotsArray[$key]->address.', '.$spotsArray[$key]->zip.'</a></div>';
	echo '<div class="displayField spotPhone"><a href="tel:'.$spotsArray[$key]->phone.'">'.substr($spotsArray[$key]->phone, 0, 3).'.'.substr($spotsArray[$key]->phone, 3, 3).'.'.substr($spotsArray[$key]->phone, 6, 4).'</a></div>';
	if($spotsArray[$key]->twitter != 'none')
	{
		$tw = $spotsArray[$key]->twitter;
		$tw = substr($tw, strrpos($tw, "/") + 1);
	echo '<div class="displayField spotTwitter"><a class="" href="'.$spotsArray[$key]->twitter.'">@'.$tw.'</a></div>';
	}
	echo '<div class="displayField"><span>Multiple Locations?</span><span class="spotMultipleLocations">'.$spotsArray[$key]->multipleLocations.'</span></div>';
	//echo '<div class="labelField">How many people dig this place too?</div>';
	//echo '<div class="displayField spotLikes">'.$spotsArray[$key]->likes.'</div>';
	echo '</div>';
	echo '</section>';
}
echo $this->element('footer');
?>