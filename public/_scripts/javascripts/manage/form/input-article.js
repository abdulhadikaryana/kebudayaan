var arrayEvent = [];	//array tag event
var arrayDest = [];  	//array tag destination
var arrayArticle = [];  //array tag article
var arrCategory = []; 	//array tag category

var prevLang = 0; 		//previous language
var posting = 0;

var article = {		    //article container
    content : [],
	publishDate : null,
	contributorId : null,
	type: null
};

var cat = new category;
var tag = new tags;

var loaderHtml = '<h1>'+
			 '<span>'+
			 '<img src="'+ 
			 imgUrl + 
			 '/manage/arrow-loader.gif'+
			 '" />'+
			 'Processing'+
			 '</span></h1>';

$(function(){
	
    /* init tinyMce */
    tinyEdit();
    
    /* init save content */
    initSave();
	
    /* General Functionality */
    $('.blockUi').ajaxStart(function() {
        $('.block-border').block({
            message: loaderHtml,
            css: {
            border: 'none',
            padding: '10px',
            backgroundColor: '#fff',
            border: '2px solid #2CAAFC',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            color: '#fff'
            }
        });
    });

    $('#blockui-close').click(function() { 
        $.unblockUI(); 
        return false; 
    });     
    
    $('.blockUi').ajaxStop(function() {
        $('.block-border').unblock();
    });

    $('#boxLoading').ajaxStart(function() {
        $(this).show();
    });
    
    $('#boxLoading').ajaxStop(function() {
        $(this).hide();
    });
    
    $('#date').attr('readonly','readonly');
    $("#date").datepicker({
        dateFormat: 'yy-mm-dd',
        onSelect: function(dateText, inst) {
            $('#error-date').hide();
        }
    }); 
	
    /* reset the selected language */
    $("select#choose-language option[value='0']").attr("selected", "selected");	
    
    /* Store the previous language ID */
    $('#choose-language').click(function(){
	    prevLang = $(this).val();
    });
    
    /* construct tags object */
    tag.initBindTags();
    
    /* Bind the autocomplete user*/
    suggestUser(url);
    changeContributor(url);

    /* construct category object */
    cat.initBind();

    /* bind category select */
    $('#addcategoryToContent').click(function(){
	if($('#choose-language').val() <= 0)
	{
		$.blockUI({ message: $('#blockui-warning'), css: { width: '275px'}}); 	
	}
    });

    /* bind change language */
    $('#choose-language').change(function(){
	
	    if($('#choose-language').val() != 0)
	    {
		posting++;
	    }
	    
	    //refresh the category list
	    cat.loadCategory($('#choose-language').val());

	    //update autocomplete option
	    changeLang();

	    if(prevLang > 0)
	    {
            //store the article content
            storeContent(false);
	    }
	    
	    restoreContent();
    });
});

function restoreContent()
{
    if(article.content[$('#choose-language').val()] != undefined)
    {
	
        currentLang = $('#choose-language').val();
        $('#title').val(article.content[currentLang].title);
        tinyMCE.get('txttiny').setContent(article.content[currentLang].content);

        arrCategory = article.content[currentLang].category;
	
    }
}

function restoreCategory()
{
    if(arrCategory.length > 0)
    {
        //restoring category called after category list loading is complete
        if($('.listCategory').is(":hidden"))
        {
            $('.listCategory').show();
        }

        $.each(arrCategory, function(key, value){
            ////console.log($('#addcategoryToContent option[value="'+value+'"]').text());
            htmlCat = '<span class="category" title="click to remove" id="'+value+'">'+
                          ($('#addcategoryToContent option[value="'+value+'"]').text())+'</span>';
            $('.listCategory').append(htmlCat);
            });
    }
    else
    {
    	$('.listCategory').hide();
    }
}


function restoreTag()
{
    if(article.content[currentLang].tagEvent.length > 0 || article.content[currentLang].tagDest.length > 0
            || article.content[currentLang].tagArticle.length > 0)
    {
        currentLang = $('#choose-language').val();
        if($('#listTag').is(":hidden"))
        {
            $('#listTag').show();
        }
        //reset array event & dest
        arrayDest = [];
        arrayEvent = [];
        arrayArticle = [];
        //restore array tag event
        $.each(article.content[currentLang].tagEvent, function(key, value){
    
	    htmlCat = '<span class="event" title="click to remove" id="'+value.id+'">'+
			value.caption + '</span>';
	    
	    $('#listTag').append(htmlCat);
	    arrayEvent.push(value.id);
	    });
    
        //restore array tag dest
        $.each(article.content[currentLang].tagDest, function(key, value){
            htmlCat = '<span class="dest" title="click to remove" id="'+value.id+'">'+
                value.caption + '</span>';

            $('#listTag').append(htmlCat);
            arrayDest.push(value.id);
        });

        //restore array tag article
        $.each(article.content[currentLang].tagArticle, function(key, value){
            htmlCat = '<span class="article" title="click to remove" id="'+value.id+'">'+
                value.caption + '</span>';

            $('#listTag').append(htmlCat);
            arrayArticle.push(value.id);
        });
    }
    else
    {
	    $('#listTag').hide();
    }
}

