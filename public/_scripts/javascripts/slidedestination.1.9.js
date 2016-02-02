var firstLeft = 0;
var counter = 1;
var elementWidth = 0;
var widthAndMargin = 0;
var slidea = 0;
var now = new Date();
var before = new Date();
var slideinterval = null;

jQuery.fn.reverse = function() {
	return this.pushStack(this.get().reverse(), arguments);
};

function resetNavBg()
{
	$('.panel li').css('background-position','0 0');
}

function initSize(width, margin)
{
	initLeft = 0;
	elementWidth = width;
	widthAndMargin = elementWidth + (margin*2);
	$('.page').each(function(){
		$(this).css('left', initLeft);
		$(this).css('width', elementWidth);
		initLeft = initLeft + elementWidth + (margin*2);
	});
	$('.slider').width(initLeft);
}

function resetCounter()
{
	newLeft = (counter-1) * widthAndMargin;
	$('.page').each(function(){
		$(this).reverse().animate({left: '+='+newLeft.toString() });
	});
	counter = 1;					
}

function setIndex(index)
{
	newLeft = (counter-(index+1)) * widthAndMargin;

	$('.page').each(function(){
		if(newLeft > 0)
		{
			$(this).reverse().animate({left: '+='+newLeft.toString() });
			counter = index+1;
		}
		else if(newLeft < 0)
		{
			$(this).reverse().animate({left: '+='+newLeft.toString() });
			counter = index+1;
		}
	});
	
	resetNavBg();
	$('.panel li:nth-child('+counter+')').css('background-position','-17px 0');
}

function slidingDiv()
{
	firstLeft = $('.page:nth-child(1)').css('left').
		replace(/([\d.]+)(px|pt|em|%)/,'$1');
	
	if(counter < $('.page').length)
	{
		$('.page').each(function(){
			$(this).animate({left: '-='+widthAndMargin });
		});
		counter++;
	}
	else
	{
		resetCounter();
	}
	resetNavBg();
	$('.panel li:nth-child('+counter+')').css('background-position','-17px 0');
}

$(function(){

    $(window).blur(function(){
        clearInterval(slideinterval);
    });

    $(window).focus(function(){
        if($('.slider').length > 0)
        {
            now = new Date();
            var elapsedTime = (now.getTime() - before.getTime());
            if(elapsedTime > 0)
            {
                clearInterval(slideinterval);
                $('.page').each(function(){
                    $(this).stop(true);
                });
                slideinterval = setInterval( "slidingDiv()", 5000 );
            }
            before = new Date();
        }
    });

	if($('.slider').length > 0)
	{   
		$('.slider').show();
		initSize(310, 10);
		$('.panel li:nth-child('+counter+')').css('background-position','-17px 0');
		slideinterval = setInterval( "slidingDiv()", 5000 );
		$('.panel li').click(function(){
			setIndex($(this).index());
			clearInterval(slideinterval);
		});
	}

});