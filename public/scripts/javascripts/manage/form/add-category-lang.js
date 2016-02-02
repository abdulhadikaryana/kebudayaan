/*
	Berisi perintah2 untuk menangani proses pembuatan userstory content baru
	yang berbeda bahasa.
*/

var arrayEvent = [];	//array tag event
var arrayDest = [];  	//array tag destination
var arrCategory = []; 	//array tag category

var article = {		    //article container
    content : []
};

//ready function
$(function(){
	$("select#choose-language option[value='0']").attr("selected", "selected");
	
	//init function
	initCategory();
	tinyEdit();
	initSave();
	initTags();


    /* bind change language */
    $('#choose-language').change(function(){

		//refresh category
		$.post(url+'/manage/ajax/getcategory',
		{
		   lang_id : $(this).val()
		},
		function(data){
		   $('#addcategoryToContent').html(data.result);
		},'json');

		clearTags();
		clearCategory();
		$('#error-language_id').hide();
		
		//set option for autocomplate
		changeLang();

    });
	
	var loaderHtml = '<h1 style="position:relative;top:-35px;">'+'<span style="position:relative;top:-8px;">'+'<img style="position:relative;top:7px;margin:5px" src="'+ url + '/media/images/manage/arrow-loader.gif'+'" />'+'Processing'+'</span></h1>';

    $('#form-new-storycontent').ajaxStart(function() {
		$(this).block({
			message: loaderHtml,
			css: { 
			border: 'none',
			padding: '10px', 
			backgroundColor: 'transparent',
			//border: '2px solid #2CAAFC',
			'-webkit-border-radius': '10px', 
			'-moz-border-radius': '10px', 
			color: '#fff' 
			}
		});
    });

    $('#form-new-storycontent').ajaxStop(function() {
        $(this).unblock();
    });


});


//untuk set option autocomplate
function changeLang()
{
    $("input#suggest").setOptions({
    extraParams: {
      lang_id: $('#choose-language').val()
    }
    }).flushCache();
}

function initTags()
{

	//- - - - - - - - - - - - - - tags - - - - - - - - - - - - - - - - - - - - -
	$("input#suggest").autocomplete(url+'/manage/suggest/tag/',
	{
	    extraParams: {
	      //lang_id: langId
	      lang_id: $("#choose-language").val()
	    },
	    formatItem: function(data,i,max){

		//this animation event when autocomplate sending ajax
		//$('#loading-tag').ajaxStart(function() {
		//	$(this).show();
		//});
		//$('#loading-tag').ajaxStop(function() {
		//	$(this).hide();
		//});	

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
	    }else{
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
	    }
	});
	
	// Remove tags
	$('.event').live('click', function(){
	    //dest-event-
	    //var id = ($(this).attr('id')).substr(11);
	    var id = $(this).attr('id');
	
	    arrayEvent = jQuery.grep(arrayEvent, function(value) {
		return value != id;
	    });            
	
	    $(this).hide();
	
	    //jika array 0 maka blok tag di hide
	    if(arrayEvent.length == 0 && arrayDest.length == 0 )
	    {
		$('#listTag').hide();
	    }
	});
	
	$('.dest').live('click', function(){
	    var id = $(this).attr('id');
	
	    arrayDest = jQuery.grep(arrayDest, function(value) {
		return value != id;
	    });            
	
	    $(this).hide();
	    
	    //jika array 0 maka blok tag di hide
	    if(arrayEvent.length == 0 && arrayDest.length == 0 )
	    {
		$('#listTag').hide();
	    }
	});		
}

