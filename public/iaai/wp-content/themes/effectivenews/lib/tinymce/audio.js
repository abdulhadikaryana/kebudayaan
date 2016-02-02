(function() {
    tinymce.create('tinymce.plugins.audiosc', {
        init : function(ed, url) {
            ed.addButton('audiosc', {
                title : 'Add a SoundCloud audio',
                image : url+'/images/audiosc.png',
                onclick : function() {
                                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'Audio Shortcodes', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=audio-form' );
				    }
            });
        },
        createControl : function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('audiosc', tinymce.plugins.audiosc);
    
    // executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="audio-form"><table id="audio-table" class="form-table">\
			<tr>\
				<th><label for="audio-id">SoundCloud URL</label></th>\
				<td><input type="text" id="audio-id" name="id" /><br />\
				<small>ex: https://soundcloud.com/marketplace-radio/u-s-china-agree-to-meet".</small></td>\
			</tr>\
                        <tr>\
				<th><label for="audio-width">Width</label></th>\
				<td><input type="text" id="audio-width" name="width"/><br />\
			</tr>\
			<tr>\
				<th><label for="audio-height">Height</label></th>\
				<td><input type="text" id="audio-height" name="height"/><br />\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="audio-submit" class="button-primary" value="Insert audio" name="submit" />\
		</p>\
		</div>');
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#audio-submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = {
                                'width':'',
				'height':'',
				'id':'',
		};
			var shortcode = '[sound';
			
			for( var index in options) {
				var value = table.find('#audio-' + index).val();
				
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
