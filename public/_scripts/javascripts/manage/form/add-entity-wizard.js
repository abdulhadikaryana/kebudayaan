$(function(){

	//teh wizard parts!
	$('.next-button').click(function(){
		if(step == 1)
		{
			if($('#post_type').val() !== 0)
			{
				$('#step-'+step).hide();
				step++;
				$('#step-'+step).show();
				$('html, body').animate({scrollTop:0});

                BuildMap(false,'','');
			}
			else
			{
				$('#error-post_type').show().html('<li>Please choose a Post Type</li>');
			}
		}
	});

});