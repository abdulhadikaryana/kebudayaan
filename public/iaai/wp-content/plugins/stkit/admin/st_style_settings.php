<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<!--

	1 - GENERAL

		1.1 - General
		1.2 - Colors
			- Primary
			- Secondary

	2 - CUSTOM

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

	<input type="hidden" id="st_style_settings_action" name="st_style_settings_action" value="save">
	<input type="hidden" name="tab_st_style_settings" value="<?php echo esc_html( !empty( $st_Settings['tab_st_style_settings'] ) ? $st_Settings['tab_st_style_settings'] : '' ); ?>" id="input-panelTabsNav" />


	
	<div id="themePanel">



		<div id="panelHeader">
	
			<div id="panelTitle"><?php _e( 'Style Settings', 'stkit' ); echo ' <span>ST Kit v.' . $st_Kit['version']; ?></span></div>
	
			<input type="submit" id="panelSaveButton" value="<?php esc_attr_e( 'Save changes', 'stkit' )?>" name="cp_save" />

			<div id="messageUpdated"><?php echo $st_['message']; ?></div>

			<div class="clear"><!-- --></div>
	
			<ul id="panelTabsNav">
				<?php

					// General nav tab
					if ( $st_Options['panel']['style']['general']['status'] )
						echo '<li><a href="#general">' . __( 'General', 'stkit' ) . '</a></li>';

					// Custom nav tab
					if ( $st_Options['panel']['style']['custom']['status'] )
						echo '<li><a href="#custom">' . __( 'Custom', 'stkit' ) . '</a></li>';

				?>
			</ul>
	
			<div class="clear"><!-- --></div>
	
		</div>


	
		<!--=============================================
		
			G E N E R A L
			A page with style settings
		
		==============================================-->

		<?php

			// General tab
			if ( $st_Options['panel']['style']['general']['status'] ) {	?>

				<div id="general" class="panelTab">
		
		
					<!-------------------------------------------
						1.1 - General
					-------------------------------------------->

					<?php // General
						if ( $st_Options['panel']['style']['general']['styles']['status'] ) { ?>

							<fieldset class="panel-fieldset"><legend><?php _e( 'General', 'stkit' ) ?></legend>
					
								<dl>
									<dt>
										<?php _e( 'Style', 'stkit' ) ?>
									</dt>
									<dd>

										<?php
											$st_['counter'] = 0;

											foreach ( $st_Options['panel']['style']['general']['styles'] as $st_['style'] => $key ) {

												if ( $key['status'] ) {

													$st_['checked'] = '';
													$st_['counter']++;
	
													// Select the first style in case database is empty
													if ( $st_['counter'] == 1 )
														$st_['checked'] = 'checked="checked"';
	
													// Select requred style
													elseif ( !empty( $st_Settings['style'] ) && $st_Settings['style'] == $st_['style'] )
														$st_['checked'] = 'checked="checked"'; ?>
	
													<label><input type="radio" value="<?php echo $st_['style'] ?>" name="style"  <?php echo $st_['checked'] ?> /> <?php echo $key['label'] ?></label><?php
				
												}
				
											}

										?>
										<small><?php _e( 'Select a style.', 'stkit' ) ?></small>

									</dd>
								</dl>

							</fieldset><?php

						}
					?>


					<!-------------------------------------------
						1.3 - Colors
					-------------------------------------------->

					<?php // Colors
						if ( $st_Options['panel']['style']['general']['colors']['status'] ) { ?>

							<fieldset class="panel-fieldset"><legend><?php _e( 'Colors', 'stkit' ) ?></legend>


								<?php // Primary
									if ( $st_['primary'] ) { ?>

										<!--- Primary ------------------------------>
							
										<dl>
											<dt>
												<span><?php _e( 'Primary', 'stkit' ) ?></span>
											</dt>
											<dd>
		
												<div class="color-preview" id="color-primary-preview" style="background-color: #<?php echo esc_html( !empty( $st_Settings['color-primary'] ) ? $st_Settings['color-primary'] : $st_['primary'] ); ?>;">&nbsp;</div>
												<input type="text" name="color-primary" id="color-primary" class="input-short" value="<?php echo esc_html( !empty( $st_Settings['color-primary'] ) ? $st_Settings['color-primary'] : $st_['primary'] ); ?>" />
												<small><?php _e( 'Select a primary color.', 'stkit' ) ?></small>
		
											</dd>
										</dl><?php

									}
								?>
		
		
								<?php // Secondary
									if ( $st_['secondary'] ) { ?>

										<!--- Secondary ------------------------------>
							
										<dl>
											<dt>
												<span><?php _e( 'Secondary', 'stkit' ) ?></span>
											</dt>
											<dd>
		
												<div class="color-preview" id="color-secondary-preview" style="background-color: #<?php echo esc_html( !empty( $st_Settings['color-secondary'] ) ? $st_Settings['color-secondary'] : $st_['secondary'] ); ?>;">&nbsp;</div>
												<input type="text" name="color-secondary" id="color-secondary" class="input-short" value="<?php echo esc_html( !empty( $st_Settings['color-secondary'] ) ? $st_Settings['color-secondary'] : $st_['secondary'] ); ?>" />
												<small><?php _e( 'Select a secondary color.', 'stkit' ) ?></small>
		
											</dd>
										</dl><?php

									}
								?>


							</fieldset><?php

						}
					?>

		
				</div><!-- #general --><?php

			}

		?>



		<!--=============================================
		
			C U S T O M
			A page with custom style settings
		
		==============================================-->

		<?php

			// Custom tab
			if ( $st_Options['panel']['style']['custom']['status'] ) {	?>

				<div id="custom" class="panelTab">

					<fieldset class="panel-fieldset"><legend><?php _e( 'Custom', 'stkit' ) ?></legend>
			
						<dl>
							<dt>
								<span><?php _e( 'CSS styles', 'stkit' ) ?></span>
							</dt>
							<dd>
								<textarea name="custom_css" id="custom_css" class="no-resize" /><?php echo !empty( $st_Settings['custom_css'] ) ? $st_Settings['custom_css'] : ''; ?></textarea>
								<small><?php _e( 'To prevent problems with theme update, write here any custom CSS (or use <a href="http://codex.wordpress.org/Child_Themes">child themes</a>).', 'stkit' ) ?></small>
							</dd>
						</dl>

					</fieldset>

				</div><!-- #custom --><?php

			}

		?>



	</div><!-- #themePanel -->



</form>