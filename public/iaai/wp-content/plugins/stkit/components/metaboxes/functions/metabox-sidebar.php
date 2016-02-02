<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	1 - METABOX: SIDEBAR

		1.1 - Array
		1.2 - Controls
		1.3 - Register metabox
		1.4 - Save data

*/

/*===============================================

 	M E T A B O X :   S I D E B A R
	Allow to set a custom sidebar for post

===============================================*/

	/*-------------------------------------------
		1.1 - Array
	-------------------------------------------*/

	function st_MetaboxSidebar() {

		global
			$st_MetaboxSidebar;

			$st_MetaboxSidebar = 
		
				array(
		
					'sidebar' => array(
						'name'			=> 'sidebar',
						'title'			=> __( 'Name', 'stkit' ),
						'description'	=> __( 'Select a sidebar or <a href="admin.php?page=st-major-settings#sidebar">create new one</a>.', 'stkit' )
					),
	
					'sidebar_position' => array(
						'name'			=> 'sidebar_position',
						'title'			=> __( 'Position', 'stkit' ),
						'description'	=> __( 'Choose the position of sidebar.', 'stkit' )
					)
	
				);

	}

	add_action( 'admin_init', 'st_MetaboxSidebar' );


	/*-------------------------------------------
		1.2 - Controls
	-------------------------------------------*/

		function st_metabox_sidebar() {


			global
				$post,
				$st_MetaboxSidebar,
				$st_Options;

				$st_Settings = get_option( $st_Options['general']['name'] . 'settings' );
		
				$qty = !empty( $st_Settings['sidebar_qty'] ) ? $st_Settings['sidebar_qty'] : 0;

			foreach ( $st_MetaboxSidebar as $section ) {

				// Nonce for verification  
				echo '<input type="hidden" name="' . $section['name'] . '_nonce" value="' . wp_create_nonce( basename(__FILE__) ) . '" />';
	
				echo' <input type="hidden" name="' . $section['name'] . '_noncename" id="' . $section['name'] . '_noncename" value="' . wp_create_nonce( basename(__FILE__) ) . '" />';

				$section_value = get_post_meta( $post->ID, $section['name'] . '_value', true );


				/*--- Sidebar Name -----------------------------*/

				if ( $section['name'] == 'sidebar' ) { ?>

					<fieldset class="panel-fieldset metabox-fieldset"><legend><?php echo $section['title']; ?></legend>

						<select name="<?php echo $section['name']; ?>_value" id="<?php echo $section['name']; ?>_value">
							<option value="Default Sidebar"<?php if ( $section_value == "Default Sidebar" ) echo 'selected'; ?>><?php _e( 'Default Sidebar', 'stkit' ) ?>&nbsp;</option><?php
							if ( $st_Options['sidebars']['projects'] ) { ?>
								<option value="Projects Sidebar"<?php if ( $section_value == "Projects Sidebar" ) echo 'selected'; ?>><?php _e( 'Projects Sidebar', 'stkit' ) ?>&nbsp;</option><?php
							}
								for ( $s = 1; $s < ($qty + 1); $s++ ) {

									$selected = $section_value == 'Custom bar ' . $s ? 'selected' : '';

									echo '<option value="Custom bar ' . $s . '"' . $selected . '>' . __( 'Custom bar', 'stkit' ) . ' ' . $s . '</option>';

								};
							?>
						</select>
						<small><?php echo $section['description']; ?></small>

					</fieldset><?php

				}


				/*--- Sidebar Position -----------------------------*/

				if ( $section['name'] == 'sidebar_position' ) { ?>

					<fieldset class="panel-fieldset metabox-fieldset"><legend><?php echo $section['title']; ?></legend>
	
						<div class="tmpl_radio<?php if ( $section_value == 'left' ) echo ' tmpl_selected'; ?>">
	
							<label class="lable-img" for="sidebar_left"><img src="<?php echo plugins_url(); ?>/stkit/components/metaboxes/assets/images/schemes/left.png" width="50" height="40"></label>
							<input type="radio" value="left" name="<?php echo $section['name']; ?>_value" id="sidebar_left" <?php if ( $section_value == 'left' ) echo 'checked="checked"'; ?> />
							<label for="sidebar_left"><?php _e( 'L', 'stkit' ) ?></label>
	
						</div>
	
						<div class="tmpl_radio<?php if ( $section_value == 'none' ) echo ' tmpl_selected'; ?>">
	
							<label class="lable-img" for="sidebar_none"><img src="<?php echo plugins_url(); ?>/stkit/components/metaboxes/assets/images/schemes/none.png" width="50" height="40"></label>
							<input type="radio" value="none" name="<?php echo $section['name']; ?>_value" id="sidebar_none" <?php if ( $section_value == 'none' ) echo 'checked="checked"'; ?> />
							<label for="sidebar_none"><?php _e( 'n/a', 'stkit' ) ?></label>
	
						</div>
	
						<div class="tmpl_radio last<?php if ( !$section_value || $section_value == 'right' ) echo ' tmpl_selected'; ?>">
	
							<label class="lable-img" for="sidebar_right"><img src="<?php echo plugins_url(); ?>/stkit/components/metaboxes/assets/images/schemes/right.png" width="50" height="40"></label>
							<input type="radio" value="right" name="<?php echo $section['name']; ?>_value" id="sidebar_right" <?php if ( !$section_value || $section_value == 'right' ) echo 'checked="checked"'; ?> />
							<label for="sidebar_right"><?php _e( 'R', 'stkit' ) ?></label>
	
						</div>
	
						<div class="clear"><!-- --></div>
	
						<small><?php echo $section['description']; ?></small>
	
					</fieldset><?php

				}


			}


		}


	/*-------------------------------------------
		1.3 - Register metabox
	-------------------------------------------*/

		function create_sidebar_meta_box() {

			global
				$st_MetaboxSidebar,
				$st_Options,
				$st_Settings;

				$st_post = !empty( $st_Settings['ctp_post'] ) ? $st_Settings['ctp_post'] : $st_Options['ctp']['post'];

				if ( function_exists( 'add_meta_box' ) ) {
	
					if ( wp_get_current_user()->has_cap( 'edit_pages' ) )
						add_meta_box( 'st-metabox-sidebar', __( 'Sidebar', 'stkit' ), 'st_metabox_sidebar', 'page', 'side', 'default' );

					if ( wp_get_current_user()->has_cap('edit_posts') ) {
						add_meta_box( 'st-metabox-sidebar', __( 'Sidebar', 'stkit' ), 'st_metabox_sidebar', 'post', 'side', 'default' );
						add_meta_box( 'st-metabox-sidebar', __( 'Sidebar', 'stkit' ), 'st_metabox_sidebar', $st_post, 'side', 'default' );
					}
	
				}

		}

		add_action('admin_menu', 'create_sidebar_meta_box');


	/*-------------------------------------------
		1.4 - Save data
	-------------------------------------------*/

		function st_save_sidebar_postdata( $post_id ) {
		
			global
				$post,
				$st_MetaboxSidebar;

				if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
					return $post_id;

				// for $st_MetaboxSidebar
				foreach ( $st_MetaboxSidebar as $section ) :

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
		
		add_action( 'save_post', 'st_save_sidebar_postdata' );


?>