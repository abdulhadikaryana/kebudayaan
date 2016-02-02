
//query category content berdasarkan bahasa
function getCategory(url,param){
    
    if(param)
    {
        $('#error-language').hide();

        $.post(url+'/manage/ajax/getcategory',
        {
            lang_id : param
        },
        function(data){
            //console.log(data.result);
            
            $('#addcategoryToContent').html(data.result);
            

        },'json');        
    }
    else
    {
        
    }
    $('#choose-language').change(function(){
        var lang_id = $(this).val();
        
        $('#error-language').hide();

        $.post(url+'/manage/ajax/getcategory',
        {
            lang_id : lang_id
        },
        function(data){
//            console.log(data.result);
            
            $('#addcategoryToContent').html(data.result);
            

        },'json');
    })
}


/*
    fungsi untuk add category baru ek dalam database
*/

function addNewCategory(url){
     //clearFormModal();

    $(document).keydown(function(e) {
        
        //console.log(e.which);
        if (e.which == 27 ) //esc key
        {
            unblockModalForm();
        } 
    });

    $('#add-new-category').click(function() {
        $('.error-cat').hide();
        customModalForm();
    });
    $('#cancel-add-category').click(function() {
        unblockModalForm();
    });
    
    //save handler
    $('#FormNewCategory').submit(function(){
        
        var title = $('input[name="titleCategory"]').val();
        var lang = $('select[name="lang_category"]').val();
        var content = tinyMCE.get('txtTinyCategory').getContent();
        
        if(title == "" && lang == 'default' && content == "")
        {
            $('.error-cat').fadeIn();
        }
        else if(title != "" && lang != 'default' && content != "")
        {
            $('.error-cat').hide();

            var params = {
                    title:$('input[name="titleCategory"]').val(),
                    content: tinyMCE.get('txtTinyCategory').getContent(),
                    lang_id : $('select[name="lang_category"]').val()
                };
            var str = jQuery.param(params);

            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: str,
                dataType : 'json',                
                success: function(data){

                    $.post(url+'/manage/ajax/getcategory',
                    {
                        lang_id : $('select[name="lang_category"]').val()
                    },
                    function(data){
                        $('#addcategoryToContent').html(data.result);
                        //$('#language_id').attr('value',lang_id);
                    },'json');

                    //$('select[name="addcategoryToContent"]').append(data.result);
                    unblockModalForm();
                    clearFormModal();
            
                }
            }); 
        }

        if(title == "")
        {
            $('#error-language-category').fadeIn();
        }
        else
        {
            $('#error-language-category').hide();
        }

        if(lang == 'default')
        {
            $('#error-language-category').fadeIn();
        }
        else
        {
            $('#error-language-category').hide();
        }

        if(content == "")
        {
            $('#error-content-category').fadeIn();
        }
        else
        {
            $('#error-content-category').hide();
        }
        return false;
    });  

}
function clearFormModal(){
    $('input[name="titleCategory"]').val('');
    $('#dafault-cat').attr('selected','selected');
    tinyMCE.getInstanceById('txtTinyCategory').setContent(''); //cleare textarea tinyMICE
}
function customModalForm(){
    
    $('.black_overlay').fadeIn('fast');
    $('.customs-content').show();
}
function unblockModalForm()
{

    $('.black_overlay').fadeOut(800);
    $('.customs-content').hide();
    $('.error').hide();
}

function modalUI(element){

        $.blockUI({ 
            message: $(element), 
            baseZ: 1000,
            showOverlay: true, 
            centerY: false, 
            css: {
                width: '500px', 
                height: 'auto',
                top : '200px',
                border: 'none', 
                padding: '60px', 
                backgroundColor: '#000', 
                '-webkit-border-radius': '5px', 
                '-moz-border-radius': '5px',
                'border-radius' : '5px',
                opacity: .6, 
                color: '#fff'
            } 
        }); 
}

