var KONAMIATTEMPT = "";

$(document).ready(function() {
	$(document).on("keydown", function(){
		var keycode = "" + (event.keyCode ? event.keyCode : event.which);
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
	$('.likeButton').on('click', function() {
		var name = $(this).parent().parent().find('.spotName').text();
		if(checkCookie(name))
		{
			var likesNum = parseInt($(this).parent().find('.spotLikes').text());
			likesNum += 1;
			likesNum.toString();
			card = $(this).parent();
	       $.ajax({
	            url: '/pages/like',
	            type: 'POST',
	            data: {
	                id: $(this).parent().parent().find('.spotID').val(),
	                likes: likesNum,                  
	            },
	            success: function(response) {
	                $(card).find('.spotLikes').text(likesNum);
	                SetCookie(name, "like", 999999);
	                $(card).find('.likeButton').removeClass('likeButton').addClass('likeButtonDisabled').text('');
	            }  
			});
	   }
   });
});

function checkCookie(name)
{
	var like = getCookie(name);
	  if (like == null || like == "")
	  {
	  	return true;
	  }
}

function getCookie(name) {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    }
    else
    {
        begin += 2;
        var end = document.cookie.indexOf(";", begin);
        if (end == -1) {
        end = dc.length;
        }
    }
    return unescape(dc.substring(begin + prefix.length, end));
} 

function SetCookie(cookieName,cookieValue,nDays) {
	 var today = new Date();
	 var expire = new Date();
	 if (nDays==null || nDays==0) nDays=1;
	 expire.setTime(today.getTime() + 3600000*24*nDays);
	 document.cookie = cookieName+"="+escape(cookieValue)
	                 + ";expires="+expire.toGMTString();
}

function konamiCode(keycode) {
	KONAMIATTEMPT += keycode;

	if(KONAMIATTEMPT.length == 22)
	{
		KONAMIATTEMPT = KONAMIATTEMPT.slice(2);
	};

	var theCode = "38384040373937396665";
	if (theCode == KONAMIATTEMPT)
	{
		alert("The konami code hit! Check back soon for something good!");
	};
}