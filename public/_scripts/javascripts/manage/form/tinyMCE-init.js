/**
 * Initiation tinyMCE for Textarea with class name "tinymce" 
 */

/*tinyMCE part */
$(function(){
    tinyMCE.init({
        // General options
//        mode : "textareas",
        theme : "advanced",
        mode : "specific_textareas",
        editor_selector : "description",
        languages : 'en',
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
});


//tinyMCE_GZ.init({
//		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount",
//        themes : "advanced",
//        languages : 'en',
//        disk_cache : true,
//        debug : false
//});
//
//
//tinyMCE.init({
//    mode : "specific_textareas",
//    editor_selector : "tinymce",
//    languages : 'en',
//    theme : "advanced",
//    plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount",
//    theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull",
//    theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,image,code",
//    theme_advanced_buttons3 : "",
//    theme_advanced_toolbar_location : "top",
//    theme_advanced_toolbar_align : "left",
//    theme_advanced_statusbar_location : "bottom",
//    theme_advanced_resizing : false,
//    dialog_type : "modal",
//    relative_urls : false
//});