/*
    add tags function
    
    digunakan untuk mendapatkan auto sugest yang akan digunakan sebagai tag
    
*/
function JSuggest(baseUrl){
    $('#suggest').focus(function(){
        $(this).val('');
    });

    $("input#suggest").autocomplete(baseUrl+'/manage/suggest/tag',
    {
        extraParams: {
          lang_id: $('#choose-language').val()
        },
        formatItem: function(data,i,max){
            var str = '<div class="search_content" style="float:left;">';
            str += data;
            str += '</div>';
            return str;
        }        
    
    }).result(function(event, data, formatted) {
        $(this).val('');
        
        //add element array event 
        if(($(data[0]).attr('class')) == 'event'){

            var id = $(data[0]).attr('id'); //id event

            var flag = jQuery.inArray(id,arrayEvent);
            if(flag < 0)
            {
                var object_type = 'event';

                //add element
                arrayEvent.push(id);
                statusTags = 1;

                //save tag to database
                $.post(baseUrl+'/manage/usergeneratedcontent/addtag',
                {
                    objectId : id,
                    objectType : object_type,
                    storyId : parseInt($('#userStoryId').text()),
                    tagText : formatted,
                    lang_id : $('#choose-language').val()
                },
                function(data){

                    $('#listTag').show();
                    $('#listTag').append(data.result);
                    
                    removeTag(baseUrl);

                    $('#error-tags').hide();
                    
                    //cek status array tags
                    if(arrayEvent.length == 0 && arrayDest.length == 0 && arrayArticle.length == 0)
                    {
                        statusTags = 0;
                        $('#listTag').hide();
                    }
                    else
                    {
                        statusTags = 1;
                        $('#listTag').show();
                    }
                    //console.log(statusTags);

                },'json');


            }else{
                 alert('That tag already inserted');
            }
        
        }
        
        //add element array destination
        if(($(data[0]).attr('class')) == 'dest')
        {
            var id = $(data[0]).attr('id'); //id destination
        
            var flag = jQuery.inArray(id,arrayDest);
            if(flag < 0)
            {
                var object_type = 'destination';
                
                //add element array destination
                arrayDest.push(id);
                statusTags = 1;
        
                //save tag to database
                $.post(baseUrl+'/manage/usergeneratedcontent/addtag',
                {
                    objectId : id,
                    objectType : object_type,
                    storyId : parseInt($('#userStoryId').text()),
                    tagText : formatted,
                    lang_id : $('#choose-language').val()
                },
                function(data){
                    $('#listTag').show();
                    $('#listTag').append(data.result);
                    removeTag(baseUrl);
        
                    $('#error-tags').hide();
        
                    //cek status array tags
                    if(arrayEvent.length == 0 && arrayDest.length == 0 && arrayArticle.length == 0)
                    {
                        //jika arrat tags kosong, maka list tag di hide
                        statusTags = 0;
                        $('#listTag').hide();
                    }
                    else
                    {
                        statusTags = 1;
                        $('#listTag').show();
                    }
        
                },'json');
        
            }else{
                 alert('That tag already inserted');
            }
        }

        //add element array article
        if(($(data[0]).attr('class')) == 'article')
        {
            var id = $(data[0]).attr('id'); //id article
        
            var flag = jQuery.inArray(id,arrayArticle);
            if(flag < 0)
            {
                var object_type = 'article';
                
                //add element array destination
                arrayArticle.push(id);
                statusTags = 1;
        
                //save tag to database
                $.post(baseUrl+'/manage/usergeneratedcontent/addtag',
                {
                    objectId : id,
                    objectType : object_type,
                    storyId : parseInt($('#userStoryId').text()),
                    tagText : formatted,
                    lang_id : $('#choose-language').val()
                },
                function(data){
                    $('#listTag').show();
                    $('#listTag').append(data.result);
                    removeTag(baseUrl);
        
                    $('#error-tags').hide();
        
                    //cek status array tags
                    if(arrayEvent.length == 0 && arrayDest.length == 0 && arrayArticle.length == 0)
                    {
                        //jika arrat tags kosong, maka list tag di hide
                        statusTags = 0;
                        $('#listTag').hide();
                    }
                    else
                    {
                        statusTags = 1;
                        $('#listTag').show();
                    }
        
                },'json');
        
            }else{
                 alert('That tag already inserted');
            }
        }    

    
    });


    /*
        Fungsi
        auto suggest untuk user ontributor
    */
    $("input#suggest-user").autocomplete(baseUrl+'/manage/suggest/usercontributor',
    {
        formatItem: function(data,i,max){
            var str = '<div class="search_content" style="float:left;">';
            str += data;
            str += '</div>';
            return str;
        }
    }).result(function(event, data, formatted) {
        
        var user_id = $(data[0]).attr('id');
        if(user_id > 0)
        {
            $('#usercontribId').val(user_id);
            $(this).val($(formatted).text());
            //console.log(user_id);
            
            $('#error-usercontrib').hide();
            
            $('#suggest-user').attr('disabled','disabled');
        }
        else
        {
            $('#usercontribId').val('');
            $('#suggest-user').attr('disabled','disabled');
            $(this).val($(formatted).text());
        }
    });    
   
}
/* end add tags function*/



