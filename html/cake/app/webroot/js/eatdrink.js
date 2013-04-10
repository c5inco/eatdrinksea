var KONAMIATTEMPT = "";
var THECODE = "38384040373937396665";
var spotsTmpl;

$(document).ready(function() {
	spotsTmpl = Mustache.compile($('#spots-tmpl').text());
	
	$(document).on("keydown", function(){
		//Save keycode of button press as string
		var keycode = "" + (event.keyCode ? event.keyCode : event.which);
		//Call konamiCode function to check
		konamiCode(keycode);
	});

	//Logic to highlight the selected category in the nav menu
	var cat = $('.currentCategory').val();
	$('.selected').removeClass('selected');
	$('.tile .' + cat).addClass('selected');

	//Logic to trim the ids of each spot and make usable
	$('.spotID').each(function( index ) {
	var id = $(this).val();

	var end = id.lastIndexOf('"');

	$(this).val(id.substring(9, end));
	});

	//Number each one of the spots in order as they appear on the page, they are already sorted
	//by likes on the get api call
	$('.rankingNumber').each(function(index) {
		$(this).text(index + 1);
	});

	//Logic for when the user clicks the like button to place a like
	$('.likeButton').on('click', likeSpot);
});

function likeSpot() {
	var name = $(this).parent().parent().find('.spotName').text();
	if(checkCookie(name))
	{
		var likesNum = parseInt($(this).parent().find('.spotLikes').text());
		likesNum += 1;
		likesNum.toString();
		var card = $(this).parent();
		$.ajax({
            url: '/pages/like',
            type: 'POST',
            data: {
                id: $(this).parent().parent().find('.spotID').val(),
                likes: likesNum,                  
            },
            success: function(response) {
                $(card).find('.spotLikes').text(likesNum);
                setCookie(name, "like", 999999);
                $(card).find('.likeButton').removeClass('likeButton').addClass('likeButtonDisabled').text('');
            }  
		});
	}
}

function checkCookie(name)
{
	var like = getCookie(name);
	if (!like || like === "") {
		return true;
	}
}

function getCookie(name) {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
	var end;
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    }
    else
    {
        begin += 2;
        end = document.cookie.indexOf(";", begin);
        if (end == -1) {
        	end = dc.length;
        }
    }
    return unescape(dc.substring(begin + prefix.length, end));
} 

function setCookie(cookieName,cookieValue,nDays) {
	 var today = new Date();
	 var expire = new Date();
	 if (nDays==null || nDays==0) nDays=1;
	 expire.setTime(today.getTime() + 3600000*24*nDays);
	 document.cookie = cookieName+"="+escape(cookieValue) + ";expires="+expire.toGMTString();
}

function konamiCode(keycode) {
	//Add this key press to variable to track presses
	KONAMIATTEMPT += keycode;

	//If the attempt grows more than 10 key presses, remove the first in the list
	if(KONAMIATTEMPT.length == 22)
	{
		KONAMIATTEMPT = KONAMIATTEMPT.slice(2);
	};

	//See if attempt matches the Konami Code
	if (THECODE == KONAMIATTEMPT)
	{
		//Do your whatever you'd like to do here once the user has successfully entered the Konami Code
		alert("The konami code hit!");
	};
}

function sortByLocation() {
	if (navigator.geolocation) {
		// TODO: Store location in cookie for later use
		navigator.geolocation.getCurrentPosition(function(position) {
			getLocation(position.coords.latitude, position.coords.longitude);
		}, function(error) {
			$('#location-address').text(' | Unable to get location');
			// error.code can be:
			//   0: unknown error
			//   1: permission denied
			//   2: position unavailable (error response from locaton provider)
			//   3: timed out
		});
	}
}

function getLocation(latitude, longitude) {
	$.ajax({
		url: 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' + latitude + ',' + longitude + '&sensor=true',
		type: 'GET',
		beforeSend : function() {
			$('#location-address').text(' | Locating...');
		}
	}).fail(function() {
		updateLocation('')
	}).done(updateLocation);
	
	var curl = window.location.href;
	var category = curl.substring(curl.lastIndexOf('/') + 1);
	$.ajax({
		url: 'pages/categoryByLocation',
		type: 'POST',
		data: { 
			'category': category, 
			'long' : longitude, 
			'lat' : latitude
		}
	}).done(populateList);
}

function updateLocation(data) {
	var location = 'Unable to get location';
	$('#location-button').text('Update location');
	if (data !== '') {
		var result = data['results'][0];
		var location = result.address_components[0].short_name;
		location += ' ' + result.address_components[1].short_name;
	}
	$('#location-address').text(' | ' + location);
}

function populateList(data) {
	if (data) {
		var spots = $.parseJSON(data);
		var h = "";
		$(spots).each(function(i) {
			this.id = this._id.$oid;
			this.phone_styled = phoneStyled(this.phone);
			this.twitter_handle = twitterHandle(this.twitter);
			this.likeBtn = displayLike(this.name);
			this.ranking = i + 1;
			h += spotsTmpl(this);
		});
		$('.spots-list').empty();
		
		var spotsHtml = $.parseHTML(h);
		$(spotsHtml).find('.likeButton').on('click', likeSpot);
		$('.spots-list').append(spotsHtml);
	}
}

function displayLike(spotName) {
	if(!getCookie(spotName) || getCookie(spotName) === '') {
		return '<div class="likeButton">Like</div>';
	}	
	return '<div class="likeButtonDisabled"></div>';
}
function phoneStyled(number) {
	return number.substring(0, 3) + '.' + number.substring(3, 6) + '.' + number.substring(6);
}
function twitterHandle(url) {
	return url.substring(url.lastIndexOf('/') + 1);
}