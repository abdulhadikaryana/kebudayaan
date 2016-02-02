<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	1 - METABOX: POST OPTIONS

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

	function st_MetaboxPost() {

		global
			$st_MetaboxPost;

			$st_MetaboxPost = 
		
				array(

					'disable_breadcrumbs' => array(
						'name'			=> 'disable_breadcrumbs',
						'title'			=> __( 'Do not show breadcrumbs', 'stkit' ),
						'description'	=> ''
					),

					'disable_title' => array(
						'name'			=> 'disable_title',
						'title'			=> __( 'Do not show title', 'stkit' ),
						'description'	=> ''
					),

					'subtitle' => array(
						'name'			=> 'subtitle',
						'title'			=> __( 'Subtitle', 'stkit' ),
						'description'	=> __( 'Secondary title of entry.', 'stkit' )
					),
	
				);

	}

	add_action( 'admin_init', 'st_MetaboxPost' );


	/*-------------------------------------------
		1.2 - Controls
	-------------------------------------------*/

		function st_metabox_post() {

			global
				$post,
				$st_MetaboxPost;

			foreach ( $st_MetaboxPost as $section ) {

				// Nonce for verification  
				echo '<input type="hidden" name="' . $section['name'] . '_nonce" value="' . wp_create_nonce( basename(__FILE__) ) . '" />';
	
				echo' <input type="hidden" name="' . $section['name'] . '_noncename" id="' . $section['name'] . '_noncename" value="' . wp_create_nonce( basename(__FILE__) ) . '" />';

				$section_value = get_post_meta( $post->ID, $section['name'] . '_value', true );


				/*--- Disable breadcrumbs -----------------------------*/

				if ( $section['name'] == 'disable_breadcrumbs' ) { ?>

					<fieldset class="panel-fieldset metabox-fieldset"><legend><?php _e( 'Options', 'stkit' ); ?></legend>

						<label><input type="checkbox" name="<?php echo $section['name']; ?>_value" value="1" <?php if ( $section_value == 1 ) echo 'checked'; ?> /> <?php echo $section['title']; ?></label><br />
							
					<?php

				}


				/*--- Disable title -----------------------------*/

				if ( $section['name'] == 'disable_title' ) { ?>

						<label><input type="checkbox" name="<?php echo $section['name']; ?>_value" value="1" <?php if ( $section_value == 1 ) echo 'checked'; ?> /> <?php echo $section['title']; ?></label>
							
					</fieldset><?php

				}


				/*--- Subtitle -----------------------------*/

				if ( $section['name'] == 'subtitle' ) { ?>

					<fieldset class="panel-fieldset metabox-fieldset"><legend><?php echo $section['title']; ?></legend>

						<div class="st_input_title">
							<input type="text" name="<?php echo $section['name']; ?>_value" value="<?php echo $section_value; ?>" />
						</div>
						<small><?php echo $section['description']; ?></small>

					</fieldset><?php

				}

			}
	
		}


	/*-------------------------------------------
		1.3 - Register metabox
	-------------------------------------------*/

		function st_create_metabox_post() {

			global
				$st_MetaboxPost,
				$st_Options,
				$st_Settings;

				$st_post = !empty( $st_Settings['ctp_post'] ) ? $st_Settings['ctp_post'] : $st_Options['ctp']['post'];

				if ( function_exists('add_meta_box') ) {
	
					if ( wp_get_current_user()->has_cap('edit_pages') )
						add_meta_box( 'st-metabox-post', __( 'Page Options', 'stkit' ), 'st_metabox_post', 'page', 'normal', 'default' );

					if ( wp_get_current_user()->has_cap('edit_posts') )
						add_meta_box( 'st-metabox-post', __( 'Page Options', 'stkit' ), 'st_metabox_post', $st_post, 'normal', 'default' );

				}

		}

		add_action('admin_menu', 'st_create_metabox_post');


	/*-------------------------------------------
		1.4 - Save data
	-------------------------------------------*/

		function st_save_post_postdata( $post_id ) {
		
			global
				$post,
				$st_MetaboxPost;

				if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
					return $post_id;

				// for $st_MetaboxPost
				foreach ( $st_MetaboxPost as $section ) :

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


					$data = !empty( $_POST[$section['name'] . '_value'] ) ? esc_attr( $_POST[$section['name'] . '_value'] ) : '';


					if ( get_post_meta( $post_id, $section['name'] . '_value') == '' ) :

						add_post_meta( $post_id, $section['name'] . '_value', $data, true );

					elseif ( $data != get_post_meta($post_id, $section['name'] . '_value', true ) ) :

						update_post_meta( $post_id, $section['name'] . '_value', $data );

					elseif( $data == '' ) :

						delete_post_meta( $post_id, $section['name'] . '_value', get_post_meta( $post_id, $section['name'] . '_value', true ) );

					endif;


				endforeach;

		}

		add_action( 'save_post', 'st_save_post_postdata' );


?>