(function() {
    tinymce.create('tinymce.plugins.rsssc', {
        init : function(ed, url) {
            ed.addButton('rsssc', {
                title : 'Add a RSS Feed',
                image : url+'/images/feeds.png',
                onclick : function() {
// triggers the thickbox
						var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'Rss Feed Shortcodes', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=rss-form' );
						                }
            });
        },
        createControl : function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('rsssc', tinymce.plugins.rsssc);
    
    // executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="rss-form"><table id="rss-table" class="form-table">\
			<tr>\
				<th><label for="rfeed-feed">Feed URL</label></th>\
				<td><input type="text" id="rfeed-feed" name="feed" /><br />\
				<small>ex: http://feeds.feedburner.com/themeforest</small></td>\
			</tr>\
			<tr>\
				<th><label for="rfeed-num">number</label></th>\
				<td><input type="text" id="rfeed-num" name="num"/><br />\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="rfeed-submit" class="button-primary" value="Insert Rss Feed" name="submit" />\
		</p>\
		</div>');
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#rfeed-submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'feed':'',
				'num':'',
		};
			var shortcode = '[rss';
			
			for( var index in options) {
				var value = table.find('#rfeed-' + index).val();
				
				// attaches the attribute to the shortcode only if it's different from the default value
				if ( value !== options[index] )
					shortcode += ' ' + index + '="' + value + '"';
			}
			
			shortcode += ']';
			
			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			// closes Thickbox
			tb_remove();
		});
	});
})();
