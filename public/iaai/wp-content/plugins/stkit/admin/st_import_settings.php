<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<!--

	1 - GENERAL

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

	<input type="hidden" id="st_import_settings_action" name="st_import_settings_action" value="save">


	
	<div id="themePanel">



		<div id="panelHeader">
	
			<div id="panelTitle"><?php _e( 'Import-Export Settings', 'stkit' ); echo ' <span>ST Kit v.' . $st_Kit['version']; ?></span></div>
	
			<input type="submit" id="panelSaveButton" value="<?php _e( 'Save changes', 'stkit' )?>" name="cp_save" />

			<div id="messageUpdated"><?php echo $st_['message']; ?></div>

			<div class="clear"><!-- --></div>
	
			<ul id="panelTabsNav">
				<?php

					// General nav tab
					if ( $st_Options['panel']['import']['status'] )
						echo '<li><a class="current" href="#general">' . __( 'General', 'stkit' ) . '</a></li>';

				?>
			</ul>
	
			<div class="clear"><!-- --></div>
	
		</div>


	
		<!--=============================================
		
			G E N E R A L
			A page with import settings
		
		==============================================-->

		<div id="general" class="panelTab">

			<fieldset class="panel-fieldset"><legend><?php _e( 'General', 'stkit' ) ?></legend>		


					<dl>
						<dt>
							<span><?php _e( 'Data', 'stkit' ) ?></span>
						</dt>
						<dd>
							<textarea name="import_data" id="import_data" class="no-resize" /><?php echo !empty( $st_Settings ) ? base64_encode( serialize( $st_Settings ) ) : ''; ?></textarea>
							<small><?php _e( 'Import or Export all settings.', 'stkit' ) ?></small>				
						</dd>
					</dl>


			</fieldset>

		</div><!-- #general -->



	</div><!-- #themePanel -->



</form>