//init save
function initSave()
{
	$('#form-new-storycontent').submit(function(){
		var language = $('#choose-language').val();
		var title = $('#title').val();
		var content = tinyMCE.get('txttiny').getContent();


		if(language == 0)
		{
			$('#error-language').show();
		}
		else
		{
			$('#error-language').hide();
		}
		if(title == "")
		{
			$('#error-title').show();
		}
		else
		{
			$('#error-title').hide();
		}
		if(content == "")
		{
			$('#error-content').show();
		}
		else
		{
			$('#error-content').hide();
		}
		
		if(language != 0 && title != "" && content != "")
		{
			//alert('ok');
			$('.error').hide();
			//return true;

			//object initiation
			article.content = {title:null, 
							content:null, 
							tagEvent:[], 
							tagDest:[],
							category:[],
							userstory_id : null,
							langId : null
							};
							
				article.content.title = title;
				article.content.content = content;
				article.content.category = arrCategory;
				article.content.tagEvent = arrayEvent;
				article.content.tagDest = arrayDest;
				article.content.userstory_id = $('#userstory-id').val();
				article.content.langId = language;
				
	
				$.ajax({
					type:'post',
					cache:false,
					type: $(this).attr('method'),
					url: $(this).attr('action'),
					data: "array=" + JSON.stringify(article),
					processData:    false,
					dataType: "json",
					success: function(data) {
						
						if(data.result)
						{
							clearForm();
							unblockModalForm();
						}
						else
						{
							alert('Error');
						}
				
					}
				});

			return false;

		}
		
		return false;
	});
}


function clearForm()
{
	//cleare field
	$('#title').val('');
	tinyMCE.get('txttiny').setContent('');
	$("select#choose-language option[value='0']").attr("selected", "selected");
	$('#userstory-id').val(0);
	$('#addcategoryToContent').html('<option value="default">Choose Category</option>');
	
	clearTags();
	clearCategory();
}

function clearCategory()
{
	//cleare array category
    if(arrCategory.length > 0)
    {
	    $('.listCategory').empty().hide();
	    arrCategory = [];
    }	
}

function clearTags()
{
	//cleare array tag
    if(arrayEvent.length > 0 || arrayDest.length > 0)
    {
		$('#listTag').empty().hide();
		arrayEvent = [];
		arrayDest = [];
    }	
}


$(document).ready(function(){
	$('#cancel').live('click',function(){
		clearForm();
		unblockModalForm();
	});
});

function customModalForm(){
    $('.black_overlay').fadeIn('fast');
    $('#forms').css({
		'position' : 'absolute',
		'z-index': '1002',
		'top' : '1px',
		'left' : '30px'
	});
    $('#forms').show();
}

function unblockModalForm()
{
    $('.black_overlay').fadeOut(800);
    $('#forms').hide();
    $('.error').hide();
}
function initCategory()
{

	
	//add category to content
	$('#addcategoryToContent').change(function(){
		var catID = $(this).val();
		var catName = $(this).text();
		
		if(catID != 'default')
		{
			if(arrCategory.length == 0)
			{
				var htmlCat = '<span class="category" title="click to remove" id="'+catID+'">'+
							  ($('#addcategoryToContent > option:selected').text())+'</span>';
				arrCategory.push(catID);
				$('.listCategory').show();	
				$('.listCategory').append(htmlCat);
				$('#error-category').hide();
			}
			else
			{
				var flag = jQuery.inArray($(this).val(),arrCategory);
				if(flag < 0)
				{
					//if value not found in the arrCategory
					arrCategory.push(catID); //push the value to the arrCategory
					var htmlCat = '<span class="category" title="click to remove" id="'+catID+'">'+
								  ($('#addcategoryToContent > option:selected').text())+'</span>';
					$('.listCategory').show();
					$('.listCategory').append(htmlCat);
					$('#error-category').hide();
				}else{
					 alert('Category already exists');
				}
			}
		}
	});
	
	//remove category content
	$(".category").live('click', function(){
		id = $(this).attr('id');
		//remove array category
		arrCategory = jQuery.grep(arrCategory, function(value) {
			 return value != id;
		});
		 $(this).hide();
		//if empty then hide the category container
		if(arrCategory.length == 0)
		{
			$('#listCat').hide();
		}
	});	
}


function tinyEdit(){
	
    tinyMCE.init({
        // General options
        mode : "textareas",
        theme : "advanced",
        plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount",
    
        // Theme options
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,image,code",
        theme_advanced_buttons3 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : false,
        dialog_type : "window",
    
        // Example content CSS (should be your site CSS)
        content_css : "css/content.css",
    
        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "lists/template_list.js",
        external_link_list_url : "lists/link_list.js",
        external_image_list_url : "lists/image_list.js",
        media_external_list_url : "lists/media_list.js"
    
    });    
}