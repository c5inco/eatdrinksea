<?php 
App::uses('HttpSocket', 'Network/Http');
$eatdrink_config = Configure :: read('connection');

$http = new HttpSocket();
$cstring = $eatdrink_config['spots-db']."&s={'likes': -1, 'name': 1}&q={'category':'".$category."'}";
$response = $http->get($cstring);

$json = json_decode($response);

echo $this->element('categoryHeader');
echo '<input type="hidden" class="currentCategory" value="'.$category.'" />';

//print out all the spots for that category that was filtered out
echo '<div class="spots-list">';
foreach($json as $key => $value)
{
	//echo '<div class="labelField"></div>';
	echo '<section class="spotCard">';
	echo '<div class="inner">';
	echo "<input type='hidden' class='spotID' value='".json_encode($value->_id)."' />";
	echo '<div class="displayField spotName"><a href="'.$value->website.'">'.$value->name.'</a></div>';
	echo '<div class="displayField spotAddress"><a href="'.$value->addressURL.'">'.$value->address.', '.$value->zip.'</a></div>';
	echo '<div class="displayField spotPhone"><a href="tel:'.$value->phone.'">'.substr($value->phone, 0, 3).'.'.substr($value->phone, 3, 3).'.'.substr($value->phone, 6, 4).'</a></div>';
	if($value->twitter != 'none')
	{
		$tw = $value->twitter;
		$tw = substr($tw, strrpos($tw, "/") + 1);
		echo '<div class="displayField spotTwitter"><a class="" href="'.$value->twitter.'">@'.$tw.'</a></div>';
	}
	echo '<div class="displayField"><span>Multiple Locations?</span><span class="spotMultipleLocations">'.$value->multipleLocations.'</span></div>';
	echo '<div class="likeHolder"><span class="likesLabel"># of likes?</span>';
	echo '<div class="displayField spotLikes">'.$value->likes.'</div>';
	$cookieName = str_replace(' ', '_', $value->name);
	if(!isset($_COOKIE[$cookieName]))
	{
		echo '<div role="button" class="likeButton" tabindex="0">Like</div>';
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