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
	
	<div id="themePanel">

		<div id="panelHeader">
	
			<div id="panelTitle"><?php _e( 'Setup Demo', 'stkit' ); echo ' <span>ST Kit v.' . $st_Kit['version']; ?></span></div>
	
			<div class="clear"><!-- --></div>
	
		</div>

	
		<!--=============================================
		
			G E N E R A L
			A page with import settings
		
		==============================================-->

		<div id="general" class="panelTab">

			<fieldset class="panel-fieldset"><legend><?php _e( 'Setup Demo', 'stkit' ) ?></legend>		


					<a href="#">Install</a>


			</fieldset>

		</div><!-- #general -->


	</div><!-- #themePanel -->