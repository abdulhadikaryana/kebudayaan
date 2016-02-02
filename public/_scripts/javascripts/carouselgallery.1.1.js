$(function() {
	
	$('.list_carousel').show();
	
	$('ul#basic_config').carouFredSel({
		circular: false,
		auto: false,
		prev: "#prev1",
		next: "#next1",
		width: 250,
		height: 45
	});

	$("a.gallery-carousel").fancybox({
		'titlePosition' : 'over',
		'onStart' : function(){
			pageTracker._trackPageview($(this).attr('href'));	
		}
	});
	
});