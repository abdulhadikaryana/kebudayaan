<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	1 - METABOX: FORMAT OPTIONS

		1.1 - Array
		1.2 - Controls
		1.3 - Register metabox
		1.4 - Save data

*/

/*===============================================

 	M E T A B O X :   P O S T   O P T I O N S
	An unique settings for each post

===============================================*/


	/*-------------------------------------------
		1.1 - Array
	-------------------------------------------*/

	function st_MetaboxFormat() {

		global
			$st_MetaboxFormat;

			$st_MetaboxFormat = 
		
				array(

					'disable_breadcrumbs' => array(
						'name'			=> 'disable_breadcrumbs',
						'title'			=> __( 'Breadcrumbs', 'stkit' ),
						'description'	=> __( 'Do not show breadcrumbs.', 'stkit' ),
					),

					'disable_title' => array(
						'name'			=> 'disable_title',
						'title'			=> __( 'Title', 'stkit' ),
						'description'	=> __( 'Do not show post title.', 'stkit' ),
					),
	
					'subtitle' => array(
						'name'			=> 'subtitle',
						'title'			=> __( 'Sub title', 'stkit' ),
						'description'	=> __( 'Secondary title of entry.', 'stkit' )
					),
	
					'lightbox' => array(
						'name'			=> 'lightbox',
						'title'			=> __( 'Zoom', 'stkit' ),
						'description'	=> __( 'Open a full sized featured image in modal window by clicking on thumbnail.', 'stkit' )
					),
	
					'link' => array(
						'name'			=> 'link',
						'title'			=> __( 'Link', 'stkit' ),
						'description'	=> __( 'Put an URL path.', 'stkit' ),
						'tooltip'		=> __( 'e.g. http://google.com', 'stkit' )
					),
	
					'link_title' => array(
						'name'			=> 'link_title',
						'title'			=> __( 'Label', 'stkit' ),
						'description'	=> __( 'Insert a text of link.', 'stkit' ),
						'tooltip'		=> __( 'e.g. Google', 'stkit' )
					),

					'link_redirect' => array(
						'name'			=> 'link_redirect',
						'title'			=> __( 'Redirect', 'stkit' ),
						'description'	=> __( 'Open the link through redirect.', 'stkit' )
					),

					'quote' => array(
						'name'			=> 'quote',
						'title'			=> __( 'Quote', 'stkit' ),
						'description'	=> __( 'Insert a quote.', 'stkit' )
					),
	
					'status' => array(
						'name'			=> 'status',
						'title'			=> __( 'Status', 'stkit' ),
						'description'	=> __( 'Share a status.', 'stkit' )
					),
	
					'mp4' => array(
						'name'			=> 'mp4',
						'title'			=> __( 'Self hosted video', 'stkit' ),
						'description'	=> '.mp4',
						'tooltip'		=> __( 'e.g. http://site.com/file', 'stkit' )
					),
	
					'ogv' => array(
						'name'			=> 'ogv',
						'title'			=> '',
						'description'	=> '.ogv',
						'tooltip'		=> __( 'e.g. http://site.com/file', 'stkit' )
					),
	
					'webm' => array(
						'name'			=> 'webm',
						'title'			=> '',
						'description'	=> '.webm',
						'tooltip'		=> __( 'e.g. http://site.com/file', 'stkit' )
					),
	
					'video' => array(
						'name'			=> 'video',
						'title'			=> __( 'Embedded video', 'stkit' ),
						'description'	=> __( 'If you are not using self hosted video then you can include embedded code here.', 'stkit' )
					),
	
					'mp3' => array(
						'name'			=> 'mp3',
						'title'			=> __( 'Self hosted audio', 'stkit' ),
						'description'	=> '.mp3',
						'tooltip'		=> __( 'e.g. http://site.com/file', 'stkit' )
					),
	
					'ogg' => array(
						'name'			=> 'ogg',
						'title'			=> '',
						'description'	=> '.ogg',
						'tooltip'		=> __( 'e.g. http://site.com/file', 'stkit' )
					),
	
					'audio' => array(
						'name'			=> 'audio',
						'title'			=> __( 'Embedded audio', 'stkit' ),
						'description'	=> __( 'If you are not using self hosted audio then you can include embedded code here.', 'stkit' )
					),
	
					'gallery' => array(
						'name'			=> 'gallery',
						'title'			=> __( 'Gallery', 'stkit' ),
						'description'	=> '',
					),

				);

	}

	add_action( 'admin_init', 'st_MetaboxFormat' );


	/*-------------------------------------------
		1.2 - Controls
	-------------------------------------------*/

		function st_metabox_format() {

			global
				$post,
				$st_Options,
				$st_MetaboxFormat;

				echo '<div id="st_post_format" class="none">' . ( get_post_format( $post->ID ) ? get_post_format( $post->ID ) : 'standard' ) . '</div>';

			foreach ( $st_MetaboxFormat as $section ) {

				// Nonce for verification 
				echo '<input type="hidden" name="' . $section['name'] . '_nonce" value="' . wp_create_nonce( basename(__FILE__) ) . '" />';
	
				echo' <input type="hidden" name="' . $section['name'] . '_noncename" id="' . $section['name'] . '_noncename" value="' . wp_create_nonce( basename(__FILE__) ) . '" />';

				$section_value = get_post_meta( $post->ID, $section['name'] . '_value', true );


				/*--- Disable breadcrumbs -----------------------------*/

				if ( $section['name'] == 'disable_breadcrumbs' ) { ?>

					<fieldset class="panel-fieldset metabox-fieldset"><legend><?php _e( 'Common', 'stkit' ); ?></legend>

						<dl>
							<dt><?php echo $section['title']; ?></dt>
							<dd>
								<label><input type="checkbox" name="<?php echo $section['name']; ?>_value" value="1" <?php if ( $section_value == 1 ) echo 'checked'; ?> /> <?php _e( 'Hide', 'stkit' ) ?></label>
								<small><?php echo $section['description']; ?></small>
							</dd>
						</dl>

					<?php

				}


				/*--- Disable title -----------------------------*/

				if ( $section['name'] == 'disable_title' ) { ?>

						<dl id="fop_disable_title" class="fop_toggle none<?php echo !empty( $st_Options['global']['post-formats']['post-title'] ) ? ' meta-for-all-formats' : ''; ?>">
							<dt><br /><?php echo $section['title']; ?></dt>
							<dd><br />
								<label><input type="checkbox" name="<?php echo $section['name']; ?>_value" value="1" <?php if ( $section_value == 1 ) echo 'checked'; ?> /> <?php _e( 'Hide', 'stkit' ) ?></label>
								<small><?php echo $section['description']; ?></small>
							</dd>
						</dl>

					</fieldset><?php

				}


				/*--- Subtitle -----------------------------*/

				if ( $section['name'] == 'subtitle' ) { ?>

					<fieldset id="fop_subtitle" class="panel-fieldset metabox-fieldset fop_toggle none"><legend><?php echo $section['title']; ?></legend>

						<dl>
							<dt><span class="st_input_title"><?php echo $section['title']; ?></span></dt>
							<dd>
								<div class="st_input_title"><input type="text" name="<?php echo $section['name']; ?>_value" value="<?php echo $section_value; ?>" /></div>
								<small><?php echo $section['description']; ?></small>
							</dd>
						</dl>

					</fieldset><?php

				}


				/*--- Lightbox -----------------------------*/

				if ( $section['name'] == 'lightbox' && $st_Options['global']['post-formats']['image']['status'] ) { ?>

					<fieldset id="fop_lightbox" class="panel-fieldset metabox-fieldset fop_toggle none"><legend><?php _e( 'Image', 'stkit' ); ?></legend>

						<dl>
							<dt><?php echo $section['title']; ?></dt>
							<dd>
								<label><input type="checkbox" name="<?php echo $section['name']; ?>_value" value="1" <?php if ( $section_value == 1 ) echo 'checked'; ?> /> <?php _e( 'Enable', 'stkit' ) ?></label>
								<small><?php echo $section['description']; ?></small>
							</dd>
						</dl>
							
					</fieldset><?php

				}


				/*--- Link -----------------------------*/

				if ( $section['name'] == 'link' && $st_Options['global']['post-formats']['link']['status'] ) { ?>

					<fieldset id="fop_link" class="panel-fieldset metabox-fieldset fop_toggle none"><legend><?php echo $section['title']; ?></legend>

						<dl>
							<dt><span><?php echo $section['title']; ?></span></dt>
							<dd>
								<input type="text" name="<?php echo $section['name']; ?>_value" value="<?php echo $section_value; ?>" class="tooltip" title="<?php echo $section['tooltip']; ?>" />
								<small><?php echo $section['description']; ?></small><br />
							</dd>
						</dl>

					<?php

				}

				if ( $section['name'] == 'link_title' && $st_Options['global']['post-formats']['link']['status'] ) { ?>

						<dl>
							<dt><span class="st_input_title"><?php echo $section['title']; ?></span></dt>
							<dd>
								<div class="st_input_title"><input type="text" name="<?php echo $section['name']; ?>_value" value="<?php echo $section_value; ?>" class="tooltip" title="<?php echo $section['tooltip']; ?>" /></div>
								<small><?php echo $section['description']; ?></small><br />
							</dd>
						</dl>

					<?php

				}

				/*--- Link redirect -----------------------------*/

				if ( $section['name'] == 'link_redirect' && $st_Options['global']['post-formats']['link']['status'] ) { ?>

						<dl>
							<dt><?php echo $section['title']; ?></dt>
							<dd>
								<label><input type="checkbox" name="<?php echo $section['name']; ?>_value" value="1" <?php if ( $section_value == 1 ) echo 'checked'; ?> /> <?php _e( 'Enable', 'stkit' ) ?></label>
								<small><?php echo $section['description']; ?></small>
							</dd>
						</dl>

					</fieldset><?php

				}


				/*--- Quote -----------------------------*/

				if ( $section['name'] == 'quote' && $st_Options['global']['post-formats']['quote']['status'] ) { ?>

					<fieldset id="fop_quote" class="panel-fieldset metabox-fieldset fop_toggle none"><legend><?php echo $section['title']; ?></legend>

						<dl>
							<dt><span><?php echo $section['title']; ?></span></dt>
							<dd>
								<textarea name="<?php echo $section['name']; ?>_value" /><?php echo $section_value; ?></textarea>
								<small><?php echo $section['description']; ?></small>
							</dd>
						</dl>

					</fieldset><?php

				}


				/*--- Status -----------------------------*/

				if ( $section['name'] == 'status' && $st_Options['global']['post-formats']['status']['status'] ) { ?>

					<fieldset id="fop_status" class="panel-fieldset metabox-fieldset fop_toggle none"><legend><?php echo $section['title']; ?></legend>

						<dl>
							<dt><span><?php echo $section['title']; ?></span></dt>
							<dd>
								<textarea name="<?php echo $section['name']; ?>_value" /><?php echo $section_value; ?></textarea>
								<small><?php echo $section['description']; ?></small>
							</dd>
						</dl>

					</fieldset><?php

				}


				/*--- Video -----------------------------*/

				if ( $section['name'] == 'mp4' && $st_Options['global']['post-formats']['video']['status'] ) { ?>

					<fieldset id="fop_video_selfhosted" class="panel-fieldset metabox-fieldset fop_toggle none"><legend><?php echo $section['title']; ?></legend>

						<dl>
							<dt>
								<div>
									<span><?php _e( 'Note:', 'stkit' ) ?></span>
									<small><?php _e( 'You must supply an MP4 file to satisfy both HTML5 and Flash solutions. The optional OGV format is used to increase x-browser support for HTML5 browsers such as Firefox and Opera.', 'stkit' ) ?></small>
								</div>
							</dt>
							<dd>
								<input type="text" name="<?php echo $section['name']; ?>_value" value="<?php echo $section_value; ?>" class="tooltip" title="<?php echo $section['tooltip'] . $section['description']; ?>" />
								<small><?php echo $section['description']; ?></small><br />

					<?php

				}

				if ( $section['name'] == 'ogv' && $st_Options['global']['post-formats']['video']['status'] ) { ?>

								<input type="text" name="<?php echo $section['name']; ?>_value" value="<?php echo $section_value; ?>" class="tooltip" title="<?php echo $section['tooltip'] . $section['description']; ?>" />
								<small><?php echo $section['description']; ?></small><br />

					<?php

				}

				if ( $section['name'] == 'webm' && $st_Options['global']['post-formats']['video']['status'] ) { ?>

								<input type="text" name="<?php echo $section['name']; ?>_value" value="<?php echo $section_value; ?>" class="tooltip" title="<?php echo $section['tooltip'] . $section['description']; ?>" />
								<small><?php echo $section['description']; ?></small>
							</dd>
						</dl>

					</fieldset><?php

				}

				if ( $section['name'] == 'video' && $st_Options['global']['post-formats']['video']['status'] ) { ?>

					<fieldset id="fop_video_embedded" class="panel-fieldset metabox-fieldset fop_toggle none"><legend><?php echo $section['title']; ?></legend>

						<dl>
							<dt>
								<div>
									<span><?php _e( 'Note:', 'stkit' ) ?></span>
									<small><?php _e( 'This field will override the above.', 'stkit' ) ?> <?php _e( 'YouTube and Vimeo preferred.', 'stkit' ) ?></small>
								</div>
							</dt>
							<dd>
								<textarea name="<?php echo $section['name']; ?>_value" /><?php echo $section_value; ?></textarea>
								<small><?php echo $section['description']; ?></small>
							</dd>
						</dl>

					</fieldset><?php

				}


				/*--- Audio -----------------------------*/

				if ( $section['name'] == 'mp3' && $st_Options['global']['post-formats']['video']['status'] ) { ?>

					<fieldset id="fop_audio_selfhosted" class="panel-fieldset metabox-fieldset fop_toggle none"><legend><?php echo $section['title']; ?></legend>

						<dl>
							<dt>
								<div>
									<span><?php _e( 'Note:', 'stkit' ) ?></span>
									<small><?php _e( 'You must supply both MP3 and OGG files to satisfy all browsers.', 'stkit' ) ?></small>
								</div>
							</dt>
							<dd>
								<input type="text" name="<?php echo $section['name']; ?>_value" value="<?php echo $section_value; ?>" class="tooltip" title="<?php echo $section['tooltip'] . $section['description']; ?>" />
								<small><?php echo $section['description']; ?></small><br />



					<?php

				}

				if ( $section['name'] == 'ogg' && $st_Options['global']['post-formats']['video']['status'] ) { ?>

								<input type="text" name="<?php echo $section['name']; ?>_value" value="<?php echo $section_value; ?>" class="tooltip" title="<?php echo $section['tooltip'] . $section['description']; ?>" />
								<small><?php echo $section['description']; ?></small>
							</dd>
						</dl>

					</fieldset><?php

				}

				if ( $section['name'] == 'audio' && $st_Options['global']['post-formats']['audio']['status'] ) { ?>

					<fieldset id="fop_audio_embedded" class="panel-fieldset metabox-fieldset fop_toggle none"><legend><?php echo $section['title']; ?></legend>

						<dl>
							<dt>
								<div>
									<span><?php _e( 'Note:', 'stkit' ) ?></span>
									<small><?php _e( 'This field will override the above.', 'stkit' ) ?></small>
								</div>
							</dt>
							<dd>
								<textarea name="<?php echo $section['name']; ?>_value" /><?php echo $section_value; ?></textarea>
								<small><?php echo $section['description']; ?></small>
							</dd>
						</dl>

					</fieldset><?php

				}


				/*--- Gallery -----------------------------*/

				if ( $section['name'] == 'gallery' && $st_Options['global']['post-formats']['gallery']['status'] ) { ?>

					<fieldset id="fop_gallery" class="panel-fieldset metabox-fieldset fop_toggle none"><legend><?php echo $section['title']; ?></legend>

						<dl>
							<dt>
								<span><?php echo $section['title']; ?></span>
							</dt>
							<dd>
								<input type="hidden" name="<?php echo $section['name']; ?>_value" value='<?php echo $section_value; ?>' id="st_gallery" style="width: 50%;" />
								<input type="button" value="<?php _e( 'Create Gallery', 'stkit' ) ?>" data-create="<?php _e( 'Create Gallery', 'stkit' ) ?>" data-edit="<?php _e( 'Edit Gallery', 'stkit' ) ?>" class="button" id="st_gallery_button">
								<ul id="st_gallery_thumbs" class="st_metabox_thumbs st-ajax-thumbs" <?php if ( $section_value ) echo 'data-ids="' . $section_value . '"'; ?>></ul>
								<small><a id="st_gallery_delete" <?php if ( !$section_value ) echo 'class="none"' ?> href="#"><?php _e( 'Delete Gallery', 'stkit' ) ?></a></small>
							</dd>
						</dl>

					</fieldset><?php

				}


			}
	
		}


	/*-------------------------------------------
		1.3 - Register metabox
	-------------------------------------------*/

		function st_create_metabox_format() {

			global
				$st_MetaboxFormat;

				if ( function_exists('add_meta_box') ) :
	
					if ( wp_get_current_user()->has_cap('edit_posts') ) :
	
						add_meta_box( 'st-metabox-format', __( 'Format Options', 'stkit' ), 'st_metabox_format', 'post', 'normal', 'high' );
	
					endif;
	
				endif;

		}

		add_action( 'admin_menu', 'st_create_metabox_format' );


	/*-------------------------------------------
		1.4 - Save data
	-------------------------------------------*/

		function st_save_post_formatdata( $post_id ) {
		
			global
				$post,
				$st_MetaboxFormat,
				$st_Kit;

				if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
					return $post_id;

				// for $st_MetaboxFormat
				foreach ( $st_MetaboxFormat as $section ) :

					// verify nonce
					if ( !isset( $_POST[$section['name'] . '_nonce'] ) || !wp_verify_nonce( $_POST[$section['name'] . '_nonce'], basename(__FILE__) ) )
						return $post_id; 

					// verify
					if ( !empty( $_POST['post_type'] ) && $_POST['post_type'] == 'page' ) :

						if ( !current_user_can( 'edit_page', $post_id ) ) :

							return $post_id;

						endif;

					else :

						if ( !current_user_can( 'edit_post', $post_id ) ) :

							return $post_id;

						endif;

					endif;


					$data = wp_kses( !empty( $_POST[$section['name'] . '_value'] ) ? $_POST[$section['name'] . '_value'] : '', $st_Kit['tags_allowed'] );


					if ( get_post_meta( $post_id, $section['name'] . '_value') == '' ) :

						add_post_meta( $post_id, $section['name'] . '_value', $data, true );

					elseif ( $data != get_post_meta($post_id, $section['name'] . '_value', true ) ) :

						update_post_meta( $post_id, $section['name'] . '_value', $data );

					elseif( $data == '' ) :

						delete_post_meta( $post_id, $section['name'] . '_value', get_post_meta( $post_id, $section['name'] . '_value', true ) );

					endif;


				endforeach;

		}

		add_action( 'save_post', 'st_save_post_formatdata' );


?>