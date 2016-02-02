var editTpl = '<a id="edit-area" class="with-tip edit-field" title="Click to Change Location">'+
			  '<img alt="change" src="'+rootUrl+'/media/images/manage/icons/fugue/pencil.png">'+
			  '</a>';
$(function(){

    //bind back to list form
    $('#back_to_list').click(function(){
       window.location = rootUrl + '/manage/mice/';
    });

	//bind the autocomplete function and the reset button
    var areaName = $('#area_name');
	$('#area_name').autocomplete(rootUrl+'/manage/mice/areafeed', {
		width : 300,
		max : 1000,
		autofill : true,
		multiple : true,
		minChars : 1
	})
	.result(function(event, data, formatted){
		$('#area_id').val(data[1]);
		areaName.attr('disabled', 'disabled');
		areaName.parent().append(editTpl);
		$('#error-area_id').hide().empty();
		$('#edit-area').tip({ reverseHover : true }).click(function(){
			$('#area_id').val('');
			$('#area_name').val('').removeAttr('disabled').focus();
			$(this).remove();
		});
	});

	//store the previous language value
	$('#language').click(function(){
		prevLang = $(this).val();
	});

	//store the description and clear the tinymce
	$('#language').change(function(){
        description[prevLang] = tinyMCE.get('description').getContent({ format : 'raw' });
        if($('#language').val() in description)
        {
            tinyMCE.get('description').setContent(description[$('#language').val()], { format : 'raw' });
        }
        else
        {
            tinyMCE.get('description').setContent('', {format:'raw'});
        }
	});

	//validating the form, callback - send the form if theres no error
	$("#mice-entity").validate({
		submitHandler: function(){
			$('#mice-entity').ajaxSubmit(formOption);
			return false;
		},
		invalidHandler: function(form, validator){
			//show the error container for each error element
			$.each(validator.invalid, function(index, value){
				$('#error-'+index).show();
			});
		},
		wrapper: 'li',
		errorPlacement: function(error, element) {
			error.html(error.children('label').html());
			elementId = element.attr('id');
			$('#error-'+elementId).html(error);
		},
		rules: {
			name : "required",
			address: "required",
			area_id : "required",
            website : "url"
		},
		messages: {
			name : "The entity name is <strong>required</strong>, Please enter the entity name!",
			address : "The entity address is <strong>required</strong>, Please enter the entity address!",
			area_id : "The entity Location is <strong>required</strong>! Please Use <strong>the autocomplete feature</strong> to set its value",
            website : "Please enter a <strong>valid URL</strong>!"
		}
	});


	//bind the area name input element on blur to validate tha area id input (the real one)
	$('#area_name').blur(function(){
		if($('#mice-entity').validate().element($('#area_id')) == false)
		{
			$('#error-area_id').show();
		}
		else
		{
			$('#error-area_id').hide().empty();
		}
	});

	//reset the error container and validate form input on blur
	$('#mice-entity :input').blur(function(){
		inputId = $(this).attr('id');
		if($('#mice-entity').validate().element($(this)) == false)
		{
			$('#error-'+inputId).show();
		}
		else
		{
			$('#error-'+inputId).hide().empty();
		}
	});
});