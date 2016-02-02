/**
 * javascript for adding entity for manage/views/scripts/mice/add.phtml
 */
var step = 1;
var description = [];
var prevLang = 1;
var formOption = {
	beforeSubmit : prepareData,
	success : formResponse,
    dataType: 'json',
    data : {
		content : '',
		type : 0
	}
};

var loaderHtml = '<h1><span><img src="' + rootUrl
		+ '/media/images/manage/arrow-loader.gif" />Processing'
		+ '</span></h1>';

var blockOption = {
	message : loaderHtml,
	css : {
		border : 'none',
		padding : '10px',
		backgroundColor : '#fff',
		border : '2px solid #2CAAFC',
		'-webkit-border-radius' : '10px',
		'-moz-border-radius' : '10px',
		color : '#fff'
	}
}

function formResponse(data)
{
    if(data[0].success == 1)
    {
        $('#step-2').unblock().hide();
        $('#step-3').show();
        $( "#notification" ).tmpl(data[0].message).prependTo( "#step-3" );
        $('html, body').animate({scrollTop:0});
    }
    else
    {
        $('#error_notification').show();
        $( "#notification" ).tmpl(data[0].message).
        prependTo( "#error_notification" );
    }
}

/**
 * adding the descriptiondata to the serialize array
 */
function prepareData(arr, formObj, options){
	//store current displayed description
	if(tinyMCE.activeEditor != null)
	{
		description[$('#language').val()] = tinyMCE.activeEditor.getContent({ format : 'raw' });
	}
	//store the description into the arr
    options.data.content = JSON.stringify(description);

    //block the form while the form is submitting data
	$('#step-2').block(blockOption);
	$('html, body').animate({scrollTop:$('#step-2').height()/2});
}