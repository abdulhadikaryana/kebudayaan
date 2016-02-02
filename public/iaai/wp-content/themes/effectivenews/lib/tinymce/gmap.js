(function() {
    tinymce.create('tinymce.plugins.gmapsc', {
        init : function(ed, url) {
            ed.addButton('gmapsc', {
                title : 'Add a Google Map',
                image : url+'/images/maps.png',
                onclick : function() {
// triggers the thickbox
						var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'Google map Shortcodes', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=gmap-form' );
						                }
            });
        },
        createControl : function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('gmapsc', tinymce.plugins.gmapsc);
    
    // executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="gmap-form"><table id="gmap-table" class="form-table">\
			<tr>\
				<th><label for="gmap-src">Google Map URL</label></th>\
				<td><input type="text" id="gmap-src" name="src" /><br />\
			</tr>\
			<tr>\
				<th><label for="gmap-width">Map Width</label></th>\
				<td><input type="text" id="gmap-width" name="width"/><br />\
			</tr>\
			<tr>\
				<th><label for="gmap-height">Map Height</label></th>\
				<td><input type="text" id="gmap-height" name="height"/><br />\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="gmap-submit" class="button-primary" value="Insert Map" name="submit" />\
		</p>\
		</div>');
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#gmap-submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = {
				'src':'',
				'width':'',
				'height':'',
		};
			var shortcode = '[googlemap';
			
			for( var index in options) {
				var value = table.find('#gmap-' + index).val();
				
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
