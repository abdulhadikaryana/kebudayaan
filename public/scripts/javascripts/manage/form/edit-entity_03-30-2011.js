var description = [];
var loaderHtml = '<span style="color:#2CAAFC; font-weight: bold;"><img src="' + rootUrl
		+ '/media/images/manage/arrow-loader.gif" />Processing'
		+ '</span>';

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

var formOption = {
	beforeSubmit : prepareData,
	success : formResponse,
    dataType: 'json',
    data : {
		content : '',
		type : 0,
        entity_id : entityId
    }
};

function formResponse(data)
{
    if(data.message.length <= 0)
    {
        $('#main_block').hide();
        $('#notification_block').show();
        $('html, body').scrollTop(0);
    }
}

/**
 * adding the descriptiondata to the serialize array
 */
function prepareData(arr, formObj, options)
{
	//store current displayed description
	if(tinyMCE.activeEditor != null)
	{
		description[$('#language').val()] = tinyMCE.activeEditor.getContent({ format : 'raw' });
	}
	//store the description into the arr
    options.data.content = JSON.stringify(description);
    //get the post type
    options.data.type = JSON.stringify($('#post_type').val());
}

$(function(){

    //disable the form
    $('#mice-entity').block(blockOption);

    //get the description
    $.ajax({
        url : rootUrl + '/manage/mice/descriptionfeed/id/' + entityId,
        type : 'post',
        dataType: 'json',
        success: function(data){
            $('#mice-entity').unblock();
            //set image
            if('image' in data)
            {
                $('#image').parent().prepend('<span class="w100" style="float:left;" ><img style="border: 1px solid #cccccc;" src="'+ imageUrl + data.image +'" /></span>');
            }
            if('description' in data)
            {
                //set description
                $.each(data.description, function(key, value){
                    description[value.language_id] = tinyMCE.DOM.decode(value.value);
                });

                if(description[$('#language').val()] != undefined)
                {
                    $('#description').val(description[$('#language').val()]);
                }
            }

            if('area_id' in data)
            {
                //set area name
                $('#area_name').val(data.area_id).attr('disabled', 'disabled').parent().append(editTpl);
                $('#edit-area').tip({ reverseHover : true }).click(function(){
                    $('#area_id').val('');
                    $('#area_name').val('').removeAttr('disabled').focus();
                    $(this).remove();
                });
            }
        },
        error: function(a, b, c)
        {
            alert("error message:" + c +' -  error occured! Please print screen or copy the error message and send it to the developer');
        }
    });

});