//store content
function storeContent(useCurrent)
{
	if(useCurrent == false)
	{
	    langId = prevLang;
	}
	else
	{
	    langId = $('#choose-language').val();
	}
	
	//store the main article content
	article.posting = 2; //postingan untuk lebih dari 1 bahasa
	article.publishDate = $('#date').val();
	article.contributorId = $('#usercontribId').val();
	article.type = $('#category-content').val();

	//object initiation
	article.content[langId] = {title:null, 
				    content:null, 
				    tagEvent:[], 
				    tagDest:[],
				    tagArticle:[],
				    category:[]};

    //store title and content
    article.content[langId].title = filterChars($('#title').val());
    
    //article.content[langId].title.replace('‘', '&#39');
    //article.content[langId].title.replace('’', '&#39');
    //article.content[langId].title.replace('“', '&#34');
    //article.content[langId].title.replace('”', '&#34');


    article.content[langId].langId = $('#choose-language').val();

    //store content and remove left and right quote
    article.content[langId].content = filterChars(tinyMCE.get('txttiny').getContent({format : 'text'}));

    //article.content[langId].content.replace('‘', '&#39');
    //article.content[langId].content.replace('’', '&#39');
    //article.content[langId].content.replace('“', '&#34');
    //article.content[langId].content.replace('”', '&#34');


	//store category
	article.content[langId].category = arrCategory;

	//store event tags
	if(arrayEvent.length > 0)
	{
	    tempArr = [];
	    $.each(arrayEvent, function(key, value){
		    tempData = {
			    id : value,
			    caption : $('#'+value).text()
		    };
		    tempArr.push(tempData);
	    });	

	    article.content[langId].tagEvent = tempArr;
	}

	//store destination tags
	if(arrayDest.length > 0)
	{
	    tempArr = [];
	    $.each(arrayDest, function(key, value){
		    tempData = {
			    id : value,
			    caption : $('#'+value).text()
		    };
		    tempArr.push(tempData);
	    });	

	    ////store array tag dest
	    article.content[prevLang].tagDest = tempArr;
	}


	//store article tags
	if(arrayArticle.length > 0)
	{
	    tempArr = [];
	    $.each(arrayArticle, function(key, value){
		    tempData = {
			    id : value,
			    caption : $('#'+value).text()
		    };
		    tempArr.push(tempData);
	    });	

	    ////store array tag dest
	    article.content[prevLang].tagArticle = tempArr;
	}
 	//clearing array
	clearCategory();
	clearTags();
	$('#title').val('');
	$('#suggest').val('');
	tinyMCE.get('txttiny').setContent('');
}

