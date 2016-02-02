(function($){
	"use strict";
	
	$(document).ready(function($){
		
		// Set Title for Category Background from selected category - OT 
		$("[id^='setting_orn_category_background_title_']").hide();
		$("select[id^='orn_category_background_orn_cat_bg_select_']").change(function() {
			var $this = $(this), 
			idNum = $this.attr("id").split("_").pop();
			$("input[id='orn_category_background_title_"+idNum+"']").val($this.find("option:selected").text());
		});
		$('#setting_orn_category_background .option-tree-list-item-add').click(function(){
			setTimeout(function() {
				$("[id^='setting_orn_category_background_title_']").hide();
				$("select[id^='orn_category_background_orn_cat_bg_select_']").change(function() {
		   			var $this = $(this), 
					idNum = $this.attr("id").split("_").pop();
		   			$("input[id='orn_category_background_title_"+idNum+"']").val($this.find("option:selected").text());
				});
			}, 3000);

		});
		
		// Set Title for Custom Category Sidebar from Selected Category - OT 
		$("[id^='setting_orn_categorysidebars_title_']").hide();
		$("select[id^='orn_categorysidebars_orn_categorysidebars_category_']").change(function() {
			var $this = $(this), 
			idNum = $this.attr("id").split("_").pop();
			$("input[id='orn_categorysidebars_title_"+idNum+"']").val($this.find("option:selected").text());
		});
		$('#setting_orn_categorysidebars .option-tree-list-item-add').click(function(){
			setTimeout(function() {
				$("[id^='setting_orn_categorysidebars_title_']").hide();
				$("select[id^='orn_categorysidebars_orn_categorysidebars_category_']").change(function() {
		   			var $this = $(this), 
					idNum = $this.attr("id").split("_").pop();
		   			$("input[id='orn_categorysidebars_title_"+idNum+"']").val($this.find("option:selected").text());
				});
			}, 3000);

		});

		// Toggle Meta boxes based on post format	
		function toggle_metaboxes() {
			
			var format = $('#post-formats-select input[type="radio"]:checked').val();
				
			$('#orn_metabox_gallery').fadeOut('fast');
			$('#orn_audio_format').fadeOut('fast');
			$('#orn_video_link').fadeOut('fast');
			$('#setting_orn_post_featured_meta').show();
			
			if (format == 'audio') {
				$('#orn_metabox_gallery').fadeOut('fast');
				$('#orn_video_link').fadeOut('fast');
				$('#orn_audio_format').fadeIn('slow');
				$('#setting_orn_post_featured_meta').show();
			}
			if (format == 'video') {
				$('#orn_metabox_gallery').fadeOut('fast');
				$('#orn_audio_format').fadeOut('fast');
				$('#orn_video_link').fadeIn('slow');
				$('#setting_orn_post_featured_meta').hide();
			}
			if (format == 'gallery') {
				$('#orn_video_link').fadeOut('fast');
				$('#orn_audio_format').fadeOut('fast');
				$('#orn_metabox_gallery').fadeIn('slow');
				$('#setting_orn_post_featured_meta').hide();
			}
		}
		
		toggle_metaboxes(); // Execute on document ready
		
		$('#post-formats-select input[type="radio"]').click(function() {
			toggle_metaboxes();
		});
	});
	
})(jQuery);
