
/* jshint -W099 */
/* jshint unused:false*/
/* global tinymce:false */

(function() {

	tinymce.PluginManager.add( 'st_shortcodes_mce_button', function( editor, url ) {

		editor.addButton( 'st_shortcodes_mce_button', {

			title: 'Shortcodes',
			type: 'menubutton',
			icon: 'icon st-shortcodes-icon',
			menu: [


				/*===============================================
				
					C O M M O N
					Major shortcodes
				
				===============================================*/
				{
					text: 'Common',
					menu: [

						/*--- Column --------------------------*/

						{
							text: 'Column',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Column',
									body: [

										// Column: Size
										{
											type: 'listbox',
											name: 'columnSize',
											label: 'Size',
											maxWidth: 100,
											'values': [
												{ text: '1/2', value: '1/2' },
												{ text: '1/3', value: '1/3' },
												{ text: '1/4', value: '1/4' },
												{ text: '1/5', value: '1/5' },
												{ text: '2/3', value: '2/3' },
												{ text: '2/5', value: '2/5' },
												{ text: '3/4', value: '3/4' },
												{ text: '3/5', value: '3/5' },
												{ text: '4/5', value: '4/5' },
											]
										},

										// Column: Margin
										{
											type: 'listbox',
											name: 'columnMargin',
											label: 'Margin',
											maxWidth: 100,
											'values': [
												{ text: 'Default', value: 'Default' },
												{ text: '10', value: '10' },
												{ text: '15', value: '15' },
												{ text: '20', value: '20' },
												{ text: '25', value: '25' },
												{ text: '30', value: '30' },
												{ text: '40', value: '40' },
												{ text: '50', value: '50' },

											]
										},

										// Column: Content
										{
											type: 'textbox',
											name: 'columnContent',
											label: 'Content',
											value: editor.selection.getContent({format : 'html'}) ? editor.selection.getContent({format : 'html'}) : 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
											multiline: true,
											minWidth: 400,
											minHeight: 150
										},

									],

									onsubmit: function( e ) {
										editor.insertContent( '[column' + ( e.data.columnSize != '1/2' ? ' size=' + e.data.columnSize : '' ) + ( e.data.columnMargin != 'Default' ? ' margin=' + e.data.columnMargin : '' ) + ']' + e.data.columnContent + '[/column]' );
									}

								});
							}
						},

						/*--- Button --------------------------*/

						{
							text: 'Button',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Button',
									body: [

										// Button: Text
										{
											type: 'textbox',
											name: 'buttonContent',
											label: 'Text',
											value: editor.selection.getContent({format : 'text'}) ? editor.selection.getContent({format : 'text'}) : 'Button',
										},

										// Button: URL
										{
											type: 'textbox',
											name: 'buttonURL',
											label: 'URL',
											value: 'http://google.com',
											minWidth: 400,
										},

										// Button: Target
										{
											type: 'listbox',
											name: 'buttonTarget',
											label: 'Target',
											maxWidth: 100,
											'values': [
												{ text: 'Default', value: 'Default' },
												{ text: 'Blank', value: 'blank' },
											]
										},

										// Button: Size
										{
											type: 'listbox',
											name: 'buttonSize',
											label: 'Size',
											maxWidth: 100,
											'values': [
												{ text: 'Default', value: 'Default' },
												{ text: '10', value: '10' },
												{ text: '11', value: '11' },
												{ text: '12', value: '12' },
												{ text: '13', value: '13' },
												{ text: '14', value: '14' },
												{ text: '15', value: '15' },
												{ text: '16', value: '16' },
												{ text: '18', value: '18' },
												{ text: '20', value: '20' },
												{ text: '24', value: '24' },
												{ text: '28', value: '28' },
												{ text: '32', value: '32' },
												{ text: '36', value: '36' },
											]
										},

										// Button: Color
										{
											type: 'textbox',
											name: 'buttonColor',
											label: 'Color',
											value: 'Default',
											maxWidth: 100,
										},

										// Button: Radius
										{
											type: 'textbox',
											name: 'buttonRadius',
											label: 'Radius',
											value: 'Default',
											maxWidth: 100,
										},

										// Button: Icon
										{
											type: 'listbox',
											name: 'buttonIcon',
											label: 'Icon',
											value: '',
											'values': [
												{ text: '', value: '', classes: 'st-icon-select' },
											//	{ text: 'shop', value: 'shop', classes: 'st-icon-select st-e68b' },
												{ text: 'upload', value: 'upload', classes: 'st-icon-select st-e621' },
												{ text: 'heart-2', value: 'heart-2', classes: 'st-icon-select st-e643' },
												{ text: 'star-full', value: 'star-full', classes: 'st-icon-select st-e629' },
												{ text: 'user', value: 'user', classes: 'st-icon-select st-e61f' },
												{ text: 'pause', value: 'pause', classes: 'st-icon-select st-e638' },
												{ text: 'star-half', value: 'star-half', classes: 'st-icon-select st-e628' },
												{ text: 'arrow-right-3', value: 'arrow-right-3', classes: 'st-icon-select st-e605' },
												{ text: 'help', value: 'help', classes: 'st-icon-select st-e642' },
												{ text: 'warning-2', value: 'warning-2', classes: 'st-icon-select st-e61a' },
												{ text: 'flag', value: 'flag', classes: 'st-icon-select st-e67e' },
												{ text: 'tag', value: 'tag', classes: 'st-icon-select st-e624' },
												{ text: 'plus', value: 'plus', classes: 'st-icon-select st-e60f' },
												{ text: 'external', value: 'external', classes: 'st-icon-select st-e64a' },
												{ text: 'lock', value: 'lock', classes: 'st-icon-select st-e681' },
												{ text: 'tool', value: 'tool', classes: 'st-icon-select st-e685' },
												{ text: 'warning', value: 'warning', classes: 'st-icon-select st-e61b' },
												{ text: 'mail-2', value: 'mail-2', classes: 'st-icon-select st-e63a' },
												{ text: 'add', value: 'add', classes: 'st-icon-select st-e65f' },
												{ text: 'random', value: 'random', classes: 'st-icon-select st-e682' },
												{ text: 'comment', value: 'comment', classes: 'st-icon-select st-e653' },
												{ text: 'collapse', value: 'collapse', classes: 'st-icon-select st-e610' },
												{ text: 'heart', value: 'heart', classes: 'st-icon-select st-e644' },
												{ text: 'expand', value: 'expand', classes: 'st-icon-select st-e611' },
												{ text: 'layout-grid-3', value: 'layout-grid-3', classes: 'st-icon-select st-e612' },
												{ text: 'arrow-down-4', value: 'arrow-down-4', classes: 'st-icon-select st-e602' },
												{ text: 'cart', value: 'cart', classes: 'st-icon-select st-e658' },
												{ text: 'search', value: 'search', classes: 'st-icon-select st-e62f' },
												{ text: 'speaker-off', value: 'speaker-off', classes: 'st-icon-select st-e62a' },
												{ text: 'audio', value: 'audio', classes: 'st-icon-select st-e65c' },
												{ text: 'trash', value: 'trash', classes: 'st-icon-select st-e623' },
												{ text: 'code', value: 'code', classes: 'st-icon-select st-e67d' },
												{ text: 'windows', value: 'windows', classes: 'st-icon-select st-e619' },
												{ text: 'attach', value: 'attach', classes: 'st-icon-select st-e65d' },
												{ text: 'download', value: 'download', classes: 'st-icon-select st-e64e' },
												{ text: 'arrow-up', value: 'arrow-up', classes: 'st-icon-select st-e689' },
												{ text: 'arrow-right', value: 'arrow-right', classes: 'st-icon-select st-e688' },
												{ text: 'mail', value: 'mail', classes: 'st-icon-select st-e63b' },
												{ text: 'upload-2', value: 'upload-2', classes: 'st-icon-select st-e620' },
												{ text: 'calendar', value: 'calendar', classes: 'st-icon-select st-e659' },
												{ text: 'window', value: 'window', classes: 'st-icon-select st-e618' },
												{ text: 'laptop', value: 'laptop', classes: 'st-icon-select st-e617' },
												{ text: 'view', value: 'view', classes: 'st-icon-select st-e61c' },
												{ text: 'file-2', value: 'file-2', classes: 'st-icon-select st-e648' },
												{ text: 'quote', value: 'quote', classes: 'st-icon-select st-e630' },
												{ text: 'ink', value: 'ink', classes: 'st-icon-select st-e63e' },
												{ text: 'monitor', value: 'monitor', classes: 'st-icon-select st-e687' },
												{ text: 'arrow-up-2', value: 'arrow-up-2', classes: 'st-icon-select st-e608' },
												{ text: 'menu', value: 'menu', classes: 'st-icon-select st-e613' },
												{ text: 'info', value: 'info', classes: 'st-icon-select st-e63f' },
												{ text: 'arrow-right-4', value: 'arrow-right-4', classes: 'st-icon-select st-e601' },
												{ text: 'layout-grid-list', value: 'layout-grid-list', classes: 'st-icon-select st-e614' },
												{ text: 'cross', value: 'cross', classes: 'st-icon-select st-e650' },
												{ text: 'location', value: 'location', classes: 'st-icon-select st-e680' },
												{ text: 'star', value: 'star', classes: 'st-icon-select st-e627' },
												{ text: 'arrow-down', value: 'arrow-down', classes: 'st-icon-select st-e60c' },
												{ text: 'file', value: 'file', classes: 'st-icon-select st-e649' },
												{ text: 'credit-card', value: 'credit-card', classes: 'st-icon-select st-e651' },
												{ text: 'arrow-left-3', value: 'arrow-left-3', classes: 'st-icon-select st-e607' },
												{ text: 'users', value: 'users', classes: 'st-icon-select st-e61e' },
												{ text: 'support', value: 'support', classes: 'st-icon-select st-e626' },
												{ text: 'shield', value: 'shield', classes: 'st-icon-select st-e62d' },
												{ text: 'arrow-left-4', value: 'arrow-left-4', classes: 'st-icon-select st-e603' },
												{ text: 'arrow-down-2', value: 'arrow-down-2', classes: 'st-icon-select st-e60a' },
												{ text: 'settings', value: 'settings', classes: 'st-icon-select st-e62e' },
												{ text: 'pin', value: 'pin', classes: 'st-icon-select st-e635' },
												{ text: 'image', value: 'image', classes: 'st-icon-select st-e640' },
												{ text: 'arrow-right-2', value: 'arrow-right-2', classes: 'st-icon-select st-e609' },
												{ text: 'rocket', value: 'rocket', classes: 'st-icon-select st-e683' },
												{ text: 'fullscreen', value: 'fullscreen', classes: 'st-icon-select st-e646' },
												{ text: 'layout-grid-2', value: 'layout-grid-2', classes: 'st-icon-select st-e63d' },
												{ text: 'home', value: 'home', classes: 'st-icon-select st-e641' },
												{ text: 'edit', value: 'edit', classes: 'st-icon-select st-e64c' },
												{ text: 'time', value: 'time', classes: 'st-icon-select st-e684' },
												{ text: 'chart-2', value: 'chart-2', classes: 'st-icon-select st-e656' },
												{ text: 'tablet', value: 'tablet', classes: 'st-icon-select st-e616' },
												{ text: 'folder', value: 'folder', classes: 'st-icon-select st-e67f' },
												{ text: 'arrow-left-2', value: 'arrow-left-2', classes: 'st-icon-select st-e60b' },
												{ text: 'print', value: 'print', classes: 'st-icon-select st-e631' },
												{ text: 'twitter', value: 'twitter', classes: 'st-icon-select st-e662' },
												{ text: 'gallery', value: 'gallery', classes: 'st-icon-select st-e645' },
												{ text: 'video', value: 'video', classes: 'st-icon-select st-e61d' },
												{ text: 'arrow-down-3', value: 'arrow-down-3', classes: 'st-icon-select st-e606' },
												{ text: 'signal', value: 'signal', classes: 'st-icon-select st-e62c' },
												{ text: 'play', value: 'play', classes: 'st-icon-select st-e625' },
												{ text: 'truck', value: 'truck', classes: 'st-icon-select st-e622' },
												{ text: 'comment-2', value: 'comment-2', classes: 'st-icon-select st-e652' },
												{ text: 'arrow-up-3', value: 'arrow-up-3', classes: 'st-icon-select st-e604' },
												{ text: 'mail-3', value: 'mail-3', classes: 'st-icon-select st-e639' },
												{ text: 'minus', value: 'minus', classes: 'st-icon-select st-e60e' },
												{ text: 'beaker', value: 'beaker', classes: 'st-icon-select st-e65b' },
												{ text: 'asterisk', value: 'asterisk', classes: 'st-icon-select st-e65e' },
												{ text: 'arrow-left', value: 'arrow-left', classes: 'st-icon-select st-e60d' },
												{ text: 'delete', value: 'delete', classes: 'st-icon-select st-e64f' },
												{ text: 'pen', value: 'pen', classes: 'st-icon-select st-e637' },
												{ text: 'bookmark', value: 'bookmark', classes: 'st-icon-select st-e65a' },
												{ text: 'link', value: 'link', classes: 'st-icon-select st-e63c' },
												{ text: 'portfolio', value: 'portfolio', classes: 'st-icon-select st-e632' },
												{ text: 'folder-2', value: 'folder-2', classes: 'st-icon-select st-e647' },
												{ text: 'chart', value: 'chart', classes: 'st-icon-select st-e657' },
												{ text: 'download-2', value: 'download-2', classes: 'st-icon-select st-e64d' },
												{ text: 'photo', value: 'photo', classes: 'st-icon-select st-e636' },
												{ text: 'speaker', value: 'speaker', classes: 'st-icon-select st-e62b' },
												{ text: 'phone', value: 'phone', classes: 'st-icon-select st-e615' },
												{ text: 'arrow-up-4', value: 'arrow-up-4', classes: 'st-icon-select st-e600' },
												{ text: 'pin-2', value: 'pin-2', classes: 'st-icon-select st-e634' },
												{ text: 'exit', value: 'exit', classes: 'st-icon-select st-e64b' },
												{ text: 'check', value: 'check', classes: 'st-icon-select st-e655' },
												{ text: 'check-2', value: 'check-2', classes: 'st-icon-select st-e654' },
												{ text: 'cloud', value: 'cloud', classes: 'st-icon-select st-e67c' },
												{ text: 'zoom', value: 'zoom', classes: 'st-icon-select st-e686' },
											]
										},

										// Button: Icon size
										{
											type: 'listbox',
											name: 'buttonIconSize',
											label: 'Icon size',
											maxWidth: 100,
											'values': [
												{ text: '16', value: '16' },
												{ text: '32', value: '32' },
											]
										},

										// Button: Class
										{
											type: 'textbox',
											name: 'buttonClass',
											label: 'CSS class',
											value: '',
											maxWidth: 100,
										},


									],

									onsubmit: function( e ) {
										editor.insertContent(
															 '[button' + 
															   ' url=' + e.data.buttonURL + 
																( e.data.buttonTarget != 'Default' ? ' target=' + e.data.buttonTarget : '' ) +
																( e.data.buttonSize != 'Default' ? ' size=' + e.data.buttonSize : '' ) +
																( e.data.buttonColor != 'Default' ? ' color=' + e.data.buttonColor : '' ) +
																( e.data.buttonRadius != 'Default' ? ' radius=' + e.data.buttonRadius : '' ) +
																( e.data.buttonIcon ? ' icon=' + e.data.buttonIcon : '' ) +
																( e.data.buttonIconSize != '16' ? ' icon_size=' + e.data.buttonIconSize : '' ) +
																( e.data.buttonClass ? ' class="' + e.data.buttonClass + '"' : '' ) +
																']' + e.data.buttonContent + '[/button]' );
									}

								});
							}
						},

						/*--- Alert ---------------------------*/

						{
							text: 'Alert',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Alert',
									body: [

										// Alert: Type
										{
											type: 'listbox',
											name: 'alertType',
											label: 'Type',
											'values': [
												{ text: 'Info', value: 'info' },
												{ text: 'Notice', value: 'notice' },
												{ text: 'Warning', value: 'warning' },
												{ text: 'Success', value: 'success' },
												{ text: 'Error', value: 'error' },
											]
										},

										// Alert: Content
										{
											type: 'textbox',
											name: 'alertContent',
											label: 'Content',
											value: editor.selection.getContent({format : 'text'}) ? editor.selection.getContent({format : 'text'}) : 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
											multiline: true,
											minWidth: 400,
											minHeight: 150
										},

									],

									onsubmit: function( e ) {
										editor.insertContent( '[alert' + ( e.data.alertType != 'info' ? ' type=' + e.data.alertType : '' )  + ']<br />' + e.data.alertContent + '<br />[/alert]' );
									}

								});
							}
						},

						/*--- List ----------------------------*/

						{
							text: 'List',
							onclick: function() {
								editor.windowManager.open( {
									title: 'List',
									body: [

										// List: Icon
										{
											type: 'listbox',
											name: 'listType',
											label: 'Icon',
											value: '',
											minWidth: 400,
											'values': [
												{ text: '', value: '', classes: 'st-icon-select' },
											//	{ text: 'shop', value: 'shop', classes: 'st-icon-select st-e68b' },
												{ text: 'upload', value: 'upload', classes: 'st-icon-select st-e621' },
												{ text: 'heart-2', value: 'heart-2', classes: 'st-icon-select st-e643' },
												{ text: 'star-full', value: 'star-full', classes: 'st-icon-select st-e629' },
												{ text: 'user', value: 'user', classes: 'st-icon-select st-e61f' },
												{ text: 'pause', value: 'pause', classes: 'st-icon-select st-e638' },
												{ text: 'star-half', value: 'star-half', classes: 'st-icon-select st-e628' },
												{ text: 'arrow-right-3', value: 'arrow-right-3', classes: 'st-icon-select st-e605' },
												{ text: 'help', value: 'help', classes: 'st-icon-select st-e642' },
												{ text: 'warning-2', value: 'warning-2', classes: 'st-icon-select st-e61a' },
												{ text: 'flag', value: 'flag', classes: 'st-icon-select st-e67e' },
												{ text: 'tag', value: 'tag', classes: 'st-icon-select st-e624' },
												{ text: 'plus', value: 'plus', classes: 'st-icon-select st-e60f' },
												{ text: 'external', value: 'external', classes: 'st-icon-select st-e64a' },
												{ text: 'lock', value: 'lock', classes: 'st-icon-select st-e681' },
												{ text: 'tool', value: 'tool', classes: 'st-icon-select st-e685' },
												{ text: 'warning', value: 'warning', classes: 'st-icon-select st-e61b' },
												{ text: 'mail-2', value: 'mail-2', classes: 'st-icon-select st-e63a' },
												{ text: 'add', value: 'add', classes: 'st-icon-select st-e65f' },
												{ text: 'random', value: 'random', classes: 'st-icon-select st-e682' },
												{ text: 'comment', value: 'comment', classes: 'st-icon-select st-e653' },
												{ text: 'collapse', value: 'collapse', classes: 'st-icon-select st-e610' },
												{ text: 'heart', value: 'heart', classes: 'st-icon-select st-e644' },
												{ text: 'expand', value: 'expand', classes: 'st-icon-select st-e611' },
												{ text: 'layout-grid-3', value: 'layout-grid-3', classes: 'st-icon-select st-e612' },
												{ text: 'arrow-down-4', value: 'arrow-down-4', classes: 'st-icon-select st-e602' },
												{ text: 'cart', value: 'cart', classes: 'st-icon-select st-e658' },
												{ text: 'search', value: 'search', classes: 'st-icon-select st-e62f' },
												{ text: 'speaker-off', value: 'speaker-off', classes: 'st-icon-select st-e62a' },
												{ text: 'audio', value: 'audio', classes: 'st-icon-select st-e65c' },
												{ text: 'trash', value: 'trash', classes: 'st-icon-select st-e623' },
												{ text: 'code', value: 'code', classes: 'st-icon-select st-e67d' },
												{ text: 'windows', value: 'windows', classes: 'st-icon-select st-e619' },
												{ text: 'attach', value: 'attach', classes: 'st-icon-select st-e65d' },
												{ text: 'download', value: 'download', classes: 'st-icon-select st-e64e' },
												{ text: 'arrow-up', value: 'arrow-up', classes: 'st-icon-select st-e689' },
												{ text: 'arrow-right', value: 'arrow-right', classes: 'st-icon-select st-e688' },
												{ text: 'mail', value: 'mail', classes: 'st-icon-select st-e63b' },
												{ text: 'upload-2', value: 'upload-2', classes: 'st-icon-select st-e620' },
												{ text: 'calendar', value: 'calendar', classes: 'st-icon-select st-e659' },
												{ text: 'window', value: 'window', classes: 'st-icon-select st-e618' },
												{ text: 'laptop', value: 'laptop', classes: 'st-icon-select st-e617' },
												{ text: 'view', value: 'view', classes: 'st-icon-select st-e61c' },
												{ text: 'file-2', value: 'file-2', classes: 'st-icon-select st-e648' },
												{ text: 'quote', value: 'quote', classes: 'st-icon-select st-e630' },
												{ text: 'ink', value: 'ink', classes: 'st-icon-select st-e63e' },
												{ text: 'monitor', value: 'monitor', classes: 'st-icon-select st-e687' },
												{ text: 'arrow-up-2', value: 'arrow-up-2', classes: 'st-icon-select st-e608' },
												{ text: 'menu', value: 'menu', classes: 'st-icon-select st-e613' },
												{ text: 'info', value: 'info', classes: 'st-icon-select st-e63f' },
												{ text: 'arrow-right-4', value: 'arrow-right-4', classes: 'st-icon-select st-e601' },
												{ text: 'layout-grid-list', value: 'layout-grid-list', classes: 'st-icon-select st-e614' },
												{ text: 'cross', value: 'cross', classes: 'st-icon-select st-e650' },
												{ text: 'location', value: 'location', classes: 'st-icon-select st-e680' },
												{ text: 'star', value: 'star', classes: 'st-icon-select st-e627' },
												{ text: 'arrow-down', value: 'arrow-down', classes: 'st-icon-select st-e60c' },
												{ text: 'file', value: 'file', classes: 'st-icon-select st-e649' },
												{ text: 'credit-card', value: 'credit-card', classes: 'st-icon-select st-e651' },
												{ text: 'arrow-left-3', value: 'arrow-left-3', classes: 'st-icon-select st-e607' },
												{ text: 'users', value: 'users', classes: 'st-icon-select st-e61e' },
												{ text: 'support', value: 'support', classes: 'st-icon-select st-e626' },
												{ text: 'shield', value: 'shield', classes: 'st-icon-select st-e62d' },
												{ text: 'arrow-left-4', value: 'arrow-left-4', classes: 'st-icon-select st-e603' },
												{ text: 'arrow-down-2', value: 'arrow-down-2', classes: 'st-icon-select st-e60a' },
												{ text: 'settings', value: 'settings', classes: 'st-icon-select st-e62e' },
												{ text: 'pin', value: 'pin', classes: 'st-icon-select st-e635' },
												{ text: 'image', value: 'image', classes: 'st-icon-select st-e640' },
												{ text: 'arrow-right-2', value: 'arrow-right-2', classes: 'st-icon-select st-e609' },
												{ text: 'rocket', value: 'rocket', classes: 'st-icon-select st-e683' },
												{ text: 'fullscreen', value: 'fullscreen', classes: 'st-icon-select st-e646' },
												{ text: 'layout-grid-2', value: 'layout-grid-2', classes: 'st-icon-select st-e63d' },
												{ text: 'home', value: 'home', classes: 'st-icon-select st-e641' },
												{ text: 'edit', value: 'edit', classes: 'st-icon-select st-e64c' },
												{ text: 'time', value: 'time', classes: 'st-icon-select st-e684' },
												{ text: 'chart-2', value: 'chart-2', classes: 'st-icon-select st-e656' },
												{ text: 'tablet', value: 'tablet', classes: 'st-icon-select st-e616' },
												{ text: 'folder', value: 'folder', classes: 'st-icon-select st-e67f' },
												{ text: 'arrow-left-2', value: 'arrow-left-2', classes: 'st-icon-select st-e60b' },
												{ text: 'print', value: 'print', classes: 'st-icon-select st-e631' },
												{ text: 'twitter', value: 'twitter', classes: 'st-icon-select st-e662' },
												{ text: 'gallery', value: 'gallery', classes: 'st-icon-select st-e645' },
												{ text: 'video', value: 'video', classes: 'st-icon-select st-e61d' },
												{ text: 'arrow-down-3', value: 'arrow-down-3', classes: 'st-icon-select st-e606' },
												{ text: 'signal', value: 'signal', classes: 'st-icon-select st-e62c' },
												{ text: 'play', value: 'play', classes: 'st-icon-select st-e625' },
												{ text: 'truck', value: 'truck', classes: 'st-icon-select st-e622' },
												{ text: 'comment-2', value: 'comment-2', classes: 'st-icon-select st-e652' },
												{ text: 'arrow-up-3', value: 'arrow-up-3', classes: 'st-icon-select st-e604' },
												{ text: 'mail-3', value: 'mail-3', classes: 'st-icon-select st-e639' },
												{ text: 'minus', value: 'minus', classes: 'st-icon-select st-e60e' },
												{ text: 'beaker', value: 'beaker', classes: 'st-icon-select st-e65b' },
												{ text: 'asterisk', value: 'asterisk', classes: 'st-icon-select st-e65e' },
												{ text: 'arrow-left', value: 'arrow-left', classes: 'st-icon-select st-e60d' },
												{ text: 'delete', value: 'delete', classes: 'st-icon-select st-e64f' },
												{ text: 'pen', value: 'pen', classes: 'st-icon-select st-e637' },
												{ text: 'bookmark', value: 'bookmark', classes: 'st-icon-select st-e65a' },
												{ text: 'link', value: 'link', classes: 'st-icon-select st-e63c' },
												{ text: 'portfolio', value: 'portfolio', classes: 'st-icon-select st-e632' },
												{ text: 'folder-2', value: 'folder-2', classes: 'st-icon-select st-e647' },
												{ text: 'chart', value: 'chart', classes: 'st-icon-select st-e657' },
												{ text: 'download-2', value: 'download-2', classes: 'st-icon-select st-e64d' },
												{ text: 'photo', value: 'photo', classes: 'st-icon-select st-e636' },
												{ text: 'speaker', value: 'speaker', classes: 'st-icon-select st-e62b' },
												{ text: 'phone', value: 'phone', classes: 'st-icon-select st-e615' },
												{ text: 'arrow-up-4', value: 'arrow-up-4', classes: 'st-icon-select st-e600' },
												{ text: 'pin-2', value: 'pin-2', classes: 'st-icon-select st-e634' },
												{ text: 'exit', value: 'exit', classes: 'st-icon-select st-e64b' },
												{ text: 'check', value: 'check', classes: 'st-icon-select st-e655' },
												{ text: 'check-2', value: 'check-2', classes: 'st-icon-select st-e654' },
												{ text: 'cloud', value: 'cloud', classes: 'st-icon-select st-e67c' },
												{ text: 'zoom', value: 'zoom', classes: 'st-icon-select st-e686' },
											]
										},

										// List: Row 1
										{
											type: 'textbox',
											name: 'listRow1',
											label: 'Row 1',
											value: '',
										},

										// List: Row 2
										{
											type: 'textbox',
											name: 'listRow2',
											label: 'Row 2',
											value: '',
										},

										// List: Row 3
										{
											type: 'textbox',
											name: 'listRow3',
											label: 'Row 3',
											value: '',
										},

									],

									onsubmit: function( e ) {
										editor.insertContent(
															 '[ul' + 
																( e.data.listType ? ' type=' + e.data.listType : '' ) +
																']<ul>' +
																( e.data.listRow1 ? '<li>' + e.data.listRow1 + '</li>' : '' ) +
																( e.data.listRow2 ? '<li>' + e.data.listRow2 + '</li>' : '' ) +
																( e.data.listRow3 ? '<li>' + e.data.listRow3 + '</li>' : '' ) +
																'</ul>[/ul]' );
									}

								});
							}
						},

						/*--- Pullquote -----------------------*/

						{
							text: 'Pullquote',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Pullquote',
									body: [

										// Pullquote: Type
										{
											type: 'listbox',
											name: 'pullquoteAlign',
											label: 'Align',
											maxWidth: 100,
											'values': [
												{ text: 'Right', value: 'right' },
												{ text: 'Left', value: 'left' },
											]
										},

										// Pullquote: Content
										{
											type: 'textbox',
											name: 'pullquoteContent',
											label: 'Content',
											value: editor.selection.getContent({format : 'text'}) ? editor.selection.getContent({format : 'text'}) : 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
											multiline: true,
											minWidth: 400,
											minHeight: 150
										},

									],

									onsubmit: function( e ) {
										editor.insertContent( '[pullquote' + ( e.data.pullquoteAlign != 'right' ? ' align=' + e.data.pullquoteAlign : '' )  + ']<br />' + e.data.pullquoteContent + '<br />[/pullquote]' );
									}

								});
							}
						},

						/*--- Highlight -----------------------*/

						{
							text: 'Highlight',
							onclick: function() {
								editor.insertContent( editor.selection.getContent({format : 'text'}) ? '[highlight]' + editor.selection.getContent({format : 'text'}) + '[/highlight]' : '' );
							}
						},

						/*--- Dropcap -------------------------*/

						{
							text: 'Dropcap',
							onclick: function() {
								editor.insertContent( editor.selection.getContent({format : 'text'}) ? '[dropcap]' + editor.selection.getContent({format : 'text'}) + '[/dropcap]' : '' );
							}
						},

					]
				},


				/*===============================================
				
					E L E M E N T S
					Other shortcodes
				
				===============================================*/
				{
					text: 'Elements',
					menu: [

						/*--- Tabs ----------------------------*/

						{
							text: 'Tabs',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Tabs',
									body: [

										// Tab 1: Title
										{
											type: 'textbox',
											name: 'tabsLabel1',
											label: 'Label',
											value: 'First tab',
											maxWidth: 120,
										},

										// Tab 1: Content
										{
											type: 'textbox',
											name: 'tabsContent1',
											label: 'Content',
											value: editor.selection.getContent({format : 'html'}) ? editor.selection.getContent({format : 'html'}) : 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
											multiline: true,
											minWidth: 400,
											minHeight: 120
										},

										// Tab 2: Title
										{
											type: 'textbox',
											name: 'tabsLabel2',
											label: 'Label',
											value: 'Second tab',
											maxWidth: 120,
										},

										// Tab 2: Content
										{
											type: 'textbox',
											name: 'tabsContent2',
											label: 'Content',
											value: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
											multiline: true,
											minWidth: 400,
											minHeight: 120
										},

										// Tab 3: Title
										{
											type: 'textbox',
											name: 'tabsLabel3',
											label: 'Label',
											value: 'Third tab',
											maxWidth: 120,
										},

										// Tab 3: Content
										{
											type: 'textbox',
											name: 'tabsContent3',
											label: 'Content',
											value: '',
											multiline: true,
											minWidth: 400,
											minHeight: 120
										},

									],

									onsubmit: function( e ) {
										editor.insertContent( '[tabs labels="' + 
																( e.data.tabsLabel1 && e.data.tabsContent1 ? e.data.tabsLabel1 + ',' : '' ) + 
																( e.data.tabsLabel2 && e.data.tabsContent2 ? e.data.tabsLabel2 + ',' : '' ) + 
																( e.data.tabsLabel3 && e.data.tabsContent3 ? e.data.tabsLabel3 : '' ) + 
																'"]<br />' +
															 	( e.data.tabsLabel1 && e.data.tabsContent1 ? '[t]<br />' + e.data.tabsContent1 + '<br />[/t]<br />' : '' ) + 
																( e.data.tabsLabel2 && e.data.tabsContent2 ? '[t]<br />' + e.data.tabsContent2 + '<br />[/t]<br />' : '' ) + 
																( e.data.tabsLabel3 && e.data.tabsContent3 ? '[t]<br />' + e.data.tabsContent3 + '<br />[/t]<br />' : '' ) + 
															 	'[/tabs]' );
									}

								});
							}
						},

						/*--- Toggle --------------------------*/

						{
							text: 'Toggle',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Toggle',
									body: [

										// Toggle: Status
										{
											type: 'listbox',
											name: 'toggleStatus',
											label: 'Status',
											maxWidth: 150,
											'values': [
												{ text: 'Closed', value: 'closed' },
												{ text: 'Opened', value: 'opened' },
											]
										},

										// Toggle: Title
										{
											type: 'textbox',
											name: 'toggleTitle',
											label: 'Title',
											value: 'Toggle',
										},

										// Toggle: Content
										{
											type: 'textbox',
											name: 'toggleContent',
											label: 'Content',
											value: editor.selection.getContent({format : 'html'}) ? editor.selection.getContent({format : 'html'}) : 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
											multiline: true,
											minWidth: 400,
											minHeight: 150
										},

									],

									onsubmit: function( e ) {
										editor.insertContent( '[toggle' + ( e.data.toggleStatus != 'closed' ? ' status=' + e.data.toggleStatus : '' ) + ' title="' + e.data.toggleTitle + '"]<br />' + e.data.toggleContent + '<br />[/toggle]' );
									}

								});
							}
						},

						/*--- Accordion -----------------------*/

						{
							text: 'Accordion',
							onclick: function() {
								editor.insertContent( editor.selection.getContent({format : 'html'}) ? '[accordion]<br />' + editor.selection.getContent({format : 'html'}) + '<br />[/accordion]' : '' );
							}
						},

						/*--- Notice --------------------------*/

						{
							text: 'Notice',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Notice',
									body: [

										// Notice: Size
										{
											type: 'listbox',
											name: 'noticeTitleTag',
											label: 'Tag',
											maxWidth: 100,
											'values': [
												{ text: 'H1', value: 'h1' },
												{ text: 'H2', value: 'h2' },
												{ text: 'H3', value: 'h3' },
												{ text: 'H4', value: 'h4' },
												{ text: 'H5', value: 'h5' },
												{ text: 'H6', value: 'h6' },
											]
										},

										// Notice: Title
										{
											type: 'textbox',
											name: 'noticeTitle',
											label: 'Title',
											value: 'Hello World!',
										},

										// Notice: Content
										{
											type: 'textbox',
											name: 'noticeContent',
											label: 'Content',
											value: editor.selection.getContent({format : 'html'}) ? editor.selection.getContent({format : 'html'}) : 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
											multiline: true,
											minWidth: 400,
											minHeight: 150
										},

										// Notice: Align
										{
											type: 'listbox',
											name: 'noticeAlign',
											label: 'Align',
											maxWidth: 100,
											'values': [
												{ text: 'Default', value: 'default' },
												{ text: 'Center', value: 'center' },
											]
										},

										// Notice: Class
										{
											type: 'textbox',
											name: 'noticeClass',
											label: 'CSS class',
											value: '',
											maxWidth: 100,
										},

									],

									onsubmit: function( e ) {
										editor.insertContent( '[notice' + 
																( e.data.noticeAlign != 'default' ? ' align=' + e.data.noticeAlign : '' ) +
																( e.data.noticeClass ? ' class="' + e.data.noticeClass + '"' : '' ) +
																']' +
															 	( e.data.noticeTitle ? '<' + e.data.noticeTitleTag + '>' + e.data.noticeTitle + '</' + e.data.noticeTitleTag + '>' : '' ) +
																e.data.noticeContent +
																'<br />[/notice]' );
									}

								});
							}
						},

						/*--- Icon Box ------------------------*/

						{
							text: 'Icon Box',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Icon Box',
									body: [

										// Icon Box: Icon
										{
											type: 'listbox',
											name: 'iconboxIcon',
											label: 'Icon',
											value: '',
											'values': [
												{ text: '', value: '', classes: 'st-icon-select' },
											//	{ text: 'shop', value: 'shop', classes: 'st-icon-select st-e68b' },
												{ text: 'upload', value: 'upload', classes: 'st-icon-select st-e621' },
												{ text: 'heart-2', value: 'heart-2', classes: 'st-icon-select st-e643' },
												{ text: 'star-full', value: 'star-full', classes: 'st-icon-select st-e629' },
												{ text: 'user', value: 'user', classes: 'st-icon-select st-e61f' },
												{ text: 'pause', value: 'pause', classes: 'st-icon-select st-e638' },
												{ text: 'star-half', value: 'star-half', classes: 'st-icon-select st-e628' },
												{ text: 'arrow-right-3', value: 'arrow-right-3', classes: 'st-icon-select st-e605' },
												{ text: 'help', value: 'help', classes: 'st-icon-select st-e642' },
												{ text: 'warning-2', value: 'warning-2', classes: 'st-icon-select st-e61a' },
												{ text: 'flag', value: 'flag', classes: 'st-icon-select st-e67e' },
												{ text: 'tag', value: 'tag', classes: 'st-icon-select st-e624' },
												{ text: 'plus', value: 'plus', classes: 'st-icon-select st-e60f' },
												{ text: 'external', value: 'external', classes: 'st-icon-select st-e64a' },
												{ text: 'lock', value: 'lock', classes: 'st-icon-select st-e681' },
												{ text: 'tool', value: 'tool', classes: 'st-icon-select st-e685' },
												{ text: 'warning', value: 'warning', classes: 'st-icon-select st-e61b' },
												{ text: 'mail-2', value: 'mail-2', classes: 'st-icon-select st-e63a' },
												{ text: 'add', value: 'add', classes: 'st-icon-select st-e65f' },
												{ text: 'random', value: 'random', classes: 'st-icon-select st-e682' },
												{ text: 'comment', value: 'comment', classes: 'st-icon-select st-e653' },
												{ text: 'collapse', value: 'collapse', classes: 'st-icon-select st-e610' },
												{ text: 'heart', value: 'heart', classes: 'st-icon-select st-e644' },
												{ text: 'expand', value: 'expand', classes: 'st-icon-select st-e611' },
												{ text: 'layout-grid-3', value: 'layout-grid-3', classes: 'st-icon-select st-e612' },
												{ text: 'arrow-down-4', value: 'arrow-down-4', classes: 'st-icon-select st-e602' },
												{ text: 'cart', value: 'cart', classes: 'st-icon-select st-e658' },
												{ text: 'search', value: 'search', classes: 'st-icon-select st-e62f' },
												{ text: 'speaker-off', value: 'speaker-off', classes: 'st-icon-select st-e62a' },
												{ text: 'audio', value: 'audio', classes: 'st-icon-select st-e65c' },
												{ text: 'trash', value: 'trash', classes: 'st-icon-select st-e623' },
												{ text: 'code', value: 'code', classes: 'st-icon-select st-e67d' },
												{ text: 'windows', value: 'windows', classes: 'st-icon-select st-e619' },
												{ text: 'attach', value: 'attach', classes: 'st-icon-select st-e65d' },
												{ text: 'download', value: 'download', classes: 'st-icon-select st-e64e' },
												{ text: 'arrow-up', value: 'arrow-up', classes: 'st-icon-select st-e689' },
												{ text: 'arrow-right', value: 'arrow-right', classes: 'st-icon-select st-e688' },
												{ text: 'mail', value: 'mail', classes: 'st-icon-select st-e63b' },
												{ text: 'upload-2', value: 'upload-2', classes: 'st-icon-select st-e620' },
												{ text: 'calendar', value: 'calendar', classes: 'st-icon-select st-e659' },
												{ text: 'window', value: 'window', classes: 'st-icon-select st-e618' },
												{ text: 'laptop', value: 'laptop', classes: 'st-icon-select st-e617' },
												{ text: 'view', value: 'view', classes: 'st-icon-select st-e61c' },
												{ text: 'file-2', value: 'file-2', classes: 'st-icon-select st-e648' },
												{ text: 'quote', value: 'quote', classes: 'st-icon-select st-e630' },
												{ text: 'ink', value: 'ink', classes: 'st-icon-select st-e63e' },
												{ text: 'monitor', value: 'monitor', classes: 'st-icon-select st-e687' },
												{ text: 'arrow-up-2', value: 'arrow-up-2', classes: 'st-icon-select st-e608' },
												{ text: 'menu', value: 'menu', classes: 'st-icon-select st-e613' },
												{ text: 'info', value: 'info', classes: 'st-icon-select st-e63f' },
												{ text: 'arrow-right-4', value: 'arrow-right-4', classes: 'st-icon-select st-e601' },
												{ text: 'layout-grid-list', value: 'layout-grid-list', classes: 'st-icon-select st-e614' },
												{ text: 'cross', value: 'cross', classes: 'st-icon-select st-e650' },
												{ text: 'location', value: 'location', classes: 'st-icon-select st-e680' },
												{ text: 'star', value: 'star', classes: 'st-icon-select st-e627' },
												{ text: 'arrow-down', value: 'arrow-down', classes: 'st-icon-select st-e60c' },
												{ text: 'file', value: 'file', classes: 'st-icon-select st-e649' },
												{ text: 'credit-card', value: 'credit-card', classes: 'st-icon-select st-e651' },
												{ text: 'arrow-left-3', value: 'arrow-left-3', classes: 'st-icon-select st-e607' },
												{ text: 'users', value: 'users', classes: 'st-icon-select st-e61e' },
												{ text: 'support', value: 'support', classes: 'st-icon-select st-e626' },
												{ text: 'shield', value: 'shield', classes: 'st-icon-select st-e62d' },
												{ text: 'arrow-left-4', value: 'arrow-left-4', classes: 'st-icon-select st-e603' },
												{ text: 'arrow-down-2', value: 'arrow-down-2', classes: 'st-icon-select st-e60a' },
												{ text: 'settings', value: 'settings', classes: 'st-icon-select st-e62e' },
												{ text: 'pin', value: 'pin', classes: 'st-icon-select st-e635' },
												{ text: 'image', value: 'image', classes: 'st-icon-select st-e640' },
												{ text: 'arrow-right-2', value: 'arrow-right-2', classes: 'st-icon-select st-e609' },
												{ text: 'rocket', value: 'rocket', classes: 'st-icon-select st-e683' },
												{ text: 'fullscreen', value: 'fullscreen', classes: 'st-icon-select st-e646' },
												{ text: 'layout-grid-2', value: 'layout-grid-2', classes: 'st-icon-select st-e63d' },
												{ text: 'home', value: 'home', classes: 'st-icon-select st-e641' },
												{ text: 'edit', value: 'edit', classes: 'st-icon-select st-e64c' },
												{ text: 'time', value: 'time', classes: 'st-icon-select st-e684' },
												{ text: 'chart-2', value: 'chart-2', classes: 'st-icon-select st-e656' },
												{ text: 'tablet', value: 'tablet', classes: 'st-icon-select st-e616' },
												{ text: 'folder', value: 'folder', classes: 'st-icon-select st-e67f' },
												{ text: 'arrow-left-2', value: 'arrow-left-2', classes: 'st-icon-select st-e60b' },
												{ text: 'print', value: 'print', classes: 'st-icon-select st-e631' },
												{ text: 'twitter', value: 'twitter', classes: 'st-icon-select st-e662' },
												{ text: 'gallery', value: 'gallery', classes: 'st-icon-select st-e645' },
												{ text: 'video', value: 'video', classes: 'st-icon-select st-e61d' },
												{ text: 'arrow-down-3', value: 'arrow-down-3', classes: 'st-icon-select st-e606' },
												{ text: 'signal', value: 'signal', classes: 'st-icon-select st-e62c' },
												{ text: 'play', value: 'play', classes: 'st-icon-select st-e625' },
												{ text: 'truck', value: 'truck', classes: 'st-icon-select st-e622' },
												{ text: 'comment-2', value: 'comment-2', classes: 'st-icon-select st-e652' },
												{ text: 'arrow-up-3', value: 'arrow-up-3', classes: 'st-icon-select st-e604' },
												{ text: 'mail-3', value: 'mail-3', classes: 'st-icon-select st-e639' },
												{ text: 'minus', value: 'minus', classes: 'st-icon-select st-e60e' },
												{ text: 'beaker', value: 'beaker', classes: 'st-icon-select st-e65b' },
												{ text: 'asterisk', value: 'asterisk', classes: 'st-icon-select st-e65e' },
												{ text: 'arrow-left', value: 'arrow-left', classes: 'st-icon-select st-e60d' },
												{ text: 'delete', value: 'delete', classes: 'st-icon-select st-e64f' },
												{ text: 'pen', value: 'pen', classes: 'st-icon-select st-e637' },
												{ text: 'bookmark', value: 'bookmark', classes: 'st-icon-select st-e65a' },
												{ text: 'link', value: 'link', classes: 'st-icon-select st-e63c' },
												{ text: 'portfolio', value: 'portfolio', classes: 'st-icon-select st-e632' },
												{ text: 'folder-2', value: 'folder-2', classes: 'st-icon-select st-e647' },
												{ text: 'chart', value: 'chart', classes: 'st-icon-select st-e657' },
												{ text: 'download-2', value: 'download-2', classes: 'st-icon-select st-e64d' },
												{ text: 'photo', value: 'photo', classes: 'st-icon-select st-e636' },
												{ text: 'speaker', value: 'speaker', classes: 'st-icon-select st-e62b' },
												{ text: 'phone', value: 'phone', classes: 'st-icon-select st-e615' },
												{ text: 'arrow-up-4', value: 'arrow-up-4', classes: 'st-icon-select st-e600' },
												{ text: 'pin-2', value: 'pin-2', classes: 'st-icon-select st-e634' },
												{ text: 'exit', value: 'exit', classes: 'st-icon-select st-e64b' },
												{ text: 'check', value: 'check', classes: 'st-icon-select st-e655' },
												{ text: 'check-2', value: 'check-2', classes: 'st-icon-select st-e654' },
												{ text: 'cloud', value: 'cloud', classes: 'st-icon-select st-e67c' },
												{ text: 'zoom', value: 'zoom', classes: 'st-icon-select st-e686' },
											]
										},

										// Icon Box: Icon size
										{
											type: 'listbox',
											name: 'iconboxIconSize',
											label: 'Icon size',
											maxWidth: 100,
											'values': [
												{ text: '32', value: '32' },
												{ text: '16', value: '16' },
											]
										},

										// Icon Box: Icon color
										{
											type: 'listbox',
											name: 'iconboxIconColor',
											label: 'Icon color',
											maxWidth: 100,
											'values': [
												{ text: 'Gray', value: 'gray' },
												{ text: 'White', value: 'white' },
											]
										},

										// Icon Box: Width
										{
											type: 'listbox',
											name: 'iconboxWidth',
											label: 'Width',
											maxWidth: 100,
											'values': [
												{ text: '1/2', value: '1/2' },
												{ text: '1/3', value: '1/3' },
												{ text: '1/4', value: '1/4' },
												{ text: '1/5', value: '1/5' },
												{ text: '2/3', value: '2/3' },
												{ text: '2/5', value: '2/5' },
												{ text: '3/4', value: '3/4' },
												{ text: '3/5', value: '3/5' },
												{ text: '4/5', value: '4/5' },
											]
										},

										// Icon Box: Content
										{
											type: 'textbox',
											name: 'iconboxContent',
											label: 'Content',
											value: editor.selection.getContent({format : 'html'}) ? editor.selection.getContent({format : 'html'}) : 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
											multiline: true,
											minWidth: 400,
											minHeight: 150
										},

									],

									onsubmit: function( e ) {
										editor.insertContent(
															 '[icon-box' + 
																( e.data.iconboxIcon ? ' icon=' + e.data.iconboxIcon : '' ) +
																( e.data.iconboxIconSize != '32' ? ' size=' + e.data.iconboxIconSize : '' ) +
																( e.data.iconboxIconColor != 'gray' ? ' color=' + e.data.iconboxIconColor : '' ) +
																( e.data.iconboxWidth != '1/2' ? ' width=' + e.data.iconboxWidth : '' ) +
																']<br />' + e.data.iconboxContent + '<br />[/icon-box]' );
									}

								});
							}
						},

						/*--- Skill Bar -----------------------*/

						{
							text: 'Skill Bar',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Skill Bar',
									body: [

										// Skill Bar: Start
										{
											type: 'listbox',
											name: 'skillbarStart',
											label: 'Start',
											maxWidth: 150,
											'values': [
												{ text: 'Scroll', value: 'scroll' },
												{ text: 'Auto', value: 'auto' },
											]
										},

										// Skill Bar: Label
										{
											type: 'textbox',
											name: 'skillbarLabel',
											label: 'Label',
											value: editor.selection.getContent({format : 'text'}) ? editor.selection.getContent({format : 'text'}) : 'My Skill',
										},

										// Skill Bar: Progress
										{
											type: 'textbox',
											name: 'skillbarProgress',
											label: 'Progress',
											value: '90',
										},

									],

									onsubmit: function( e ) {
										editor.insertContent( '[skill' + ( e.data.skillbarStart != 'scroll' ? ' start=' + e.data.skillbarStart : '' ) + ' progress=' + e.data.skillbarProgress + ']' + e.data.skillbarLabel + '[/skill]' );
									}

								});
							}
						},

						/*--- Google map ----------------------*/

						{
							text: 'Google map',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Google map',
									body: [

										// Google map: Address
										{
											type: 'textbox',
											name: 'mapAddress',
											label: 'Address',
											minWidth: 400,
											value: 'New York, United States'
										},

										// Google map: Zoom
										{
											type: 'listbox',
											name: 'mapZoom',
											label: 'Zoom',
											maxWidth: 100,
											'values': [
												{ text: '10', value: '10' },
												{ text: '1', value: '1' },
												{ text: '2', value: '2' },
												{ text: '3', value: '3' },
												{ text: '4', value: '4' },
												{ text: '5', value: '5' },
												{ text: '6', value: '6' },
												{ text: '7', value: '7' },
												{ text: '8', value: '8' },
												{ text: '9', value: '9' },
												{ text: '10', value: '10' },
												{ text: '11', value: '11' },
												{ text: '12', value: '12' },
												{ text: '13', value: '13' },
												{ text: '14', value: '14' },
												{ text: '15', value: '15' },
											]
										},

										// Google map: Width
										{
											type: 'textbox',
											name: 'mapWidth',
											label: 'Width',
											maxWidth: 100,
											value: '100%'
										},

										// Google map: Height
										{
											type: 'textbox',
											name: 'mapHeight',
											label: 'Height',
											maxWidth: 100,
											value: '300px'
										},

									],

									onsubmit: function( e ) {
										editor.insertContent( '[googlemap address="' + e.data.mapAddress + '" zoom=' + e.data.mapZoom + ( e.data.mapWidth != '100%' ? ' width=' + e.data.mapWidth : '' ) + ( e.data.mapHeight != '300px' ? ' height=' + e.data.mapHeight : '' ) + ']' );
									}

								});
							}
						},

						/*--- Table ---------------------------*/

						{
							text: 'Table',
							onclick: function() {
								editor.insertContent( '<table><caption>The table</caption><tbody><tr><th>Name</th><th>Order</th><th>Price</th></tr><tr><td>Item One</td><td>#001</td><td>$3</td></tr><tr class="alt"><td>Item Two</td><td>#002</td><td>$6</td></tr><tr><td>Item Three</td><td>#003</td><td>$9</td></tr><tr class="alt"><td>Item Four</td><td>#004</td><td>$12</td></tr><tr><td>Item Five</td><td>#005</td><td>$15</td></tr></tbody><tfoot><tr><td>Table Footer 1</td><td>Table Footer 2</td><td>Table Footer 3</td></tr></tfoot></table>' );
							}
						},

						/*--- Pricing table -------------------*/

						{
							text: 'Pricing table',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Pricing table',
									body: [

										// Pricing table: Size
										{
											type: 'listbox',
											name: 'pricingSize',
											label: 'Size',
											maxWidth: 100,
											'values': [
												{ text: '1/2', value: '1/2' },
												{ text: '1/3', value: '1/3' },
												{ text: '1/4', value: '1/4' },
												{ text: '1/5', value: '1/5' },
											]
										},

										// Pricing table: Style
										{
											type: 'listbox',
											name: 'pricingStyle',
											label: 'Style',
											maxWidth: 100,
											'values': [
												{ text: 'Dark', value: 'dark' },
												{ text: 'Gray', value: 'gray' },
												{ text: 'Featured', value: 'featured' },
											]
										},
										
										// Pricing table: Title
										{
											type: 'textbox',
											name: 'pricingTitle',
											label: 'Title',
											minWidth: 400,
											value: ''
										},
										
										// Pricing table: Price
										{
											type: 'textbox',
											name: 'pricingPrice',
											label: 'Price',
											maxWidth: 100,
											value: '$0'
										},
										
										// Pricing table: Comment
										{
											type: 'textbox',
											name: 'pricingComment',
											label: 'Comment',
											minWidth: 400,
											value: ''
										},
										
										// Pricing table: Button
										{
											type: 'textbox',
											name: 'pricingButton',
											label: 'Button',
											maxWidth: 100,
											value: 'Purchase'
										},
										
										// Pricing table: Link
										{
											type: 'textbox',
											name: 'pricingLink',
											label: 'Link',
											minWidth: 400,
											value: '#'
										},

										// Pricing table: Target
										{
											type: 'listbox',
											name: 'pricingTarget',
											label: 'Target',
											maxWidth: 100,
											'values': [
												{ text: 'Parent', value: 'parent' },
												{ text: 'Blank', value: 'blank' },
											]
										},

										// Pricing table: Content
										{
											type: 'textbox',
											name: 'pricingContent',
											label: 'Content',
											value: editor.selection.getContent({format : 'html'}) ? editor.selection.getContent({format : 'html'}) : 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
											multiline: true,
											minWidth: 400,
											minHeight: 150
										},


									],

									onsubmit: function( e ) {
										editor.insertContent(
															 '[pricing-table ' + 
																( e.data.pricingSize != '1/2' ? ' size=' + e.data.pricingSize : '' ) +
																( e.data.pricingStyle != 'dark' ? ' style=' + e.data.pricingStyle : '' ) +
																( e.data.pricingTitle ? ' title="' + e.data.pricingTitle + '"' : '' ) +
																( e.data.pricingPrice ? ' price="' + e.data.pricingPrice + '"' : '' ) +
																( e.data.pricingComment ? ' comment="' + e.data.pricingComment + '"' : '' ) +
																( e.data.pricingButton ? ' button="' + e.data.pricingButton + '"' : '' ) +
																( e.data.pricingLink ? ' link=' + e.data.pricingLink : '' ) +
																( e.data.pricingTarget != 'parent' ? ' target=' + e.data.pricingTarget : '' ) +
																']<br />' + e.data.pricingContent + '<br />[/pricing-table]' );
									}

								});
							}
						},

					]
				},


				/*===============================================
				
					M I S C
					Misc shortcodes
				
				===============================================*/
				{
					text: 'Misc',
					menu: [

						/*--- Sidebar -------------------------*/

						{
							text: 'Sidebar',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Sidebar',
									body: [

										// Sidebar: Name
										{
											type: 'textbox',
											name: 'sidebarLabel',
											label: 'Label',
											value: 'Custom Bar 1',
											minWidth: 200,
										},

									],

									onsubmit: function( e ) {
										editor.insertContent( '[sidebar label="' + e.data.sidebarLabel  + '"]' );
									}

								});
							}
						},

						/*--- Clear ---------------------------*/

						{
							text: 'Clear',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Clear',
									body: [

										// Clear: Gap
										{
											type: 'textbox',
											name: 'clearGap',
											label: 'Gap',
											value: '0',
										},

									],

									onsubmit: function( e ) {
										editor.insertContent( '[clear' + ( e.data.clearGap != '0' ? ' h=' + e.data.clearGap : '' ) + ']' );
									}

								});
							}
						},

					]
				},


			]

		});

	});

})();