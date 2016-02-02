<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<!--

	1 - GENERAL

		1.1 - Font size
		1.2 - Font type
			- Font type
			- Fonts System
			- Fonts Custom

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

	<input type="hidden" id="st_fonts_settings_action" name="st_fonts_settings_action" value="save">
	<input type="hidden" name="tab_st_fonts_settings" value="<?php echo esc_html( !empty( $st_Settings['tab_st_fonts_settings'] ) ? $st_Settings['tab_st_fonts_settings'] : '' ); ?>" id="input-panelTabsNav" />


	
	<div id="themePanel">



		<div id="panelHeader">
	
			<div id="panelTitle"><?php _e( 'Fonts Settings', 'stkit' ); echo ' <span>ST Kit v.' . $st_Kit['version']; ?></span></div>
	
			<input type="submit" id="panelSaveButton" value="<?php esc_attr_e( 'Save changes', 'stkit' )?>" name="cp_save" />

			<div id="messageUpdated"><?php echo $st_['message']; ?></div>

			<div class="clear"><!-- --></div>
	
			<ul id="panelTabsNav">
				<?php

					// General nav tab
					if ( $st_Options['panel']['fonts']['general']['status'] )
						echo '<li><a href="#general">' . __( 'General', 'stkit' ) . '</a></li>';

				?>
			</ul>
	
			<div class="clear"><!-- --></div>
	
		</div>


	
		<!--=============================================
		
			G E N E R A L
			A page with fonts settings
		
		==============================================-->

		<?php

			// General tab
			if ( $st_Options['panel']['fonts']['general']['status'] ) {	?>

				<div id="general" class="panelTab">
		
		
					<!-------------------------------------------
						1.1 - Font size
					-------------------------------------------->

					<fieldset class="panel-fieldset"><legend><?php _e( 'General', 'stkit' ) ?></legend>

						<?php // Font size
							if ( $st_Options['panel']['fonts']['general']['font_size'] ) { ?>

								<dl>
									<dt>
										<span><?php _e( 'Font size', 'stkit' ) ?></span>
									</dt>
									<dd>
										<input type="text" id="font_size" name="font_size" class="input-short" value="<?php echo esc_html( !empty( $st_Settings['font_size'] ) ? $st_Settings['font_size'] : 14 ); ?>" />
										<div class="slider-box"><div id="font_size-slider"></div></div>
										<div class="clear"><!-- --></div>
										<small><?php _e( 'Content font size.', 'stkit' ) ?></span></small>
									</dd>
								</dl><?php
	
							}
						?>

					</fieldset>


					<!-------------------------------------------
						1.2 - Font type
					-------------------------------------------->

					<fieldset class="panel-fieldset"><legend><?php _e( 'Font type', 'stkit' ) ?></legend>


						<!--- Font type ------------------------------>

						<?php // Font type
							if ( $st_Options['panel']['fonts']['general']['font_type'] ) { ?>

								<dl>
									<dt>
										<small>01.</small>
									</dt>
									<dd>

										<label id="radio-font-system" class="tooltip" title="<?php _e( 'System fonts', 'stkit' ) ?>"><input type="radio" value="standard" name="font_type"
										<?php if ( !empty( $st_Settings['font_type'] ) && $st_Settings['font_type'] == 'standard' || !isset( $st_Settings['font_type'] ) ) echo 'checked="checked"'; ?> /> <?php _e( 'Standard', 'stkit' ) ?></label>

										<label id="radio-font-custom" class="tooltip" title="<?php _e( 'Google fonts', 'stkit' ) ?>"><input type="radio" value="custom" name="font_type"
										<?php if ( !empty( $st_Settings['font_type'] ) && $st_Settings['font_type'] == 'custom' ) echo 'checked="checked"'; ?> /> <?php _e( 'Custom', 'stkit' ) ?></label>

									</dd>
								</dl><?php
	
							}
						?>


						<!--- Fonts System ------------------------------>

						<div id="font-system">

							<dl>
								<dt>
									<span><small>02.</small></span>
								</dt>
								<dd>

									<select name="font_system">
										<?php
		
											foreach ( $st_Kit['fonts_system'] as $key ) {
		
												$out = "\n" . '<option value="' . $key . '"';
		
												if ( !empty( $st_Settings['font_system'] ) && $st_Settings['font_system'] == $key )
													$out .= ' selected ';
		
												$out .= '>' . $key . '</option>';
		
												echo $out;
		
											};
										?>
									</select>
									<small><?php _e( 'Select a font family.', 'stkit' ) ?></span></small>

								</dd>
							</dl>

						</div>


						<!--- Fonts Custom ------------------------------>

						<?php // Fonts Custom
							if ( $st_Options['panel']['fonts']['general']['font_custom'] ) { ?>

								<div id="font-custom">


									<!--- Before starting --->

									<dl>
										<dt>
											<small>02.</small>
										</dt>
										<dd>
											<?php

												_e( 'Choose the font you want from Google <a href="http://google.com/fonts">library</a> and press', 'stkit' );

											?>&nbsp;<img src="<?php echo plugins_url() ?>/stkit/assets/images/quick_use_static.png" class="tooltip" title="Quick-use" alt=""/>
										</dd>
									</dl>


									<!--- Step 1 --->

									<dl>
										<dt>
											<small>03.</small>
										</dt>
										<dd>
											<?php _e( 'Choose the styles you want.', 'stkit' ) ?>
										</dd>
									</dl>


									<!--- Step 2 --->

									<dl>
										<dt>
											<small>04.</small>
										</dt>
										<dd>
											<?php _e( 'Choose the character sets you want.', 'stkit' ) ?>
										</dd>
									</dl>


									<!--- Step 3 --->

									<dl>
										<dt>
											<span><small>05.</small></span>
										</dt>
										<dd>
											<input type="text" name="font_custom_code" value="<?php echo esc_attr( !empty( $st_Settings['font_custom_code'] ) ? $st_Settings['font_custom_code'] : "<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>" ); ?>" />
											<small><?php _e( 'Add code.', 'stkit' ) ?></small>
										</dd>
									</dl>


									<!--- Step 4 --->

									<dl>
										<dt>
											<span><small>06.</small></span>
										</dt>
										<dd>
											<input type="text" name="font_custom_css" value="<?php echo esc_attr( !empty( $st_Settings['font_custom_css'] ) ? $st_Settings['font_custom_css'] : "font-family: 'Open Sans', sans-serif;" ); ?>" />
											<small><?php _e( 'Add CSS', 'stkit' ) ?></small>
										</dd>
									</dl>


								</div><?php
	
							}
						?>


					</fieldset>
		
				</div><!-- #general --><?php

			}

		?>



	</div><!-- #themePanel -->



</form>