/*
* save content
*/
function initSave()
{
    $('#formUserStory').submit(function(){
        $('.error').hide();
	    if(posting == 0)
	    {
            $('html, body').animate({scrollTop:120}, 'slow');
            $('#error-date').show();
            $('#error-usercontrib').show();
            return false;
	    }
	    else
	    {
            if(($('#date').val()) == "")
            {
                $('#error-date').show();
                $('html, body').animate({scrollTop:120}, 'slow');
            }
            else
            {
                $('#error-dates').hide();
            }

            if(($('#suggest-user').val()) == "")
            {
                $('#error-usercontrib').show();
                $('html, body').animate({scrollTop:120}, 'slow');
            }
            else
            {
                $('#error-usercontrib').hide();
            }

            if(($('#date').val()) != "" && ($('#suggest-user').val()) != "")
            {
                if(posting == 1)
                {
                    //store the main article content
                    article.posting = 1;
                    article.publishDate = $('#date').val();
                    article.contributorId = $('#usercontribId').val();
                    article.langId = $('#choose-language').val();
                    article.type = $('#category-content').val();
                    article.content = {title:null,
                                       content:null,
                                       tagEvent:[],
                                       tagDest:[],
                                       tagArticle:[],
                                       category:[]};

                    //store title and content
                    article.content.title =  filterChars($('#title').val());

                    //article.content.title.replace('‘', '&#39');
                    //article.content.title.replace('’', '&#39');
                    //article.content.title.replace('“', '&#34');
                    //article.content.title.replace('”', '&#34');

                    article.content.content = filterChars(tinyMCE.get('txttiny').getContent({format : 'text'}));

                    //article.content.content.replace('‘', '&#39');
                    //article.content.content.replace('’', '&#39');
                    //article.content.content.replace('“', '&#34');
                    //article.content.content.replace('”', '&#34');

                    //store category
                    article.content.category = arrCategory;

                    //store event tags
                    if(arrayEvent.length > 0)
                    {
                        tempArr = [];
                        $.each(arrayEvent, function(key, value){
                            tempData = {
                                id : value,
                                caption : $('#'+value).text()
                            };
                            tempArr.push(tempData);
                        });

                        article.content.tagEvent = tempArr;
                    }

                    //store event destinasi
                    if(arrayDest.length > 0)
                    {
                        tempArr = [];
                        $.each(arrayDest, function(key, value){
                            tempData = {
                                id : value,
                                caption : $('#'+value).text()
                            };
                            tempArr.push(tempData);
                        });

                        //store array tag dest
                        article.content.tagDest = tempArr;
                    }

                    //store tags article
                    if(arrayArticle.length > 0)
                    {
                        tempArr = [];
                        $.each(arrayArticle, function(key, value){
                            tempData = {
                                id : value,
                                caption : $('#'+value).text()
                            };
                            tempArr.push(tempData);
                        });

                        //store array tag dest
                        article.content.tagArticle = tempArr;
                    }

                    $.ajax({
                        cache:false,
                        type: $(this).attr('method'),
                        url: $(this).attr('action'),
                        data: {posting : posting, array : JSON.stringify(article)},
                        dataType: "json",
                        success: function(data)
                        {
                            if(data != null)
                            {
                                if(data.status)
                                {
                                    clearForm();
                                    $('#notifikasi').html(data.result);
                                    $('.success').show();
                                }
                                else
                                {
                                    $('.success').hide();
                                    $('.error-el').show();
                                    $('#notifikasi2').html(data.result);
									
                                }
                            }
                        }
                    });
                    return false;
                }
                else
                {
                    storeContent(true);
                    $.ajax({
                        cache:false,
                        type: $(this).attr('method'),
                        url: $(this).attr('action'),
                        data: {"posting" : posting, "array" : JSON.stringify(article)},
                        dataType: "json",
                        success: function(data) {
                            if(data.status)
                            {
                                clearForm();
                                $('#notifikasi').html(data.result);
                                $('.success').show();
                            }
                            else
                            {
                                $('.success').hide();
                            }
                        }
                    });
                    return false;
                }
		    }
            else{

            }
	    }
	    return false;
    });
}

function filterChars(str)
{
    return str.replace('”', '&#34').replace('“', '&#34').replace('‘', '&#39').replace('’', '&#39');
}

function clearForm()
{
   
   setTimeout(reload,3000);
   
    clearTags();
    clearCategory();
    clearArticle();

    $('#date').val('');
    $('select[name="lang_id"] > option[value="0"]').attr('selected','selected');
    $('#addcategoryToContent').html('<option value="0">Choose Category</option>');
    $('#listCat').hide();
    $('#listTag').hide();
    $('#title').val('');
    tinyMCE.get('txttiny').setContent('');
     
    $('#suggest-user').attr('value','');
    $('#change-contributor').hide();
    $('#suggest-user').removeAttr('disabled');
    $('#usercontribId').attr('value',0);
}

function clearArticle()
{
    article = {
	content : [],
	    publishDate : null,
	    contributorId : null,
	    type: null
    };    
}

function reload()
{
    window.location.reload();
}
function clearCategory()
{
    if(arrCategory.length > 0)
    {
	    $('.listCategory').empty().hide();
	    arrCategory = [];
    }
}

function clearTags()
{
    if(arrayEvent.length > 0 || arrayDest.length > 0 || arrayArticle.length > 0)
    {
	$('#listTag').empty().hide();
	arrayEvent = [];
	arrayDest = [];
	arrayArticle = [];
    }
}

function tinyEdit(){
	
    tinyMCE.init({
        // General options
        mode : "textareas",
        theme : "advanced",
		relative_urls : false,
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount",
    
        // Theme options
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,image,code",
        theme_advanced_buttons3 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : false,
        dialog_type : "modal"
    });    
}