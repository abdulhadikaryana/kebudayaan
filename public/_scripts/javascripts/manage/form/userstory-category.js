//OBJECT Category
function category()
{
	this.initBind = function()
	{
		self = this;
		this.bindAddCategory();
		this.bindRemoveCategory();
		this.bindNewCategory();
	}
	
	this.loadCategory = function(langId)
	{
		if(langId > 0)
		{
	        $.post(url+'/manage/ajax/getcategory',
	        {
	            lang_id : langId
	        },
	        function(data){
	            $('#addcategoryToContent').html(data.result);
	            $('#language_id').attr('value', langId);
				
				//if article of that language is defined then load the category
				if(article.content[$('#choose-language').val()] != undefined)
				{
					//restore previous category
					restoreCategory();

					restoreTag();
				}
			
	        },'json');
		}
		else
		{
			html = '<option selected="selected" value="0">Choose language</option>';
			$('#addcategoryToContent').html(html);
		}
	}
	
	this.customModalForm = function()
	{
	    $('.black_overlay').fadeIn('fast');
	    $('.customs-content').show();
	}
	
	this.unblockModalForm = function()
	{
	    $('.black_overlay').fadeOut(800);
	    $('.customs-content').hide();
	    $('.error').hide();
	}
	
	this.bindAddCategory = function(){
		
	    $('option[value="default"]').attr('selected','selected');
	
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
	}
	
	this.bindRemoveCategory  = function()
	{
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
	

	this.bindNewCategory = function()
	{	
	    $(document).keydown(function(e) {
	        if (e.which == 27 ) //esc key
	        {
	            self.unblockModalForm();
	        } 
	    });
	
	    $('#add-new-category').click(function() {
	    	
			if($('#choose-language').val() > 0)
	    	{
		        $('.error-cat').hide();
		        self.customModalForm();
				tinyMCE.getInstanceById('txtTinyCategory').setContent('');
	    	}
	    	else
	    	{
				$.blockUI({ message: $('#blockui-warning'), css: { width: '275px'}}); 	
	    	}
	    
		});
		
	    $('#cancel-add-category').click(function() {
	        self.unblockModalForm();
	    });

	    //save handler
	    $('#FormNewCategory').submit(function(){
	
	        if(($('input[name="titleCategory"]').val()) < 1)
	        {
	            $('#error-title-category').fadeIn();
	            //alert('Title required');
	            $('input[name="titleCategory"]').focus();
	        
	        }
	        else if(($('select[name="lang_category"]').val()) == 'default')
	        {
	            $('#error-language-category').fadeIn();
	
	            $('select[name="lang_id"]').focus();
	        }
	        else if((tinyMCE.get('txtTinyCategory').getContent()) < 1)
	        {
	            $('#error-content-category').fadeIn();
	            //alert('Content required');
	            $('#txtTinyCategory').focus();
	        }
	        else
	        {
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


	                    //refresh category
		                $.post(url+'/manage/ajax/getcategory',
		                {
		                    //lang_id : $('#language_id').val()
		                    lang_id : $('select[name="lang_category"]').val()
		                },
		                function(data){
		                    $('#addcategoryToContent').html(data.result);
		                    //$('#language_id').attr('value',lang_id);
		                },'json');            
	                    
	                    //$('select[name="addcategoryToContent"]').append(data.result);
	                    
	                    self.unblockModalForm();
	
	                    //cleare form
	                    $('input[name="titleCategory"]').val('');
	                    tinyMCE.getInstanceById('txtTinyCategory').setContent(''); //cleare textarea tinyMICE
	                    $('option[value="default"]').attr('selected','selected');
	                }
	            }); 
	        }
	        return false;
	    });
	}
}
//END of OBJECT category