<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<!--

	1 - GENERAL

		1.1 - Layout

	2 - HEADER

		n/a

	3 - FOOTER

		3.1 - Footer

	4 - SOCIAL

		4.1 - Social

-->

<?php

	// Primary
	$st_['primary'] = !empty( $st_Settings['color-primary'] ) ? esc_html( $st_Settings['color-primary'] ) : $st_Options['panel']['style']['general']['colors']['primary']['hex'];

	// Secondary
	$st_['secondary'] = !empty( $st_Settings['color-secondary'] ) ? esc_html( $st_Settings['color-secondary'] ) : $st_Options['panel']['style']['general']['colors']['secondary']['hex'];

?>

<style>

	html {
		background: #F9F9F9;
	}

	#panelHeader {
		background: #<?php echo $st_['primary'] ?>;
	}

	#panelSaveButton {
		background-color: #<?php echo $st_['secondary'] ?>;
	}

	.panel-fieldset legend {
		color: #<?php echo $st_['secondary'] ?>;
	}

</style>

<form action="" enctype="multipart/form-data" method="post">

	<input type="hidden" id="st_layout_settings_action" name="st_layout_settings_action" value="save">
	<input type="hidden" name="tab_st_layout_settings" value="<?php echo esc_html( !empty( $st_Settings['tab_st_layout_settings'] ) ? $st_Settings['tab_st_layout_settings'] : '' ); ?>" id="input-panelTabsNav" />


	
	<div id="themePanel">



		<div id="panelHeader">
	
			<div id="panelTitle"><?php _e( 'Layout Settings', 'stkit' ); echo ' <span>ST Kit v.' . $st_Kit['version']; ?></span></div>
	
			<input type="submit" id="panelSaveButton" value="<?php esc_attr_e( 'Save changes', 'stkit' )?>" name="cp_save" />

			<div id="messageUpdated"><?php echo $st_['message']; ?></div>

			<div class="clear"><!-- --></div>
	
			<ul id="panelTabsNav">
				<?php

					// General nav tab
					if ( $st_Options['panel']['layout']['general']['status'] )
						echo '<li><a href="#general">' . __( 'General', 'stkit' ) . '</a></li>';

					// Header nav tab
					if ( $st_Options['panel']['layout']['header']['status'] )
						echo '<li><a href="#st_header">' . __( 'Header', 'stkit' ) . '</a></li>'; // #st_header

					// Footer nav tab
					if ( $st_Options['panel']['layout']['footer']['status'] )
						echo '<li><a href="#st_footer">' . __( 'Footer', 'stkit' ) . '</a></li>'; // #st_footer

					// Social
					if ( $st_Options['panel']['layout']['social']['status'] )
						echo '<li><a href="#social">' . __( 'Social', 'stkit' ) . '</a></li>';


				?>
			</ul>
	
			<div class="clear"><!-- --></div>
	
		</div>


	
		<!--=============================================
		
			G E N E R A L
			A page with general settings
		
		==============================================-->

		<?php

			// General tab
			if ( $st_Options['panel']['layout']['general']['status'] ) {	?>

				<div id="general" class="panelTab">
		
		
					<!-------------------------------------------
						1.1 - Layout
					-------------------------------------------->

					<fieldset class="panel-fieldset"><legend><?php _e( 'Layout', 'stkit' ) ?></legend>

						<?php // Layout
							if ( $st_Options['panel']['layout']['general']['layout_type'] ) { ?>
	
								<dl>
									<dt>
										<?php _e( 'Type', 'stkit' ) ?>
									</dt>
									<dd>
				
										<label><input type="radio" value="responsive" name="layout_type"
										<?php if ( !empty( $st_Settings['layout_type'] ) && $st_Settings['layout_type'] == 'responsive' || !isset( $st_Settings['layout_type'] ) ) echo 'checked="checked"'; ?> /> <?php _e( 'Responsive', 'stkit' ) ?></label>
	
										<label><input type="radio" value="standard" name="layout_type"
										<?php if ( !empty( $st_Settings['layout_type'] ) && $st_Settings['layout_type'] == 'standard' ) echo 'checked="checked"'; ?> /> <?php _e( 'Classic', 'stkit' ) ?></label>
				
									</dd>
								</dl><?php
	
							}
						?>

						<?php // Design
							if ( !empty( $st_Options['panel']['layout']['general']['layout_design'] ) ) { ?>
	
								<dl>
									<dt>
										<?php _e( 'Design', 'stkit' ) ?>
									</dt>
									<dd>
				
										<label><input type="radio" value="wide" name="layout_design"
										<?php if ( !empty( $st_Settings['layout_design'] ) && $st_Settings['layout_design'] == 'wide' || !isset( $st_Settings['layout_design'] ) ) echo 'checked="checked"'; ?> /> <?php _e( 'Wide', 'stkit' ) ?></label>
	
										<label><input type="radio" value="boxed" name="layout_design"
										<?php if ( !empty( $st_Settings['layout_design'] ) && $st_Settings['layout_design'] == 'boxed' ) echo 'checked="checked"'; ?> /> <?php _e( 'Boxed', 'stkit' ) ?></label>
				
									</dd>
								</dl><?php
	
							}
						?>

					</fieldset>

		
				</div><!-- #general --><?php

			}

		?>



		<!--=============================================
		
			H E A D E R
			A page with header settings
		
		==============================================-->

		<?php

			// Header tab
			if ( $st_Options['panel']['layout']['header']['status'] ) {}

		?>



		<!--=============================================
		
			F O O T E R
			A page with footer settings
		
		==============================================-->

		<?php

			// Footer tab
			if ( $st_Options['panel']['layout']['footer']['status'] ) {	?>

				<div id="st_footer" class="panelTab">
		
		
					<!-------------------------------------------
						3.1 - Footer
					-------------------------------------------->

					<?php // Footer
						if ( $st_Options['panel']['layout']['footer']['scheme']['status'] ) { ?>

							<fieldset class="panel-fieldset"><legend><?php _e( 'Footer', 'stkit' ) ?></legend>
				
								<dl>
									<dt>
										<span><?php _e( 'Scheme', 'stkit' ) ?></span>
									</dt>
									<dd>

										<?php

											$st_['array'] = array('1','2','3','4','5','6','none');

											foreach ( $st_['array'] as $key ) {

												$st_['checked'] = '';

												// Select the First in case database is empty
												if ( !isset( $st_Settings['footer_sidebars'] ) && $key == $st_Options['panel']['layout']['footer']['scheme']['default'] )
													$st_['checked'] = 'checked="checked"';

												// Select requred scheme
												if ( !empty( $st_Settings['footer_sidebars'] ) && $st_Settings['footer_sidebars'] == $key )
													$st_['checked'] = 'checked="checked"'; ?>

												<div class="tmpl_radio">
													<label class="lable-img" for="footer_sidebars_<?php echo $key ?>">
														<img src="<?php echo plugins_url() ?>/stkit//assets/images/schemes/sidebar_footer/<?php echo $key ?>.png" width="50" height="40">
													</label>
													<input type="radio" name="footer_sidebars" value="<?php echo $key ?>" id="footer_sidebars_<?php echo $key ?>" <?php echo $st_['checked'] ?> />
												</div><?php

											}

										?>
										<small><?php _e(' Select a scheme of footer sidebars.', 'stkit' ) ?></small>

									</dd>
								</dl>

							</fieldset><?php

						}
					?>

		
				</div><!-- #general --><?php

			}

		?>



		<!--=============================================
		
			S O C I A L
			A social icons on header or footer
		
		==============================================-->

		<?php

			// Social tab
			if ( $st_Options['panel']['layout']['social']['status'] ) {	?>

				<div id="social" class="panelTab">

		
					<!-------------------------------------------
						4.1 - Social
					-------------------------------------------->

					<fieldset class="panel-fieldset"><legend><?php _e( 'Social', 'stkit' ) ?></legend><?php

						if ( !isset($st_Options['panel']['layout']['social']['icons']) || $st_Options['panel']['layout']['social']['icons'] != false ) { ?>

							<dl>
								<dt>
									<?php _e( 'Icons', 'stkit' ) ?>
								</dt>
								<dd>
									<label>
										<input type="checkbox" name="lifestream" value="yes" <?php if ( !empty( $st_Settings['lifestream'] ) && $st_Settings['lifestream'] == 'yes' ) echo 'checked'; ?> /> 
										<?php _e( 'Display', 'stkit' ) ?>
									</label>
									<small><?php _e( 'Display social icons.', 'stkit' ) ?></small>
								</dd>
							</dl><?php

						} ?>

						<dl>
							<dt>
								<span><?php _e( 'URLs', 'stkit' ) ?></span>
							</dt>
							<dd>
								<?php
									foreach ( $st_Options['networks'] as $key ) {

										$st_['icon'] = substr( $key, 5 );

										$st_['value'] = !empty( $st_Settings[$key] ) ? $st_Settings[$key] : '';

										echo "\n" . '<input type="text" class="input-social-icon tooltip" title="' . $st_['icon'] . '" name="' . $key . '" value="' . $st_['value'] . '" class="input ' . $key . '" size="" style="background-image: url(' . plugins_url() . '/stkit/assets/images/icons/18/social/color/' . $st_['icon'] . '.png);" /> ';

									}
								?>
								<small><?php _e( 'Enter URL paths to your network profiles.', 'stkit' ) ?></small>
							</dd>
						</dl>

						<dl>
							<dt>
								<span><?php _e( 'Custom Icons', 'stkit' ) ?></span>
							</dt>
							<dd>
								<textarea name="lifestream_custom" /><?php echo esc_textarea( !empty( $st_Settings['lifestream_custom'] ) ? $st_Settings['lifestream_custom'] : '' ); ?></textarea>
								<small>
									<?php _e( 'You also can set a custom icons, counters etc. Shortcodes allowed.', 'stkit' ) ?><br/>
									<?php _e( 'Draft', 'stkit' ) ?>: <code>&lt;a rel="nofollow" class="icon-custom" target="_blank" href="#">&lt;img src="ICON-PATH.PNG" title="Hello World!" class="tooltip" alt="" />&lt;/a></code>
								</small>
							</dd>
						</dl>

					</fieldset>


				</div><!-- #general --><?php

			}

		?>



	</div><!-- #themePanel -->



</form>