//OBJECT Tags
function tags()
{
    this.initBindTags = function()
    {
	self = this;
	this.bindAddTags();
	this.bindRemoveTags();
    }
    
    this.bindAddTags = function()
    {
	
	$("input#suggest").autocomplete(url+'/manage/suggest/tag/',
	{
	    extraParams: {
	      lang_id: $('#choose-language').val()
	    },
	    formatItem: function(data,i,max){
		//var str = data;
		var str = '<div class="search_content" style="float:left;">';
		str += data;
		str += '</div>';
		return str;
	    }        
	
	}).result(function(event, data, formatted) {
	    $(this).val('');
	    
	    if(($(data[0]).attr('class')) == 'event'){
	
		var id = $(data[0]).attr('id');
    
		var flag = jQuery.inArray(id,arrayEvent);
		if(flag < 0)
		{
		    arrayEvent.push(id);
		    statusTags = 1;
		
		    $('#listTag').show();
		    $('#listTag').append(formatted);
		    $('#error-tags').hide();
		
		}else{
		     alert('That tag already inserted');
		}
	    
	    }else if(($(data[0]).attr('class')) == 'dest'){
		var id = $(data[0]).attr('id');
    
		var flag = jQuery.inArray(id,arrayDest);
		if(flag < 0)
		{
		    arrayDest.push(id);
		    statusTags = 1;
		    //console.log(arrayEvent);
		
		    $('#listTag').show();
		    $('#listTag').append(formatted);
		    $('#error-tags').hide();
		
		}else{
		     alert('That tag already inserted');
		}
	    }else if(($(data[0]).attr('class')) == 'article'){
		var id = $(data[0]).attr('id');
    
		var flag = jQuery.inArray(id,arrayArticle);
		if(flag < 0)
		{
		    arrayArticle.push(id);
		    statusTags = 1;
		    //console.log(arrayEvent);
		
		    $('#listTag').show();
		    $('#listTag').append(formatted);
		    $('#error-tags').hide();
		
		}else{
		     alert('That tag already inserted');
		}	    
	    }


	});
    }

    this.bindRemoveTags = function()
    {
	//remove tag event
	$('.event').live('click', function(){
	    //dest-event-
	    //var id = ($(this).attr('id')).substr(11);
	    var id = $(this).attr('id');
	
	    arrayEvent = jQuery.grep(arrayEvent, function(value) {
		return value != id;
	    });            
	
	    $(this).hide();

	    //jika array 0 maka blok tag di hide
	    if(arrayEvent.length == 0 && arrayDest.length == 0 && arrayArticle.length == 0)
	    {
		$('#listTag').hide();
	    }
	});

	//remove tag destination
	$('.dest').live('click', function(){
	    var id = $(this).attr('id');
	
	    arrayDest = jQuery.grep(arrayDest, function(value) {
		return value != id;
	    });            

	    $(this).hide();
	    
	    //jika array 0 maka blok tag di hide
	    if(arrayEvent.length == 0 && arrayDest.length == 0 && arrayArticle.length == 0)
	    {
		$('#listTag').hide();
	    }
	});		


	//remove tag article
	$('.article').live('click', function(){
	    var id = $(this).attr('id');
	
	    arrayArticle = jQuery.grep(arrayArticle, function(value) {
		return value != id;
	    });            

	    $(this).hide();
	    
	    //jika array 0 maka blok tag di hide
	    if(arrayEvent.length == 0 && arrayDest.length == 0 && arrayArticle.length == 0)
	    {
		$('#listTag').hide();
	    }
	});

    }
}