/**
 * Registration.js
 */

$(function() {

});

function onThumbClick(type)
{
    $('.thumb').replaceWith('<img id="loader" src="' + imageUrl + '/loader/fb.gif" alt="" />');
    $.ajax({
       type: 'POST',
       url: baseUrl + '/ajax/thumb',
       data: {reviewId: reviewId, type: type},
       success: function(data) {
            $(data).insertAfter('.thumb-desc');
            $('.thumb-desc').html('Thank you..')
            $('#loader').remove();
            setCookie("thumb" + reviewId + '_' + sessUserId, "true", 365);
       }
    });
}

function setCookie(name, value, nDays)
{
    var expires = new Date ();
    expires.setTime(expires.getTime() + 1000 * 60 * 60 * 24 * nDays);

	document.cookie = name + "=" + escape(value) + "; expires=" + expires.toGMTString() + "; path=/";
}

