<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<!--

	1 - GENERAL

		1.1 - Admin Bar
		1.2 - prettyPhoto
		1.3 - HiDPI
		1.4 - Shortcodes
		1.5 - Sticky Menu
		1.6 - Sidebar 300px
		1.7 - Woo
	
	2 - ADSENSE

		2.1 - Status
		2.2 - Client

	3 - WOOCOMMERCE

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

	<input type="hidden" id="st_misc_settings_action" name="st_misc_settings_action" value="save">
	<input type="hidden" name="tab_st_misc_settings" value="<?php echo esc_html( !empty( $st_Settings['tab_st_misc_settings'] ) ? $st_Settings['tab_st_misc_settings'] : '' ); ?>" id="input-panelTabsNav" />


	
	<div id="themePanel">



		<div id="panelHeader">
	
			<div id="panelTitle"><?php _e( 'Miscellaneous Settings', 'stkit' ); echo ' <span>ST Kit v.' . $st_Kit['version']; ?></span></div>
	
			<input type="submit" id="panelSaveButton" value="<?php esc_attr_e( 'Save changes', 'stkit' )?>" name="cp_save" />

			<div id="messageUpdated"><?php echo $st_['message']; ?></div>

			<div class="clear"><!-- --></div>
	
			<ul id="panelTabsNav">
				<?php

					// General nav tab
					if ( $st_Options['panel']['misc']['general']['status'] )
						echo '<li><a href="#general">' . __( 'General', 'stkit' ) . '</a></li>';

					// AdSense nav tab
					if ( !empty( $st_Options['panel']['misc']['adsense'] ) && $st_Options['panel']['misc']['adsense'] )
						echo '<li><a href="#adsense">' . __( 'AdSense', 'stkit' ) . '</a></li>';

					// WooCommerce nav tab
					if ( class_exists( 'WooCommerce' ) && !empty( $st_Options['panel']['misc']['woocommerce']['status'] ) && $st_Options['panel']['misc']['woocommerce']['status'] )
						echo '<li><a href="#woocommerce">' . __( 'WooCommerce', 'stkit' ) . '</a></li>';

				?>
			</ul>
	
			<div class="clear"><!-- --></div>
	
		</div>


	
		<!--=============================================
		
			G E N E R A L
			A page with misc settings
		
		==============================================-->

		<?php

			// General tab
			if ( $st_Options['panel']['misc']['general']['status'] ) {	?>

				<div id="general" class="panelTab">

					<fieldset class="panel-fieldset"><legend><?php _e( 'General', 'stkit' ) ?></legend>		


						<!-------------------------------------------
							1.0 - Sanitization
						-------------------------------------------->
	
						<?php // Sanitization ?>

							<dl>
								<dt>
									<?php _e( 'Sanitization', 'stkit' ) ?>
								</dt>
								<dd>
									<label>
										<input type="checkbox" name="sanitization" value="no" <?php if ( !empty( $st_Settings['sanitization'] ) && $st_Settings['sanitization'] == 'no' ) echo 'checked'; ?> /> 
										<?php _e( 'Disabled', 'stkit' ) ?>
									</label>
									<small><?php _e( 'Do not sanitize input data on text areas of Theme Panel.', 'stkit' ) ?></small>				
								</dd>
							</dl><?php

						?>


						<!-------------------------------------------
							1.1 - Admin Bar
						-------------------------------------------->
	
						<?php // Admin Bar
							if ( $st_Options['panel']['misc']['admin_bar'] ) { ?>
						
								<dl>
									<dt>
										<?php _e( 'Admin Bar', 'stkit' ) ?>
									</dt>
									<dd>
										<label>
											<input type="checkbox" name="admin_bar" value="no" <?php if ( !empty( $st_Settings['admin_bar'] ) && $st_Settings['admin_bar'] == 'no' ) echo 'checked'; ?> /> 
											<?php _e( 'Disabled', 'stkit' ) ?>
										</label>
										<small><?php _e( 'Do not show admin bar on the front-end.', 'stkit' ) ?></small>				
									</dd>
								</dl><?php
	
							}
						?>


						<!-------------------------------------------
							1.2 - prettyPhoto
						-------------------------------------------->
	
						<?php // Admin Bar
							if ( $st_Options['js']['prettyPhoto'] ) { ?>
						
								<dl>
									<dt>
										<?php _e( 'prettyPhoto', 'stkit' ) ?>
									</dt>
									<dd>
										<label>
											<input type="checkbox" name="prettyPhoto" value="no" <?php if ( !empty( $st_Settings['prettyPhoto'] ) && $st_Settings['prettyPhoto'] == 'no' ) echo 'checked'; ?> /> 
											<?php _e( 'Disabled', 'stkit' ) ?>
										</label>
										<small><?php _e( 'Disable the built-in lightbox plugin.', 'stkit' ) ?></small>				
									</dd>
								</dl><?php
	
							}
						?>


						<!-------------------------------------------
							1.3 - HiDPI
						-------------------------------------------->
	
						<?php // HiDPI
							if ( $st_Options['panel']['misc']['hidpi'] ) { ?>
						
								<dl>
									<dt>
										<?php _e( 'HiDPI', 'stkit' ) ?>
									</dt>
									<dd>
										<label>
											<input type="checkbox" name="hidpi" value="no" <?php if ( !empty( $st_Settings['hidpi'] ) && $st_Settings['hidpi'] == 'no' ) echo 'checked'; ?> /> 
											<?php _e( 'Disabled', 'stkit' ) ?>
										</label>
										<small><?php _e( 'Disable compatibility with HiDPI devices like a laptops with Retina display.', 'stkit' ) ?></small>				
									</dd>
								</dl><?php
	
							}
						?>


						<!-------------------------------------------
							1.4 - Shortcodes
						-------------------------------------------->
	
						<?php // Shortcodes
							if ( $st_Options['shortcodes']['status'] ) { ?>
						
								<dl>
									<dt>
										<?php _e( 'Shortcodes', 'stkit' ) ?>
									</dt>
									<dd>
										<label>
											<input type="checkbox" name="shortcodes" value="no" <?php if ( !empty( $st_Settings['shortcodes'] ) && $st_Settings['shortcodes'] == 'no' ) echo 'checked'; ?> /> 
											<?php _e( 'Disabled', 'stkit' ) ?>
										</label>
										<small><?php _e( 'Disable the built-in ST shortcodes. Some functionality based on shortcodes will be inactive e.g. Gallery post format.', 'stkit' ) ?></small>
									</dd>
								</dl><?php
	
							}
						?>


						<!-------------------------------------------
							1.5 - Sticky Menu
						-------------------------------------------->
	
						<?php // Sticky Menu
							if ( !empty($st_Options['panel']['misc']['stickymenu'] ) && $st_Options['panel']['misc']['stickymenu'] ) { ?>
						
								<dl>
									<dt>
										<?php _e( 'Sticky Menu', 'stkit' ) ?>
									</dt>
									<dd>
										<label>
											<input type="checkbox" name="stickymenu" value="no" <?php if ( !empty( $st_Settings['stickymenu'] ) && $st_Settings['stickymenu'] == 'no' ) echo 'checked'; ?> /> 
											<?php _e( 'Disabled', 'stkit' ) ?>
										</label>
										<small><?php _e( 'Disable Sticky Menu option.', 'stkit' ) ?></small>
									</dd>
								</dl><?php
	
							}
						?>


						<!-------------------------------------------
							1.6 - Sidebar 300px
						-------------------------------------------->
	
						<?php // Sidebar 300px
							if ( !empty($st_Options['panel']['misc']['sidebar-alt'] ) && $st_Options['panel']['misc']['sidebar-alt'] ) { ?>
						
								<dl>
									<dt>
										<?php _e( 'Sidebar Width', 'stkit' ) ?>
									</dt>
									<dd>
										<label>
											<input type="checkbox" name="sidebar-alt" value="yes" <?php if ( !empty( $st_Settings['sidebar-alt'] ) && $st_Settings['sidebar-alt'] == 'yes' ) echo 'checked'; ?> /> 
											<?php _e( 'Alternative', 'stkit' ) ?>
										</label>
										<small><?php _e( 'Set an alternative width of general sidebar.', 'stkit' ) ?></small>
									</dd>
								</dl><?php
	
							}
						?>


					</fieldset>
		
				</div><!-- #general --><?php

			}

		?>



		<!--=============================================
		
			A D S E N S E
			Ad Units for Google AdSense
		
		==============================================-->

		<?php

			//AdSense
			if ( !empty($st_Options['panel']['misc']['adsense']) && $st_Options['panel']['misc']['adsense'] ) { ?>

				<div id="adsense" class="panelTab">

					<fieldset class="panel-fieldset"><legend><?php _e( 'AdSense', 'stkit' ) ?></legend>


						<!-------------------------------------------
							2.1 - Status
						-------------------------------------------->

						<dl>
							<dt>
								<?php _e( 'Status', 'stkit' ) ?>
							</dt>
							<dd>
								<label>
									<input type="checkbox" name="adsense" value="yes" <?php if ( !empty( $st_Settings['adsense'] ) && $st_Settings['adsense'] == 'yes' ) echo 'checked'; ?> /> 
									<?php _e( 'Enabled', 'stkit' ) ?>
								</label>
								<small><?php _e( 'Make the AdSense ad units responsive. Fill form below, and use ST AdSense widget or shortcode <br>e.g. <code>[adsense slot=1234567890 sizes=728x90|580x400|468x60|300x250]</code>', 'stkit' ) ?></small>
							</dd>
						</dl>

		
						<!-------------------------------------------
							2.2 - Client
						-------------------------------------------->

						<dl>
							<dt>
								<span><?php _e( 'Client ID', 'stkit' ) ?></span>
							</dt>
							<dd>
								<input type="text" name="adsense_id" value="<?php if ( !empty( $st_Settings['adsense_id'] ) ) echo $st_Settings['adsense_id']; ?>" />
								<small><?php _e( 'e.q.', 'stkit' ) ?> ca-pub-1234567891234567</small>				
							</dd>
						</dl>


					</fieldset>

				</div><!-- #adsense --><?php

			}

		?>



		<!--=============================================
		
			W O O C O M M E R C E
			Custom things for WooCommerce
		
		==============================================-->

		<?php

			// WooCommerce tab
			if ( !empty( $st_Options['panel']['misc']['woocommerce']['status'] ) && class_exists( 'WooCommerce' ) ) {	?>

				<div id="woocommerce" class="panelTab">
			
		
					<!-------------------------------------------
						3.1 - Number of products per page
					-------------------------------------------->

					<?php // Number of products per page
						if ( $st_Options['panel']['misc']['woocommerce']['qty'] ) { ?>	

							<fieldset class="panel-fieldset"><legend><?php _e( 'Products per page', 'stkit' ) ?></legend>

								<dl>
									<dt>
										<span><?php _e( 'Quantity', 'stkit' ) ?></span>
									</dt>
									<dd>
										<input type="text" id="products_qty" name="products_qty" class="input-short" value="<?php echo esc_html( !empty( $st_Settings['products_qty'] ) ? $st_Settings['products_qty'] : 9 ); ?>" />
										<div class="slider-box"><div id="products_qty-slider"></div></div>
										<div class="clear"><!-- --></div>
										<small><?php _e( 'Set a number of products per page.', 'stkit' ) ?></small>
									</dd>
								</dl>

							</fieldset><?php

						}
					?>
			
		
					<!-------------------------------------------
						3.2 - Do not load assets on third-party pages
					-------------------------------------------->

					<?php // Do not load assets on third-party pages
						if ( $st_Options['panel']['misc']['woocommerce']['assets'] ) { ?>	

							<fieldset class="panel-fieldset"><legend><?php _e( 'Miscellaneous', 'stkit' ) ?></legend>

								<dl>
									<dt>
										<?php _e( 'Assets', 'stkit' ) ?>
									</dt>
									<dd>
										<label>
											<input type="checkbox" name="wooc_assets" value="yes" <?php if ( !empty( $st_Settings['wooc_assets'] ) && $st_Settings['wooc_assets'] == 'yes' ) echo 'checked'; ?> /> 
											<?php _e( 'Disabled', 'stkit' ) ?>
										</label>
										<small><?php _e( 'Do not load JS & CSS files on non-WooCommerce pages.', 'stkit' ) ?></small>
									</dd>
								</dl>

							</fieldset><?php

						}
					?>
			
				</div><!-- #woocommerce --><?php

			}

		?>



	</div><!-- #themePanel -->



</form>