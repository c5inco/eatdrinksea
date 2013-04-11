<?php 
App::uses('HttpSocket', 'Network/Http');
$eatdrink_config = Configure :: read('connection');

$http = new HttpSocket();
$spotsArray = array();

echo $this->element('categoryHeader');

$cstring = $eatdrink_config['spots-db'];
$response = $http->get($cstring);

$json = json_decode($response);

echo '<input type="hidden" class="currentCategory" value="'.$category.'" />';

//Grab the spots for a specific category
foreach ($json as $key => $value) { 
	if ($json[$key]->category == $category)
	{
     	array_push($spotsArray, $json[$key]);
    }
}

//print out all the spots for that category that was filtered out
echo '<div class="spots-list">';
foreach($spotsArray as $key => $spot)
{
	//echo '<div class="labelField"></div>';
	echo '<section class="spotCard">';
	echo '<div class="inner">';
	echo "<input type='hidden' class='spotID' value='".json_encode($spotsArray[$key]->_id)."' />";
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
	echo '<div class="likeHolder"><span class="likesLabel"># of likes?</span>';
	echo '<div class="displayField spotLikes">'.$spotsArray[$key]->likes.'</div>';
	$cookieName = str_replace(' ', '_', $spotsArray[$key]->name);
	if(!isset($_COOKIE[$cookieName]))
	{
		echo '<div class="likeButton">Like</div>';
	}
	else {
		echo '<div class="likeButtonDisabled"></div>';
	}
	echo '</div>';
	echo '<div class="rankingNumber"></div>';
	echo '</div>';
	echo '</section>';
}
echo '</div>';
echo $this->element('footer');
?>