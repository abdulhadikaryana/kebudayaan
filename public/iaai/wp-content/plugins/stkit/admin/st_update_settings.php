<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<!--

	1 - GENERAL

		1.1 - ThemeForest
			- Username
			- API key

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

	<input type="hidden" id="st_update_settings_action" name="st_update_settings_action" value="save">
	<input type="hidden" name="tab_st_update_settings" value="<?php echo esc_html( !empty( $st_Settings['tab_st_update_settings'] ) ? $st_Settings['tab_st_update_settings'] : '' ); ?>" id="input-panelTabsNav" />


	
	<div id="themePanel">



		<div id="panelHeader">
	
			<div id="panelTitle"><?php _e( 'Update Settings', 'stkit' ); echo ' <span>ST Kit v.' . $st_Kit['version']; ?></span></div>
	
			<input type="submit" id="panelSaveButton" value="<?php esc_attr_e( 'Save changes', 'stkit' )?>" name="cp_save" />

			<div id="messageUpdated"><?php echo $st_['message']; ?></div>

			<div class="clear"><!-- --></div>
	
			<ul id="panelTabsNav">
				<?php

					// General nav tab
					if ( $st_Options['panel']['update']['general']['status'] )
						echo '<li><a href="#general">' . __( 'General', 'stkit' ) . '</a></li>';

				?>
			</ul>
	
			<div class="clear"><!-- --></div>
	
		</div>


	
		<!--=============================================
		
			G E N E R A L
			A page with update settings
		
		==============================================-->

		<?php

			// General tab
			if ( $st_Options['panel']['update']['general']['status'] ) {	?>

				<div id="general" class="panelTab">
		
		
					<!-------------------------------------------
						1.1 - ThemeForest
					-------------------------------------------->

					<?php // ThemeForest
						if ( $st_Options['panel']['update']['general']['source'] == 'themeforest' ) { ?>

							<fieldset class="panel-fieldset"><legend><?php _e( 'ThemeForest', 'stkit' ) ?></legend>

								<dl>
									<dt></dt>
									<dd>
										<?php _e( 'Fill fields below to get notification about new version of theme.', 'stkit' ) ?>			
									</dd>
								</dl>

								<dl>
									<dt>
										<span><?php _e( 'Username', 'stkit' ) ?></span>
									</dt>
									<dd>
										<input type="text" name="username" value="<?php echo esc_attr( !empty( $st_Settings['username'] ) ? $st_Settings['username'] : '' ); ?>" />
										<small><?php _e( 'Enter your ThemeForest username.', 'stkit' ) ?></small>				
									</dd>
								</dl>

								<dl>
									<dt>
										<span><?php _e( 'API key', 'stkit' ) ?></span>
									</dt>
									<dd>
										<input type="text" name="apikey" value="<?php echo esc_attr( !empty( $st_Settings['apikey'] ) ? $st_Settings['apikey'] : '' ); ?>" />
										<small><?php _e( 'To get your API key go to <code>ThemeForest > Your profile > Settings > API Keys</code> and Generate API Key.', 'stkit' ) ?></small>				
									</dd>
								</dl>
				
							</fieldset><?php

						}
					?>


				</div><!-- #general --><?php

			}

		?>



	</div><!-- #themePanel -->



</form>