$(function(){
    initLogin();
    
    $('#loading').ajaxStart(function(){
	$(this).show();
    });
    $('#loading').ajaxStop(function(){
	$(this).hide();
    })
});


//$('#login').blur(function() {
//  alert('Handler for .blur() called.');
//});

function initLogin()
{
    $('#login-form').submit(function(){
	var username = $('#username').val();
	var password = $('#password').val();

	if(!cek(username) && !cek(password))
	{
	    $('.error').text("Please insert a username and password");
	    $('.error').show();
	}
	else if(!cek(username))
	{
	    $('.error').text("Please insert a username");
	    $('.error').show();
	}
	else if(!cek(password))
	{
	    $('.error').text("Please insert a password");
	    $('.error').show();
	}
	else
	{
	    $.ajax({
		type: $(this).attr('method'),
		url: $(this).attr('action'),
		data:$(this).serialize(),
		dataType: "json",
		success: function(data) {
		    if(data.hasil == true)
		    {
			window.location = data.url;
		    }
		    else
		    {
			$('.error').text("Username or password failed!");
			$('.error').show();
		    }
		}
	    });
	}
	return false;
    });
}

function cek(param)
{
    if(param == "" || param == 0)
    {
	return false;
    }
    else
    {
	return true;
    }
}