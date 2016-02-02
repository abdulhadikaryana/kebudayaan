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

	function st_MetaboxCtpFormat() {

		global
			$st_MetaboxCtpFormat;

			$st_MetaboxCtpFormat = 
		
				array(

					'format' => array(
						'name'			=> 'format',
						'title'			=> __( 'Format', 'stkit' ),
						'description'	=> ''
					),

					'mp4' => array(
						'name'			=> 'mp4',
						'title'			=> __( 'Self hosted video', 'stkit' ),
						'description'	=> '.mp4',
						'tooltip'		=> __( 'e.g. http://site.com/file', 'stkit' ),
					),
	
					'ogv' => array(
						'name'			=> 'ogv',
						'title'			=> '',
						'description'	=> '.ogv',
						'tooltip'		=> __( 'e.g. http://site.com/file', 'stkit' ),
					),
	
					'webm' => array(
						'name'			=> 'webm',
						'title'			=> '',
						'description'	=> '.webm',
						'tooltip'		=> __( 'e.g. http://site.com/file', 'stkit' ),
					),
	
					'video' => array(
						'name'			=> 'video',
						'title'			=> __( 'Embedded video', 'stkit' ),
						'description'	=> __( 'If you are not using self hosted video then you can include embedded code here.', 'stkit' ),
					),
	
					'mp3' => array(
						'name'			=> 'mp3',
						'title'			=> __( 'Self hosted audio', 'stkit' ),
						'description'	=> '.mp3',
						'tooltip'		=> __( 'e.g. http://site.com/file', 'stkit' ),
					),
	
					'ogg' => array(
						'name'			=> 'ogg',
						'title'			=> '',
						'description'	=> '.ogg',
						'tooltip'		=> __( 'e.g. http://site.com/file', 'stkit' ),
					),
	
					'audio' => array(
						'name'			=> 'audio',
						'title'			=> __( 'Embedded audio', 'stkit' ),
						'description'	=> __( 'If you are not using self hosted audio then you can include embedded code here.', 'stkit' ),
					),
	
					'gallery' => array(
						'name'			=> 'gallery',
						'title'			=> __( 'Gallery', 'stkit' ),
						'description'	=> '',
					),

					'bg-color' => array(
						'name'			=> 'bg-color',
						'title'			=> __( 'Color', 'stkit' ),
						'description'	=> __( 'Select a color of project.', 'stkit' ),
					),

					'bg-image' => array(
						'name'			=> 'bg-image',
						'title'			=> __( 'Image', 'stkit' ),
						'description'	=> '',
					),

				);

	}

	add_action( 'admin_init', 'st_MetaboxCtpFormat' );


	/*-------------------------------------------
		1.2 - Controls
	-------------------------------------------*/

		function st_metabox_ctp_format() {

			global
				$post,
				$st_Options,
				$st_MetaboxCtpFormat;

			foreach ( $st_MetaboxCtpFormat as $section ) {

				// Nonce for verification 
				echo '<input type="hidden" name="' . $section['name'] . '_nonce" value="' . wp_create_nonce( basename(__FILE__) ) . '" />';
	
				echo' <input type="hidden" name="' . $section['name'] . '_noncename" id="' . $section['name'] . '_noncename" value="' . wp_create_nonce( basename(__FILE__) ) . '" />';

				$section_value = get_post_meta( $post->ID, $section['name'] . '_value', true );


				/*--- Selector -----------------------------*/

				if ( $section['name'] == 'format' ) { ?>

					<fieldset class="panel-fieldset metabox-fieldset"><legend><?php echo $section['title']; ?></legend>
	
						<dl>
							<dt>
								<?php echo $section['title']; ?>
							</dt>
							<dd>

								<?php

									$format = $section_value ? $section_value : 'gallery';

									echo '<div id="st_ctp_format" class="none">' . $format . '</div>';

								?>

								<div id="post-formats-select">

									<input type="radio" value="gallery" id="ctp-format-gallery" class="ctp-format" name="<?php echo $section['name']; ?>_value">
										<label class="post-format-icon post-format-gallery" for="ctp-format-gallery">Gallery</label><br />
	
									<input type="radio" value="audio" id="ctp-format-audio" class="ctp-format" name="<?php echo $section['name']; ?>_value">
										<label class="post-format-icon post-format-audio" for="ctp-format-audio">Audio</label><br />
	
									<input type="radio" value="video" id="ctp-format-video" class="ctp-format" name="<?php echo $section['name']; ?>_value">
										<label class="post-format-icon post-format-video" for="ctp-format-video">Video</label>

								</div>
							</dd>
						</dl>
	
					</fieldset><?php

				}


				/*--- Video -----------------------------*/

				if ( $section['name'] == 'mp4' ) { ?>

					<fieldset id="fot_video_selfhosted" class="panel-fieldset metabox-fieldset fot_toggle none"><legend><?php echo $section['title']; ?></legend>

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

				if ( $section['name'] == 'ogv' ) { ?>

								<input type="text" name="<?php echo $section['name']; ?>_value" value="<?php echo $section_value; ?>" class="tooltip" title="<?php echo $section['tooltip'] . $section['description']; ?>" />
								<small><?php echo $section['description']; ?></small><br />

					<?php

				}

				if ( $section['name'] == 'webm' ) { ?>

								<input type="text" name="<?php echo $section['name']; ?>_value" value="<?php echo $section_value; ?>" class="tooltip" title="<?php echo $section['tooltip'] . $section['description']; ?>" />
								<small><?php echo $section['description']; ?></small>
							</dd>
						</dl>

					</fieldset><?php

				}

				if ( $section['name'] == 'video' ) { ?>

					<fieldset id="fot_video_embedded" class="panel-fieldset metabox-fieldset fot_toggle none"><legend><?php echo $section['title']; ?></legend>

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

				if ( $section['name'] == 'mp3' ) { ?>

					<fieldset id="fot_audio_selfhosted" class="panel-fieldset metabox-fieldset fot_toggle none"><legend><?php echo $section['title']; ?></legend>

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

				if ( $section['name'] == 'ogg' ) { ?>

								<input type="text" name="<?php echo $section['name']; ?>_value" value="<?php echo $section_value; ?>" class="tooltip" title="<?php echo $section['tooltip'] . $section['description']; ?>" />
								<small><?php echo $section['description']; ?></small>
							</dd>
						</dl>

					</fieldset><?php

				}

				if ( $section['name'] == 'audio' ) { ?>

					<fieldset id="fot_audio_embedded" class="panel-fieldset metabox-fieldset fot_toggle none"><legend><?php echo $section['title']; ?></legend>

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

				if ( $section['name'] == 'gallery' ) { ?>

					<fieldset id="fot_gallery" class="panel-fieldset metabox-fieldset fot_toggle none"><legend><?php echo $section['title']; ?></legend>

						<dl>
							<dt>
								<span><?php echo $section['title']; ?></span>
							</dt>
							<dd>
								<input type="hidden" name="<?php echo $section['name']; ?>_value" value='<?php echo $section_value; ?>' id="st_gallery" />
								<input type="button" value="<?php _e( 'Create Gallery', 'stkit' ) ?>" data-create="<?php _e( 'Create Gallery', 'stkit' ) ?>" data-edit="<?php _e( 'Edit Gallery', 'stkit' ) ?>" class="button" id="st_gallery_button">
								<ul id="st_gallery_thumbs" class="st_metabox_thumbs st-ajax-thumbs" <?php if ( $section_value ) echo 'data-ids="' . $section_value . '"'; ?>></ul>
								<small><a id="st_gallery_delete" <?php if ( !$section_value ) echo 'class="none"' ?> href="#"><?php _e( 'Delete Gallery', 'stkit' ) ?></a></small>
							</dd>
						</dl>

					</fieldset><?php

				}


				/*--- Background Color -----------------------------*/

				if ( $section['name'] == 'bg-color' ) {

					$color = esc_html( !empty( $section_value ) ? $section_value : '' ); ?>

					<fieldset class="panel-fieldset metabox-fieldset"><legend><?php _e( 'Background', 'stkit' ); ?></legend>
	
						<dl>
							<dt>
								<span><?php echo $section['title']; ?></span>
							</dt>
							<dd>
								<div class="color-preview" id="color-primary-preview" style="background-color: #<?php echo $color; ?>;">&nbsp;</div>
								<input type="text" name="<?php echo $section['name']; ?>_value" id="color-primary" class="input-short" value='<?php echo $color; ?>' placeholder="<?php _e( 'Default', 'stkit' ); ?>" />
								<small><?php echo $section['description']; ?></small><br />
							</dd>
						</dl>
	
					<?php

				}


				/*--- Background Image -----------------------------*/

				if ( $section['name'] == 'bg-image' ) { ?>
	
						<dl>
							<dt>
								<span><?php echo $section['title']; ?></span>
							</dt>
							<dd>
								<input type="hidden" name="<?php echo $section['name']; ?>_value" value='<?php echo $section_value; ?>' id="st_background" />
								<input type="button" value="<?php _e( 'Select Image', 'stkit' ) ?>" class="button" id="st_background_button">
								<ul id="st_background_thumb" class="st_metabox_thumbs st-ajax-thumbs" <?php if ( $section_value ) echo 'data-ids="' . $section_value . '"'; ?>></ul>
								<small><a id="st_background_delete" <?php if ( !$section_value ) echo 'class="none"' ?> href="#"><?php _e( 'Delete Image', 'stkit' ) ?></a></small>
							</dd>
						</dl>
	
					</fieldset><?php

				}


			}
	
		}


	/*-------------------------------------------
		1.3 - Register metabox
	-------------------------------------------*/

		function st_create_metabox_ctp_format() {

			global
				$st_MetaboxCtpFormat,
				$st_Options,
				$st_Settings;

				$st_post = !empty( $st_Settings['ctp_post'] ) ? $st_Settings['ctp_post'] : $st_Options['ctp']['post'];

				if ( function_exists('add_meta_box') ) :
	
					if ( wp_get_current_user()->has_cap('edit_posts') ) :
	
						add_meta_box( 'st-metabox-ctp-format', __( 'Project Options', 'stkit' ), 'st_metabox_ctp_format', $st_post, 'normal', 'high' );
	
					endif;
	
				endif;

		}

		add_action( 'admin_menu', 'st_create_metabox_ctp_format' );


	/*-------------------------------------------
		1.4 - Save data
	-------------------------------------------*/

		function st_save_post_ctp_formatdata( $post_id ) {
		
			global
				$st_Options,
				$post,
				$st_MetaboxCtpFormat,
				$st_Kit;

				if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
					return $post_id;

				// for $st_MetaboxCtpFormat
				foreach ( $st_MetaboxCtpFormat as $section ) :

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


					// Save CTP format
					if ( $section['name'] == 'format' ) {

						$st_['st_ctp_format'] = $st_Options['ctp']['ctp-formats']['formats']['tag'];

						wp_set_object_terms( $post_id, $data, $st_['st_ctp_format'] );

					}


				endforeach;

		}

		add_action( 'save_post', 'st_save_post_ctp_formatdata' );


?>