/*
    remove tags function
    digunakan untuk menghapus tag dari list tag content  yang sudah ada    
*/
function removeTag(baseUrl){
    //remove element array event
    $('.event').click(function(){
        var id = $(this).attr('id');
        var tag_id = ($(this).attr('class')).substr(6);
        
        //remove array yg sama dengan id tag
        arrayEvent = jQuery.grep(arrayEvent, function(value) {
            return value != id;
        });
        
         $.post(baseUrl+'/manage/usergeneratedcontent/removetag',
         {
             tagID : tag_id
         },
         function(data){

            //cek status array tags
            if(arrayEvent.length == 0 && arrayDest.length == 0 && arrayArticle.length == 0)
            {
                statusTags = 0;
                $('#listTag').hide();
            }
            else
            {
                statusTags = 1;
                $('#listTag').show();
            }

         },'json'); 

        $(this).hide();

    });
    
    //remove element array destination
    $('.dest').click(function(){
        var id = $(this).attr('id');
        var tag_id = ($(this).attr('class')).substr(5);

        //remove array yg sama dengan id tag
        arrayDest = jQuery.grep(arrayDest, function(value) {
            return value != id;
        });
        
         $.post(baseUrl+'/manage/usergeneratedcontent/removetag',
         {
             tagID : tag_id
         },
         function(data){


            //cek status array tags
            if(arrayEvent.length == 0 && arrayDest.length == 0 && arrayArticle.length == 0)
            {
                statusTags = 0;
                $('#listTag').hide();
            }
            else
            {
                statusTags = 1;
                $('#listTag').show();
            }

         },'json'); 

        $(this).hide();
    
    });


    //remove element array article
    $('.article').click(function(){
        var id = $(this).attr('id');
        var tag_id = ($(this).attr('class')).substr(8);

        //remove array yg sama dengan id tag
        arrayArticle = jQuery.grep(arrayArticle, function(value) {
            return value != id;
        });
        
         $.post(baseUrl+'/manage/usergeneratedcontent/removetag',
         {
             tagID : tag_id
         },
         function(data){

            //cek status array tags
            if(arrayEvent.length == 0 && arrayDest.length == 0 && arrayArticle.length == 0)
            {
                statusTags = 0;
                $('#listTag').hide();
            }
            else
            {
                statusTags = 1;
                $('#listTag').show();
            }


         },'json'); 

        $(this).hide();
    
    });


   
}
/* end remove tags function */



/*
    add category content function
    digunakan untuk menambahkan cateory content
*/

function addCategoryContent(baseUrl){
    
    $('option[value="default"]').attr('selected','selected'); //default selected

    $('#addcategoryToContent').change(function(){
        var catID = $(this).val();
        var catName = $('#addcategoryToContent > option:selected').text();
        
        if(arrayCategory.length == 0)
        {
            //save tag
            $.post(baseUrl+'/manage/usergeneratedcontent/addcategory',
            {
                user_categoryId : catID,
                user_storyId : parseInt($('#userStoryId').text()),
                lang_id : $('#choose-language').val()
            },
            function(data){
                

                //add element array category
                arrayCategory.push(catID);

                var htmlCat = '<span class="category '+data.id+'" title="click to remove" id="'+catID+'">'+catName+'</span>';
                
                $('#listCat').show();
                $('.listCategory').append(htmlCat);
                removeCategory(baseUrl);
                
                $('#error-category').hide();

                //cek array category
                if(arrayCategory.length == 0)
                {
                    statusCategory = 0;
                    $('#listCat').hide();
                }
                else
                {
                    statusCategory = 1;
                }

            },'json');
        }
        else
        {
            var flag = jQuery.inArray($(this).val(),arrayCategory);
            if(flag < 0)
            {
   
                //save category
                $.post(baseUrl+'/manage/usergeneratedcontent/addcategory',
                {
                    user_categoryId : catID,
                    user_storyId : parseInt($('#userStoryId').text()),
                    lang_id : $('#choose-language').val()
                },
                function(data){
                    
                    //add element array category
                    arrayCategory.push(catID);

                    var htmlCat = '<span class="category '+data.id+'" title="click to remove" id="'+catID+'">'+catName+'</span>';
                    
                    $('#listCat').show();
                    $('.listCategory').append(htmlCat);
                    removeCategory(baseUrl);

                    //cek array category
                    if(arrayCategory.length == 0)
                    {
                        statusCategory = 0;
                        $('#listCat').hide();
                    }
                    else
                    {
                        statusCategory = 1;
                    }

                },'json');


            }else{
                 alert('That category already inserted');
            }
        }

    });
}

