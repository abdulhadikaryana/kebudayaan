var content = {
//    shortdes : null,
//    description: null
};
var prevLang = 0;

$(function(){
    tinyEdit();

    if(!edit)
    {
        /* Store the previous language ID */
        $('#language').click(function(){
            prevLang = $(this).val();
        });

        $('#language').change(function(){


            if(prevLang > 0)
            {
                //store the article content
                storeContent(false);
            }
            restoreContent();
        });
    }
    else
    {
        //alert(edit);
    }


});


function storeContent(useCurrentLang){

	if(useCurrentLang == false)
	{
	    languageId = prevLang;
	}
	else
	{
	    languageId = $('#language').val();
	}

    //object initialitation
    content[languageId] = {shortdes:null,description:null};

    //store content
    content[languageId].shortdes = filterChars(tinyMCE.get('short_description').getContent({format : 'text'}));
    content[languageId].description = filterChars(tinyMCE.get('description').getContent({format : 'text'}));

	console.log(content);

    tinyMCE.get('short_description').setContent('');
    tinyMCE.get('description').setContent('');
}
function restoreContent()
{
    if(content[$('#language').val()] != undefined)
    {
        currentLang = $('#language').val();
        tinyMCE.get('short_description').setContent(content[currentLang].shortdes);
        tinyMCE.get('description').setContent(content[currentLang].description);
    }
}
function filterChars(str)
{
    return str.replace('”', '&#34').replace('“', '&#34').replace('‘', '&#39').replace('’', '&#39');
}


function tinyEdit(){

    //init tinymice
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
}