$(document).ready(function() {
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
            }  
	});
   });
});