function removeCategory(baseUrl){
    $('.category').click(function(){
        var cat_id = $(this).attr('id'); //id category
        var related_id = ($(this).attr('class')).substr(9); //id relasi ke content

            //remove category 
            $.post(baseUrl+'/manage/usergeneratedcontent/removecategory',
            {
                related_id : related_id
            },
            function(data){
                //remove array category
                arrayCategory = jQuery.grep(arrayCategory, function(value) {
                    return value != cat_id;
                });        

                //cek array category
                if(arrayCategory.length == 0)
                {
                    statusCategory = 0;
                    $('#listCat').hide();
                }
                else
                {
                    statusCategory = 1;
                }
            
            },'json');
        $(this).remove();

    });
}

/* save handler */
function saveHandler(){
    $('#formEditUserStoryContent').submit(function(){

        var date = $('input[name="date"]').val();
        var contributor = $('input[name="usercontrib"]').val();
        var language = $('select[name="lang_id"]').val();
        var title = $('input[name="title"]').val();
        var content = tinyMCE.get('txttiny').getContent();
        
        //validasi form
        //if(language == 0 && date == "" && contributor == "" && statusCategory == 0 && statusTags == 0 && title == "" && content == "")
        if(language == 0 && date == "" && contributor == "" && title == "" && content == "")
        {
            $('.error').fadeIn();
            
            return false;
        }
        else if(language != 0 && date != "" && contributor != "" && title != "" && content != "")
        //else if(language != 0 && date != "" && contributor != "" && statusCategory != 0 && statusTags != 0 && title != "" && content != "")
        {
            $('.error').hide()
        
            //var params = {
            //        Title:$('input[name="title"]').val(),
            //        Date:$('input[name="date"]').val(),
            //        Content:tinyMCE.get('txttiny').getContent(),
            //        LangId:$('select[name="lang_id"]').val(),
            //        oriLang:originalLang_content,
            //        contributor_id:$('input[name="usercontribId"]').val(),
            //        userStoryId : parseInt($('#userStoryId').text()),
            //        userStoryContentId : parseInt($('#userStoryContentId').text())
            //    };
            //var str = jQuery.param(params);
            //
            //$.ajax({
            //    type: $(this).attr('method'),
            //    url: $(this).attr('action'),
            //    data: str,
            //    dataType : 'json',
            //    success: function(data){
            //        
            //        //if(data.result)
            //        //{
            //            $('.success').show();
            //            setTimeout(redirect(data.url),50000);
            //        //}
            //        
            //    }
            //});
            
            return true;

        }
        
        //validasi field
        if(language != 0)
        {
            //$('.error').fadeIn();   
            $('#error-language').hide();
        }
        else{
            $('#error-language').fadeIn();
            return false; 
        }
        
        if(date != "")
        {
            $('#error-dates').hide();   
        }
        else
        {
            $('#error-dates').fadeIn();   
            return false; 
        }
        
        
        if(contributor != "")
        {
            $('#error-usercontrib').hide();   
        }
        else
        {
            $('#error-usercontrib').fadeIn();   
            return false; 
        }
        
        if(title != "")
        {
            $('#error-title').hide();   
        }
        else
        {
            $('#error-title').fadeIn();   
            return false; 
        }        
        
        if(content != "")
        {
            $('#error-content').hide();   
        }
        else
        {
            $('#error-content').fadeIn();   
            return false; 
        }
    
    });
}

function redirect(redirectUrl)
{
    window.location = redirectUrl;
}

/* tinyMice function */

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
        dialog_type : "modal",
        relative_urls : false
});