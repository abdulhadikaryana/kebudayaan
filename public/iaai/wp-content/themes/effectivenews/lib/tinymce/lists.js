(function() {
    tinymce.create('tinymce.plugins.lists', {
        init : function(ed, url) {
            ed.addButton('lists', {
                title : 'Add a List',
                image : url+'/images/lists.png',
                onclick : function() {
// triggers the thickbox
						var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'Lists Shortcodes', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=list-form' );
						                }
            });
        },
        createControl : function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('lists', tinymce.plugins.lists);
    
    // executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="list-form"><table id="list-table" class="form-table">\
			<tr>\
				<th><label for="list-type">List Type</label></th>\
				<td><select name="type" id="list-type">\
					<option value="icons-glass">icons-glass</option>\
					<option value="icons-music"> icons-music</option>\
					<option value="icons-search">icons-search</option>\
					<option value="icons-envelope">icons-envelope</option>\
					<option value="icons-heart">icons-heart</option>\
					<option value="icons-star">icons-star</option>\
					<option value="icons-star-empty">icons-star-empty</option>\
					<option value="icons-user">icons-user</option>\
					<option value="icons-film">icons-film</option>\
					<option value="icons-th-large">icons-th-large</option>\
					<option value="icons-th">icons-th</option>\
					<option value="icons-th-list">icons-th-list</option>\
					<option value="icons-ok">icons-ok</option>\
					<option value="icons-remove">icons-remove</option>\
					<option value="icons-zoom-in">icons-zoom-in</option>\
					<option value="icons-zoom-out">icons-zoom-out</option>\
					<option value="icons-off">icons-off</option>\
					<option value="icons-signal">icons-signal</option>\
					<option value="icons-cog">icons-cog</option>\
					<option value="icons-trash">icons-trash</option>\
					<option value="icons-home">icons-home</option>\
					<option value="icons-file">icons-file</option>\
					<option value="icons-time">icons-time</option>\
					<option value="icons-road">icons-road</option>\
					<option value="icons-download-alt">icons-download-alt</option>\
					<option value="icons-download">icons-download</option>\
					<option value="icons-upload">icons-upload</option>\
					<option value="icons-inbox">icons-inbox</option>\
					<option value="icons-play-circle">icons-play-circle</option>\
					<option value="icons-repeat">icons-repeat</option>\
					<option value="icons-refresh">icons-refresh</option>\
					<option value="icons-list-alt">icons-list-alt</option>\
					<option value="icons-lock">icons-lock</option>\
					<option value="icons-flag">icons-flag</option>\
					<option value="icons-headphones">icons-headphones</option>\
					<option value="icons-volume-off">icons-volume-off</option>\
					<option value="icons-volume-down">icons-volume-down</option>\
					<option value="icons-volume-up">icons-volume-up</option>\
					<option value="icons-qrcode">icons-qrcode</option>\
					<option value="icons-barcode">icons-barcode</option>\
					<option value="icons-tag">icons-tag</option>\
					<option value="icons-tags">icons-tags</option>\
					<option value="icons-book">icons-book</option>\
					<option value="icons-bookmark">icons-bookmark</option>\
					<option value="icons-print">icons-print</option>\
					<option value="icons-camera">icons-camera</option>\
					<option value="icons-facetime-video">icons-facetime-video</option>\
					<option value="icons-picture">icons-picture</option>\
					<option value="icons-pencil">icons-pencil</option>\
					<option value="icons-map-marker">icons-map-marker</option>\
					<option value="icons-edit">icons-edit</option>\
					<option value="icons-share">icons-share</option>\
					<option value="icons-check">icons-check</option>\
					<option value="icons-move">icons-move</option>\
					<option value="icons-chevron-right">icons-chevron-right</option>\
					<option value="icons-chevron-left">icons-chevron-left</option>\
					<option value="icons-plus-sign">icons-plus-sign</option>\
					<option value="icons-minus-sign">icons-minus-sign</option>\
					<option value="icons-remove-sign">icons-remove-sign</option>\
					<option value="icons-ok-sign">icons-ok-sign</option>\
					<option value="icons-question-sign">icons-question-sign</option>\
					<option value="icons-info-sign">icons-info-sign</option>\
					<option value="icons-screenshot">icons-screenshot</option>\
					<option value="icons-remove-circle">icons-remove-circle</option>\
					<option value="icons-ok-circle">icons-ok-circle</option>\
					<option value="icons-ban-circle">icons-ban-circle</option>\
					<option value="icons-arrow-right">icons-arrow-right</option>\
					<option value="icons-arrow-left">icons-arrow-left</option>\
					<option value="icons-share-alt">icons-share-alt</option>\
					<option value="icons-plus">icons-plus</option>\
					<option value="icons-minus">icons-minus</option>\
					<option value="icons-asterisk">icons-asterisk</option>\
					<option value="icons-exclamation-sign">icons-exclamation-sign</option>\
					<option value="icons-gift">icons-gift</option>\
					<option value="icons-leaf">icons-leaf</option>\
					<option value="icons-fire">icons-fire</option>\
					<option value="icons-eye-open">icons-eye-open</option>\
					<option value="icons-eye-close">icons-eye-close</option>\
					<option value="icons-warning-sign">icons-warning-sign</option>\
					<option value="icons-plane">icons-plane</option>\
					<option value="icons-calendar">icons-calendar</option>\
					<option value="icons-random">icons-random</option>\
					<option value="icons-comment">icons-comment</option>\
					<option value="icons-retweet">icons-retweet</option>\
					<option value="icons-shopping-cart">icons-shopping-cart</option>\
					<option value="icons-folder-close">icons-folder-close</option>\
					<option value="icons-folder-open">icons-folder-open</option>\
					<option value="icons-hdd">icons-hdd</option>\
					<option value="icons-bullhorn">icons-bullhorn</option>\
					<option value="icons-bell">icons-bell</option>\
					<option value="icons-certificate">icons-certificate</option>\
					<option value="icons-thumbs-up">icons-thumbs-up</option>\
					<option value="icons-thumbs-down">icons-thumbs-down</option>\
					<option value="icons-hand-right">icons-hand-right</option>\
					<option value="icons-hand-left">icons-hand-left</option>\
					<option value="icons-hand-up">icons-hand-up</option>\
					<option value="icons-hand-down">icons-hand-down</option>\
					<option value="icons-circle-arrow-right">icons-circle-arrow-right</option>\
					<option value="icons-circle-arrow-left">icons-circle-arrow-left</option>\
					<option value="icons-circle-arrow-up">icons-circle-arrow-up</option>\
					<option value="icons-circle-arrow-down">icons-circle-arrow-down</option>\
					<option value="icons-globe">icons-globe</option>\
					<option value="icons-wrench">icons-wrench</option>\
					<option value="icons-tasks">icons-tasks</option>\
					<option value="icons-filter">icons-filter</option>\
					<option value="icons-briefcase">icons-briefcase</option>\
					<option value="icons-fullscreen">icons-fullscreen</option>\
				</select><br />\
		<p class="submit">\
			<input type="button" id="list-submit" class="button-primary" value="Insert List" name="submit" />\
		</p>\
		</div>');
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#list-submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'type':'',
		};
			var shortcode = '[list';
			
			for( var index in options) {
				var value = table.find('#list-' + index).val();
				
				// attaches the attribute to the shortcode only if it's different from the default value
				if ( value !== options[index] )
					shortcode += ' ' + index + '="' + value + '"';
			}
			
			shortcode += ']<ul>\
	<li>Content Here...</li>\
	</ul>\[/list]';
			
			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			// closes Thickbox
			tb_remove();
		});
	});
})();
