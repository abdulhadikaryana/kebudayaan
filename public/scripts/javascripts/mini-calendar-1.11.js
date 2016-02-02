
$(function(){

var firstLoad = true;
var eventArr = [];

	if($('#mini-calendar').length > 0)
	{
		$('#home-event-list-placeholder').jScrollPane({
			autoReinitialise: true,
			showArrows: true,
			arrowScrollOnHover: true			
		});
		
		$('#mini-calendar').fullCalendar({
			ignoreTimezone: false,
            viewDisplay: function(view){
	        	 eventArr = [];
				 //remove the content of the list
	        	 $('#home-event-list').empty();
	             dateArr = [];       
	             var today = view.start;
	             var viewData = $('#mini-calendar').fullCalendar('getView');
	             
				 cMonth = today.getMonth();
	             cYear = today.getFullYear();
	             $('td.fc-widget-content').css('background','#99CCFF');
	
	             $('.fc-day-number').each(function(){
	                
	                lDay = parseInt($(this).text());
	                //check if it is another month date
					lYear = parseInt(cYear);
	                if($(this).parents('td').hasClass('fc-other-month'))
	                {
			      //if it is belong to the previous month
	                    if(lDay>15)
	                    {
	                        lMonth = parseInt(cMonth) - 1;
	                        lDate = new Date(lYear,lMonth,lDay);
	                        dateArr.push(lDate);
	                    }
	                    else //belong to the next month
	                    {
	                        lMonth = parseInt(cMonth) + 1;
	                        lDate = new Date(lYear,lMonth,lDay);
	                        dateArr.push(lDate);
	                    }
	                }
	                else
	                {
	                    lMonth = parseInt(cMonth);
	                    lDate = new Date(lYear,lMonth,lDay);
	                    dateArr.push(lDate);
	                }
	            });
	        },
			header: {
				left: 'prev',
				center: 'title',
				right: 'next'
			},
			eventRender: function(event,element){
				//coloring the background
				for(var i in dateArr)
	            {
	                if(event.end == null){event.end = event.start;}
                    	  if((dateArr[i].getTime() >= event.start.getTime())
                            &&(dateArr[i].getTime() <= event.end.getTime())
                            || (dateArr[i].getDate() == event.start.getDate()
                            && dateArr[i].getDate() == event.end.getDate()))
	                {
	                    $('.fc-day'+i).css('background','#FFCCCC');
	                }
	            }
	            //get data, parse, and create the list
				if(jQuery.inArray(event._id, eventArr) < 0)
				{
					//addEvent(event);
					eventArr.push(event._id);
				}
				
				if($('#home-event-list').is(':empty'))
				{
					elist = $('#mini-calendar').fullCalendar('clientEvents');
					
					$.each(elist, function(index, value){
						addEvent(value);
					});
				}
			},
			loading: function(isLoading, view){
				if (isLoading) $('#boxLoading').show();
				else $('#boxLoading').hide();
				
				if(isLoading)
				{
					if(firstLoad == true)
					{
						firstLoad = false;
					}
					else
					{
						pageTracker._trackPageview("/event/mini-calendar");
					}
				}
			
			},
			events: baseUrl + '/ajax/eventlist'
		});
	}
});

function addEvent(event)
{
	html = 	'<h3>'+
				'<a href = "'+event.url+'">'+event.title+'</a>'+
			'</h3>'+
			'<p class="en-meta-event">';
	if($.fullCalendar.formatDate(event._start, 'dd MMM yyyy') != 
		$.fullCalendar.formatDate(event._end, 'dd MMM yyyy'))
	{
		html = html + mulai + ' <b> '+ $.fullCalendar.formatDate(event._start, 'dd MMM yyyy') + ' </b> '+
					  akhir + ' <b> '+ $.fullCalendar.formatDate(event._end, 'dd MMM yyyy') + ' </b> ';
	}
	else
	{
		html = html + tanggal + ' <b> '+$.fullCalendar.formatDate(event._start, 'dd MMM yyyy')+' </b> ';
	}
	
	html = html + '</p><br/>';
	$('#home-event-list').append(html);
}