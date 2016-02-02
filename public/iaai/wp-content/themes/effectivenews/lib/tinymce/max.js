(function() {
    tinymce.create('tinymce.plugins.mixsc', {
        init : function(ed, url) {
            ed.addButton('mixsc', {
                title : 'Add a MixCloud',
                image : url+'/images/mix.png',
                onclick : function() {
                                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'MixCloud Shortcodes', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=mixsc-form' );
				    }
            });
        },
        createControl : function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('mixsc', tinymce.plugins.mixsc);
    
    // executes this when the DOM is ready
	jQuery(function($){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="mixsc-form"><table id="mixsc-table" class="form-table">\
			<tr>\
				<th><label for="mixsc-id">MixCloud URL</label></th>\
				<td><input type="text" id="mixsc-id" name="id" /><br />\
				<small>ex: http://www.mixcloud.com/puresoul/puresoul-x-step-mini-av-mix/".</small></td>\
			</tr>\
                        <tr>\
				<th><label for="mixsc-width">Width</label></th>\
				<td><input type="text" id="mixsc-width" name="width"/><br />\
			</tr>\
			<tr>\
				<th><label for="mixsc-height">Height</label></th>\
				<td><input type="text" id="mixsc-height" name="height"/><br />\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="mixsc-submit" class="button-primary" value="Insert audio" name="submit" />\
		</p>\
		</div>');
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#mixsc-submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = {
                'width':'',
				'height':'',
				'id':'',
		};
			var shortcode = '[mixcloud';
			
			for( var index in options) {
				var value = table.find('#mixsc-' + index).val();
				
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
