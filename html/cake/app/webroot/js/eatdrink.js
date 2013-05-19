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
	$('.categoryNav .tile .inner.'+ cat).addClass('selected');

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
	$('.likeButton').on('keypress', likeSpot);
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

var LIKES_FILTER = 'likes';
var LOC_FILTER = 'location';
var activeSort = LIKES_FILTER;
function sortSpots() {
	if (activeSort === LIKES_FILTER) {
		if (navigator.geolocation) {
			sortByLocation();
		}
	} else {
		getSpots('pages/categoryByLikes', { });
	}
}

function toggleSortFilter(byLocation) {
	if (byLocation) {
		activeSort = LOC_FILTER;
		$('#sort-button').text('Sort by likes');
	} else {
		activeSort = LIKES_FILTER;
		$('#location-address').empty();
		$('#sort-button').text('Sort by my location');
	}
}

function sortByLocation() {
	navigator.geolocation.getCurrentPosition(function(position) {
		getLocation(position.coords.latitude, position.coords.longitude);
		getSpots('pages/categoryByLocation', { 'long': position.coords.longitude, 'lat': position.coords.latitude });
	}, function(error) {
		$('#location-address').text('Unable to get location | ');
		$('#location-address').append($('<a class="update-link">Try again</a>').on('click', sortByLocation));
		toggleSortFilter(true);
		// error.code can be:
		//   0: unknown error
		//   1: permission denied
		//   2: position unavailable (error response from locaton provider)
		//   3: timed out
	}, { timeout:10000 });
}

function getLocation(latitude, longitude) {
	$.ajax({
		url: 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' + latitude + ',' + longitude + '&sensor=true',
		type: 'GET',
		beforeSend : function() {
			$('#location-address').text('Locating...');
		},
		dataType: 'json'
	}).fail(function() {
		updateLocation('')
	}).done(updateLocation);
}

function updateLocation(data) {
	var location = 'Unable to get location';
	var msg = 'Try again';
	if (data !== '') {
		var results = data.results[0];
		location = '@ ' + results.address_components[0].short_name + ' ' + results.address_components[1].short_name;
		msg = 'Update';
	}
	$('#location-address').text(location + ' | ');
	$('#location-address').append($('<a class="update-link">' + msg + '</a>').on('click', sortByLocation));
}

function getSpots(url, data, byLocation) {
	var curl = window.location.href;
	data.category = curl.substring(curl.lastIndexOf('/') + 1);
	$.ajax({
		url: url,
		type: 'POST',
		data: data,
		dataType: 'json'
	}).done(function(data) {
		populateList(data);
		if ((/likes/i).test(url)) {
			toggleSortFilter(false);
		} else {
			toggleSortFilter(true);
		}
	});
}

function populateList(data) {
	if (data) {
		var h = "";
		$(data).each(function(i) {
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
		return '<div class="likeButton" tabindex="0">Like</div>';
	}	
	return '<div class="likeButtonDisabled"></div>';
}
function phoneStyled(number) {
	return number.substring(0, 3) + '.' + number.substring(3, 6) + '.' + number.substring(6);
}
function twitterHandle(url) {
	return url.substring(url.lastIndexOf('/') + 1);
}