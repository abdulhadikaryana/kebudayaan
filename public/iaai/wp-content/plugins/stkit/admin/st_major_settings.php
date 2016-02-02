<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<!--

	1 - GENERAL

		1.1 - Logo
			- Controls
			- Text logo
			- Image logo
			- Image logo preview
		1.2 - Favicon
		1.3 - Copyrights
		1.4 - Google Analytics

	2 - BLOG

		2.1 - Blog
			- Template
		2.2 - Featured posts
			- 
			- 
			-

	3 - POST

		3.1 - Under title
		3.2 - Above post
		3.3 - Featured image
		3.4 - Excerpt
		3.5 - Meta
			- Author's info
			- Post views
			- Nice time
		3.6 - Under post
		3.7 - Comments
			- Website input field
			- Pingbacks
		3.8 - Related posts

	4 - PAGE

		4.1 - Comments

	5 - SIDEBAR

		5.1 - Additional sidebars

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

	<input type="hidden" id="st_major_settings_action" name="st_major_settings_action" value="save">
	<input type="hidden" name="tab_st_major_settings" value="<?php echo esc_html( !empty( $st_Settings['tab_st_major_settings'] ) ? $st_Settings['tab_st_major_settings'] : '' ); ?>" id="input-panelTabsNav" />


	
	<div id="themePanel">



		<div id="panelHeader">
	
			<div id="panelTitle"><?php _e( 'Main Settings', 'stkit' ); echo ' <span>ST Kit v.' . $st_Kit['version']; ?></span></div>
	
			<input type="submit" id="panelSaveButton" value="<?php esc_attr_e( 'Save changes', 'stkit' )?>" name="cp_save" />

			<div id="messageUpdated"><?php echo $st_['message']; ?></div>

			<div class="clear"><!-- --></div>
	
			<ul id="panelTabsNav">
				<?php

					// General nav tab
					if ( $st_Options['panel']['major']['general']['status'] )
						echo '<li><a href="#general">' . __( 'General', 'stkit' ) . '</a></li>';

					// Blog nav tab
					if ( $st_Options['panel']['major']['blog']['status'] )
						echo '<li><a href="#blog">' . __( 'Blog', 'stkit' ) . '</a></li>';

					// Post nav tab
					if ( $st_Options['panel']['major']['post']['status'] )
						echo '<li><a href="#post">' . __( 'Post', 'stkit' ) . '</a></li>';

					// Page nav tab
					if ( $st_Options['panel']['major']['page']['status'] )
						echo '<li><a href="#page">' . __( 'Page', 'stkit' ) . '</a></li>';

					// Sidebar nav tab
					if ( $st_Options['panel']['major']['sidebar']['status'] )
						echo '<li><a href="#sidebar">' . __( 'Sidebar', 'stkit' ) . '</a></li>';

				?>
			</ul>
	
			<div class="clear"><!-- --></div>
	
		</div>


	
		<!--=============================================
		
			G E N E R A L
			A page with major settings
		
		==============================================-->

		<?php

			// General tab
			if ( $st_Options['panel']['major']['general']['status'] ) {	?>

				<div id="general" class="panelTab">
		
		
					<!-------------------------------------------
						1.1 - Logo
					-------------------------------------------->
		
					<fieldset class="panel-fieldset"><legend><?php _e( 'Logo', 'stkit' ) ?></legend>
		
		
						<!--- Controls ----------------------------->
		
						<dl>
							<dt>
		
								<?php _e( 'Type', 'stkit' ) ?>
		
							</dt>
							<dd>
		
								<label><input type="radio" value="text" name="logo_type" id="radio-logo-text"
								<?php if ( !empty( $st_Settings['logo_type'] ) && $st_Settings['logo_type'] == 'text' ) echo 'checked="checked"'; ?> /> <?php _e( 'Text', 'stkit' ) ?></label>

								<?php
									if ( $st_Options['panel']['major']['general']['logo_img'] ) { ?>		
										<label><input type="radio" value="image" name="logo_type" id="radio-logo-image"
										<?php if ( !isset( $st_Settings['logo_type'] ) || !empty( $st_Settings['logo_type'] ) && $st_Settings['logo_type'] == 'image' ) echo 'checked="checked"'; ?> /> <?php _e( 'Image', 'stkit' ) ?></label><?php
									}
								?>
		
							</dd>
						</dl>
		
		
						<!--- Text logo ----------------------------->
		
						<dl class="last" style="display: none;" id="logo-text">
							<dt>
		
								<span><?php _e( 'Site Name', 'stkit' ) ?></span>
		
							</dt>
							<dd>

								<input type="text" name="sitename" value="<?php echo esc_attr( !empty( $st_Settings['sitename'] ) ? $st_Settings['sitename'] : $st_Options['general']['label'] ); ?>" />
								<small><?php _e( 'Enter the site name e.g. <code>Site&lt;strong>Name&lt;/strong></code>', 'stkit' ) ?></small>
		
							</dd>
						</dl>
		
		
						<!--- Image logo ----------------------------->

						<?php // Image logo
							if ( $st_Options['panel']['major']['general']['logo_img'] ) { ?>

								<dl class="last" style="display: none;" id="logo-image">
									<dt>
				
										<span><?php _e( 'Image URL', 'stkit' ) ?></span>
				
									</dt>
									<dd>
				
										<input type="text" name="logo" value="<?php echo esc_url( !empty( $st_Settings['logo'] ) ? $st_Settings['logo'] : get_template_directory_uri() . '/assets/images/logo.png' ); ?>" id="image-logo-input" />
										<small><?php _e( 'Insert an image URL e.q. <code>http://yoursite.com/image.png</code> <br>JPG, GIF or PNG formats allowed.', 'stkit' ) ?></small>
				
									</dd>
								</dl>

									<?php
										// HiDPI logo
										if ( function_exists('st_kit') ) {
											if ( $st_Options['panel']['misc']['hidpi'] && !empty( $st_Settings['hidpi'] ) != 'no' || $st_Options['panel']['misc']['hidpi'] && empty( $st_Settings['hidpi'] ) ) { ?>
												<dl class="last" style="display: none;" id="logo-image">
													<dt>
								
														<span><?php _e( 'Image 2x URL', 'stkit' ) ?></span>
								
													</dt>
													<dd>
								
														<input type="text" name="logo2x" value="<?php echo esc_url( !empty( $st_Settings['logo2x'] ) ? $st_Settings['logo2x'] : get_template_directory_uri() . '/assets/images/logo2x.png' ) ?>" />
														<small><?php _e( 'If you would like to provide a compatibility with HiDPI screens, please, insert a doubled logo e.g. if your normal logo dimentions are 150x50 pixels, the doubled version must be 300x100 pixels.', 'stkit' ) ?></small>
								
													</dd>
												</dl><?php
											}
										}
									?>
		
								<!--- Image logo preview ----------------------------->

								<?php // Get color
									$st_['primary'] = $st_Options['panel']['style']['general']['colors']['primary']['hex'];
									$st_['color'] = !empty( $st_Settings['color-primary'] ) ? $st_Settings['color-primary'] : $st_['primary'];
								?>

								<div style="display: none; background: #CCC;" id="logo-image-preview">
									<img class="image-logo-preview" src="<?php echo esc_url( !empty( $st_Settings['logo'] ) ? $st_Settings['logo'] : get_template_directory_uri() . '/assets/images/logo.png' ); ?>" />
								</div><?php

							}
						?>
		
		
					</fieldset>
		
		
					<!-------------------------------------------
						1.2 - Favicon
					-------------------------------------------->

					<?php // Favicon
						if ( $st_Options['panel']['major']['general']['favicon'] ) { ?>

							<fieldset class="panel-fieldset"><legend><?php _e( 'Favicon', 'stkit' ) ?></legend>
					
								<dl>
									<dt>
										<span><?php _e( 'Image URL', 'stkit' ) ?></span>
									</dt>
									<dd>
										<input type="text" name="favicon" value="<?php echo esc_attr( !empty( $st_Settings['favicon'] ) ? $st_Settings['favicon'] : get_template_directory_uri() . '/favicon.ico' ); ?>" style="background-image: url('<?php echo !empty( $st_Settings['favicon'] ) ? $st_Settings['favicon'] : get_template_directory_uri() . '/favicon.ico'; ?>'); background-position: 5px 50%; background-repeat: no-repeat; background-size: 16px 16px; padding-left: 25px;" />
										<small><?php _e( 'e.q.', 'stkit' ) ?> <code>http://yoursite.com/favicon.ico</code></small>				
									</dd>
								</dl>
				
				
							</fieldset><?php

						}
					?>
		

					<!-------------------------------------------
						1.3 - Copyrights
					-------------------------------------------->

					<?php // Copyrights
						if ( $st_Options['panel']['major']['general']['copyrights'] ) { ?>

							<fieldset class="panel-fieldset"><legend><?php _e( 'Copyrights', 'stkit' ); ?></legend>
					
								<dl>
									<dt>
										<span><?php _e( 'Yours', 'stkit' ); ?></span>
									</dt>
									<dd>
										<textarea name="copyrights" /><?php echo esc_textarea( !empty( $st_Settings['copyrights'] ) ? $st_Settings['copyrights'] : date('Y') . ' &copy; ' . get_bloginfo('sitename') ); ?></textarea>
										<small><?php _e( "Enter your copyrights here.", 'stkit' ); ?></small>
									</dd>
								</dl>

								<?php // Developer's link
									if ( $st_Options['panel']['major']['general']['dev_link'] ) { ?>

										<dl>
											<dt>
												<?php _e( "Developer's", 'stkit' ); ?>
											</dt>
											<dd>
												<label>
													<input type="checkbox" name="dev_link" value="no" <?php if ( !empty( $st_Settings['dev_link'] ) && $st_Settings['dev_link'] == 'no' ) echo 'checked'; ?> />
													<?php _e( 'Disabled', 'stkit' ); ?>
												</label>
												<small><?php _e( "Remove developer's link from the footer.", 'stkit' ); ?></small>
											</dd>
										</dl><?php

									}
								?>

							</fieldset><?php

						}
					?>


					<!-------------------------------------------
						1.4 - Google Analytics
					-------------------------------------------->

					<?php // Google Analytics
						if ( $st_Options['panel']['major']['general']['analytics'] ) { ?>

							<fieldset class="panel-fieldset"><legend><?php _e( 'Google Analytics', 'stkit' ) ?></legend>
					
								<dl>
									<dt>
										<span><?php _e( 'Code', 'stkit' ) ?></span>
									</dt>
									<dd>
										<textarea name="google_analytics" /><?php echo esc_textarea( !empty( $st_Settings['google_analytics'] ) ? $st_Settings['google_analytics'] : '' ); ?></textarea>
										<small><?php _e( "Put here your tracking code.", 'stkit' ); ?></small>
									</dd>
								</dl>
					
							</fieldset><?php

						}
					?>
			
		
				</div><!-- #general --><?php

			}

		?>



		<!--=============================================
		
			B L O G
			Blog page
		
		==============================================-->

		<?php

			// Blog tab
			if ( $st_Options['panel']['major']['blog']['status'] ) {	?>
	
				<div id="blog" class="panelTab">
		

					<!-------------------------------------------
						2.1 - Blog
					-------------------------------------------->
		
					<fieldset class="panel-fieldset"><legend><?php _e( 'Blog', 'stkit' ) ?></legend>


						<!--- Template ------------------------------>
			
						<?php
							if ( $st_Options['panel']['major']['blog']['status'] ) { ?>
			
								<dl>
									<dt>
										<?php _e( 'Template', 'stkit' ) ?>
									</dt>
									<dd>
										<?php
				
											foreach ( $st_Options['panel']['major']['blog']['template'] as $st_['template'] => $key ) {
				
												if ( $key['status']  ) {
	
													$st_['checked'] = '';
	
													// Select the Default in case database is empty
													if ( !$st_['template'] || $st_['template'] == 'default' )
														$st_['checked'] = 'checked="checked"';
	
													// Select requred template
													if ( !empty( $st_Settings['blog_template'] ) && $st_Settings['blog_template'] == $st_['template'] )
														$st_['checked'] = 'checked="checked"'; ?>
	
													<div class="tmpl_radio">
														<label class="lable-img" for="<?php echo $st_['template'] ?>_template">
															<img class="tooltip" src="<?php echo plugins_url() ?>/stkit/assets/images/schemes/posts/<?php echo $key['label'] ?>.gif" width="80" height="60" title="<?php echo $key['desc'] ?>">
														</label>
														<input type="radio" value="<?php echo esc_html( $st_['template'] ) ?>" name="blog_template" id="<?php echo $st_['template'] ?>_template" <?php echo $st_['checked'] ?> />
														<label for="<?php echo $st_['template'] ?>_template"><?php echo $key['label'] ?></label>
													</div><?php
				
												}
				
											}
				
										?>
							
										<small><?php _e( 'Select template for archive and blog page.', 'stkit' ) ?></small>
									</dd>
								</dl><?php
	
							}
				
						?>


					</fieldset>


					<!-------------------------------------------
						2.2 - Featured posts
					-------------------------------------------->
		
					<fieldset class="panel-fieldset"><legend><?php _e( 'Featured posts', 'stkit' ) ?></legend>

						<!--- Featured posts (sticky): Quantity  ------------------------------>

						<?php // Featured posts (sticky): Quantity
							if ( !empty($st_Options['panel']['major']['blog']['featured']['sticky'])&& $st_Options['panel']['major']['blog']['featured']['sticky'] ) { ?>
		
								<dl>
									<dt>
										<span><?php _e( 'Featured posts', 'stkit' ) ?></span>
									</dt>
									<dd>
										<input type="text" id="sticky_qty" name="sticky_qty" class="input-short" value="<?php echo esc_html( !empty( $st_Settings['sticky_qty'] ) ? $st_Settings['sticky_qty'] : ( !empty($st_Options['panel']['major']['blog']['featured']['sticky']) ? $st_Options['panel']['major']['blog']['featured']['sticky'] : 5 ) ); ?>" />
										<div class="slider-box"><div id="sticky_qty-slider"></div></div>
										<div class="clear"><!-- --></div>
										<small><?php _e( 'A quantity of featured (sticky) posts.', 'stkit' ) ?></span></small>
									</dd>
								</dl><?php

							}
						?>


						<!--- Featured posts (sticky): Display on frontpage ------------------------------>

						<?php // Featured posts (sticky): Display on frontpage
							if ( !empty($st_Options['panel']['major']['blog']['featured']['on-frontpage']) && $st_Options['panel']['major']['blog']['featured']['on-frontpage'] ) { ?>

								<dl>
									<dt>
										&nbsp;
									</dt>
									<dd>
										<label>
											<input type="checkbox" name="sticky_on_frontpage" value="yes" <?php if ( !empty( $st_Settings['sticky_on_frontpage'] ) && $st_Settings['sticky_on_frontpage'] == 'yes' ) echo 'checked'; ?> /> 
											<?php _e( 'Display on frontpage', 'stkit' ) ?>
										</label>
										<small><?php _e( 'Display sticky posts on frontpage.', 'stkit' ) ?></small>
									</dd>
								</dl><?php

							}
						?>


						<!--- Featured posts (sticky): Display on archives ------------------------------>

						<?php // Featured posts (sticky): Display on archives
							if ( !empty($st_Options['panel']['major']['blog']['featured']['on-archives']) && $st_Options['panel']['major']['blog']['featured']['on-archives'] ) { ?>

								<dl>
									<dt>
										&nbsp;
									</dt>
									<dd>
										<label>
											<input type="checkbox" name="sticky_on_archives" value="yes" <?php if ( !empty( $st_Settings['sticky_on_archives'] ) && $st_Settings['sticky_on_archives'] == 'yes' ) echo 'checked'; ?> /> 
											<?php _e( 'Display on archives', 'stkit' ) ?>
										</label>
										<small><?php _e( 'Display sticky posts on archives: categories, tags, formats.', 'stkit' ) ?></small>
									</dd>
								</dl><?php

							}
						?>


						<!--- Featured posts (sticky): Display on single ------------------------------>

						<?php // Featured posts (sticky): Display on single
							if ( !empty($st_Options['panel']['major']['blog']['featured']['on-single']) && $st_Options['panel']['major']['blog']['featured']['on-single'] ) { ?>

								<dl>
									<dt>
										&nbsp;
									</dt>
									<dd>
										<label>
											<input type="checkbox" name="sticky_on_single" value="yes" <?php if ( !empty( $st_Settings['sticky_on_single'] ) && $st_Settings['sticky_on_single'] == 'yes' ) echo 'checked'; ?> /> 
											<?php _e( 'Display on single post', 'stkit' ) ?>
										</label>
										<small><?php _e( 'Display sticky posts on single post.', 'stkit' ) ?></small>
									</dd>
								</dl><?php

							}
						?>


						<!--- Featured posts (sticky): Display on others ------------------------------>

						<?php // Featured posts (sticky): Display on others
							if ( !empty($st_Options['panel']['major']['blog']['featured']['on-others']) && $st_Options['panel']['major']['blog']['featured']['on-others'] ) { ?>

								<dl>
									<dt>
										&nbsp;
									</dt>
									<dd>
										<label>
											<input type="checkbox" name="sticky_on_others" value="yes" <?php if ( !empty( $st_Settings['sticky_on_others'] ) && $st_Settings['sticky_on_others'] == 'yes' ) echo 'checked'; ?> /> 
											<?php _e( 'Display on other pages', 'stkit' ) ?>
										</label>
										<small><?php _e( 'Display sticky posts on other kind of pages.', 'stkit' ) ?></small>
									</dd>
								</dl><?php

							}
						?>


						<!--- Featured posts (sticky): Exclude from blogroll ------------------------------>

						<?php // Featured posts (sticky): Exclude from blogroll
							if ( !empty($st_Options['panel']['major']['blog']['featured']['not-in-blogroll']) && $st_Options['panel']['major']['blog']['featured']['not-in-blogroll'] ) { ?>

								<dl>
									<dt>
										&nbsp;
									</dt>
									<dd>
										<label>
											<input type="checkbox" name="sticky_exclude" value="yes" <?php if ( !empty( $st_Settings['sticky_exclude'] ) && $st_Settings['sticky_exclude'] == 'yes' ) echo 'checked'; ?> /> 
											<?php _e( 'Exclude from blogroll', 'stkit' ) ?>
										</label>
										<small><?php _e( 'Do not display sticky posts on blogroll.', 'stkit' ) ?></small>
									</dd>
								</dl><?php

							}
						?>


						<!--- Featured posts (sticky): Cache query ------------------------------>

						<?php // Featured posts (sticky): Cache query
							if ( !empty($st_Options['panel']['major']['blog']['featured']['cache']) && $st_Options['panel']['major']['blog']['featured']['cache'] ) { ?>

								<dl>
									<dt>
										&nbsp;
									</dt>
									<dd>
										<label>
											<input type="checkbox" name="sticky_cache" value="yes" <?php if ( !empty( $st_Settings['sticky_cache'] ) && $st_Settings['sticky_cache'] == 'yes' ) echo 'checked'; ?> /> 
											<?php _e( 'Query cache', 'stkit' ) ?>
										</label>
										<small><?php _e( 'Store query result within 12 hours.', 'stkit' ) ?></small>
									</dd>
								</dl><?php

							}
						?>


					</fieldset>
		

				</div><!-- #blog --><?php

			}

		?>



		<!--=============================================
		
			P O S T
			Post page
		
		==============================================-->

		<?php

			// Post tab
			if ( $st_Options['panel']['major']['post']['status'] ) {	?>
	
				<div id="post" class="panelTab">

		
					<fieldset class="panel-fieldset"><legend><?php _e( 'Post', 'stkit' ) ?></legend>
		
		
						<!-------------------------------------------
							3.1 - Under title
						-------------------------------------------->

						<?php // Under title
							if ( $st_Options['panel']['major']['post']['after_title'] ) { ?>		

								<dl>
									<dt>
										<small>01.</small>
									</dt>
									<dd>
										<label>
											<input type="checkbox" name="after_title" id="after_title" class="checkbox-toggle" value="yes" <?php if ( !empty( $st_Settings['after_title'] ) && $st_Settings['after_title'] == 'yes' ) echo 'checked'; ?> /> 
											<?php _e( 'Under title', 'stkit' ) ?>
										</label>
										<small><?php _e( 'Display custom data under a title. Shortcodes allowed.', 'stkit' ) ?></small>
										<div id="after_title_box" class="checkbox-toggle-box">
											<textarea name="after_title_data" /><?php echo esc_textarea( !empty( $st_Settings['after_title_data'] ) ? $st_Settings['after_title_data'] : '' ); ?></textarea>
										</div>
									</dd>
								</dl><?php

							}
						?>
		

						<!-------------------------------------------
							3.2 - Above post
						-------------------------------------------->

						<?php // Above post
							if ( $st_Options['panel']['major']['post']['before_post'] ) { ?>	

								<dl>
									<dt>
										<small>02.</small>
									</dt>
									<dd>
										<label>
											<input type="checkbox" name="before_post" id="before_post" class="checkbox-toggle" value="yes" <?php if ( !empty( $st_Settings['before_post'] ) && $st_Settings['before_post'] == 'yes' ) echo 'checked'; ?> /> 
											<?php _e( 'Above post', 'stkit' ) ?>
										</label>
										<small><?php _e( 'Display custom data above a post. Shortcodes allowed.', 'stkit' ) ?></small>
										<div id="before_post_box" class="checkbox-toggle-box">
											<textarea name="before_post_data" /><?php echo esc_textarea( !empty( $st_Settings['before_post_data'] ) ? $st_Settings['before_post_data'] : '' ); ?></textarea>
										</div>
									</dd>
								</dl><?php

							}
						?>
		
		
						<!-------------------------------------------
							3.3 - Featured image
						-------------------------------------------->

						<?php // Featured image
							if ( $st_Options['panel']['major']['post']['post_feat_image'] ) { ?>	

								<dl>
									<dt>
										<small>03.</small>
									</dt>
									<dd>
										<label>
											<input type="checkbox" name="post_feat_image" value="yes" <?php if ( !empty( $st_Settings['post_feat_image'] ) && $st_Settings['post_feat_image'] == 'yes' ) echo 'checked'; ?> /> 
											<?php _e( 'Featured image', 'stkit' ) ?>
										</label>
										<small><?php _e( 'Display featured image on post page.', 'stkit' ) ?></small>
									</dd>
								</dl><?php

							}
						?>
		

						<!-------------------------------------------
							3.4 - Excerpt
						-------------------------------------------->

						<?php // Excerpt
							if ( $st_Options['panel']['major']['post']['excerpt'] ) { ?>	

								<dl>
									<dt>
										<small>04.</small>
									</dt>
									<dd>
										<label>
											<input type="checkbox" name="excerpt" value="yes" <?php if ( !empty( $st_Settings['excerpt'] ) && $st_Settings['excerpt'] == 'yes' ) echo 'checked'; ?> /> 
											<?php _e( 'Excerpt', 'stkit' ) ?>
										</label>
										<small><?php _e( 'Display excerpt on post page.', 'stkit' ) ?></small>
									</dd>
								</dl><?php

							}
						?>


						<!-------------------------------------------
							3.5 - Meta
						-------------------------------------------->

						<?php // Post meta
							if ( $st_Options['panel']['major']['post']['post_meta']['status'] ) { ?>

								<dl>
									<dt>
										<small>05.</small>
									</dt>
									<dd>
										<label>
											<input type="checkbox" name="post_meta" id="post_meta" class="checkbox-toggle" value="yes" <?php if ( !empty( $st_Settings['post_meta'] ) && $st_Settings['post_meta'] == 'yes' ) echo 'checked'; ?> />
											<?php _e( 'Meta', 'stkit' ) ?>
										</label>
										<small><?php _e( 'Author info, post views, nice time.', 'stkit' ) ?></small>		
			
										<div id="post_meta_box" class="checkbox-toggle-box">


											<!--- Author's info ------------------------------>

											<?php // Author's info
												if ( $st_Options['panel']['major']['post']['post_meta']['author_info'] ) { ?>
			
													<p>
														<label>
															<input type="checkbox" name="author_info" value="yes" <?php if ( !empty( $st_Settings['author_info'] ) && $st_Settings['author_info'] == 'yes' ) echo 'checked'; ?> /> 
															<?php _e( "Author's info", 'stkit' ) ?>
														</label>
														<small><?php _e( 'Display', 'stkit' ) ?> <a href="<?php echo 'http://en.gravatar.com/'; ?>">Gravatar</a> <?php _e( 'and', 'stkit' ) ?> <a href="<?php home_url() ?>/wp-admin/profile.php"><?php _e( "author's bio", 'stkit' ) ?></a> <?php _e( 'at the post page', 'stkit' ) ?>.</small>
													</p><?php

												}
											?>


											<!--- Post views ------------------------------>

											<?php // Post views
												if ( $st_Options['panel']['major']['post']['post_meta']['post_views'] ) { ?>
													<p>
														<label>
															<input type="checkbox" name="post_views" value="yes" <?php if ( !empty( $st_Settings['post_views'] ) && $st_Settings['post_views'] == 'yes' ) echo 'checked'; ?> /> 
															<?php _e( 'Post views', 'stkit' ) ?>
														</label>
														<small><?php _e( 'Number of views per each post.', 'stkit' ) ?></small>
													</p><?php

												}
											?>


											<!--- Nice time ------------------------------>

											<?php // Nice time
												if ( $st_Options['panel']['major']['post']['post_meta']['nice_time'] ) { ?>
													<p>
														<label>
															<input type="checkbox" name="nice_time" value="yes" <?php if ( !empty( $st_Settings['nice_time'] ) && $st_Settings['nice_time'] == 'yes' ) echo 'checked'; ?> /> 
															<?php _e( 'Nice time', 'stkit' ) ?>
														</label>
														<small><?php _e( 'e.g. <strong>3 days ago</strong> instead of', 'stkit' ) ?> <strong><?php echo date('F j, Y') ?></strong></small>
													</p><?php

												}
											?>


										</div>
									</dd>
								</dl><?php

							}
						?>


						<!-------------------------------------------
							3.6 - Under post
						-------------------------------------------->

						<?php // Under post
							if ( $st_Options['panel']['major']['post']['after_post'] ) { ?>	

								<dl>
									<dt>
										<small>06.</small>
									</dt>
									<dd>
										<label>
											<input type="checkbox" name="after_post" id="after_post" class="checkbox-toggle" value="yes" <?php if ( !empty( $st_Settings['after_post'] ) && $st_Settings['after_post'] == 'yes' ) echo 'checked'; ?> /> 
											<?php _e( 'Under post', 'stkit' ) ?>
										</label>
										<small><?php _e( 'Display custom data under a post. Shortcodes allowed.', 'stkit' ) ?></small>
										<div id="after_post_box" class="checkbox-toggle-box">
											<textarea name="after_post_data" /><?php echo esc_textarea( !empty( $st_Settings['after_post_data'] ) ? $st_Settings['after_post_data'] : '' ); ?></textarea>
										</div>
									</dd>
								</dl><?php

							}
						?>
		

						<!-------------------------------------------
							3.7 - Comments
						-------------------------------------------->

						<?php // Comments
							if ( $st_Options['panel']['major']['post']['post_comments'] ) { ?>	

								<dl>
									<dt>
										<small>07.</small>
									</dt>
									<dd>
										<label>
											<input type="checkbox" name="post_comments" id="post_comments" class="checkbox-toggle" value="yes" <?php if ( !empty( $st_Settings['post_comments'] ) && $st_Settings['post_comments'] == 'yes' ) echo 'checked'; ?> /> 
											<?php _e( 'Comments', 'stkit' ) ?>
										</label>
										<small><?php _e( 'Display comments.', 'stkit' ) ?></small>

										<div id="post_comments_box" class="checkbox-toggle-box">


											<!--- Website input field ------------------------------>

											<p>
												<label>
													<input type="checkbox" name="website_on_comments" value="yes" <?php if ( !empty( $st_Settings['website_on_comments'] ) && $st_Settings['website_on_comments'] == 'yes' ) echo 'checked'; ?> /> 
													<?php _e( 'Website the input field', 'stkit' ) ?>
												</label>
												<small><?php _e("Display the 'Website' input field on the comment form.", 'stkit' ) ?></small>
											</p>


											<!--- Pingbacks ------------------------------>

											<p>
												<label>
													<input type="checkbox" name="pingbacks" value="yes" <?php if ( !empty( $st_Settings['pingbacks'] ) && $st_Settings['pingbacks'] == 'yes' ) echo 'checked'; ?> /> 
													<?php _e( 'Pingbacks', 'stkit' ) ?>
												</label>
												<small><?php _e('Enable pingbacks.', 'stkit' ) ?></small>
											</p>


										</div>

									</dd>
								</dl><?php

							}
						?>


						<!-------------------------------------------
							3.8 - Related posts
						-------------------------------------------->

						<?php // Related posts
							if ( !empty($st_Options['panel']['major']['post']['related']) ) { ?>	

								<dl>
									<dt>
										<small>08.</small>
									</dt>
									<dd>
										<label>
											<input type="checkbox" name="related" value="yes" <?php if ( !empty( $st_Settings['related'] ) && $st_Settings['related'] == 'yes' ) echo 'checked'; ?> /> 
											<?php _e( 'Related posts', 'stkit' ) ?>
										</label>
										<small><?php _e( 'Display related posts.', 'stkit' ) ?></small>
									</dd>
								</dl><?php

							}
						?>


					</fieldset>


				</div><!-- #post --><?php

			}

		?>



		<!--=============================================
		
			P A G E
			Standard page
		
		==============================================-->

		<?php

			// Page tab
			if ( $st_Options['panel']['major']['page']['status'] ) {	?>

				<div id="page" class="panelTab">
			
					<fieldset class="panel-fieldset"><legend><?php _e( 'Page', 'stkit' ) ?></legend>
		
		
						<!-------------------------------------------
							4.1 - Comments
						-------------------------------------------->

						<?php // Comments
							if ( $st_Options['panel']['major']['page']['page_comments'] ) { ?>	

								<dl>
									<dt>
										<small>01.</small>
									</dt>
									<dd>
										<label>
											<input type="checkbox" name="page_comments" value="yes" <?php if ( !empty( $st_Settings['page_comments'] ) && $st_Settings['page_comments'] == 'yes' ) echo 'checked'; ?> /> 
											<?php _e( 'Comments', 'stkit' ) ?>
										</label>
										<small><?php _e( 'Display comments.', 'stkit' ) ?></small>
									</dd>
								</dl><?php

							}
						?>
		
		
					</fieldset>
			
				</div><!-- #page --><?php

			}

		?>



		<!--=============================================
		
			S I D E B A R
			Sidebar settings
		
		==============================================-->

		<?php

			// Sidebar tab
			if ( $st_Options['panel']['major']['sidebar']['status'] ) {	?>

				<div id="sidebar" class="panelTab">
			
		
					<!-------------------------------------------
						5.1 - Additional sidebars
					-------------------------------------------->

					<?php // Additional sidebars
						if ( $st_Options['panel']['major']['sidebar']['additional'] ) { ?>	

							<fieldset class="panel-fieldset"><legend><?php _e( 'Additional Sidebars', 'stkit' ) ?></legend>

								<dl>
									<dt>
										<span><?php _e( 'Quantity', 'stkit' ) ?></span>
									</dt>
									<dd>
										<input type="text" id="sidebar_qty" name="sidebar_qty" class="input-short" value="<?php echo esc_html( !empty( $st_Settings['sidebar_qty'] ) ? $st_Settings['sidebar_qty'] : 0 ); ?>" />
										<div class="slider-box"><div id="sidebar_qty-slider"></div></div>
										<div class="clear"><!-- --></div>
										<small><?php _e( 'If you need more sidebars besides standard, please, set a number you want, but at least 2.', 'stkit' ) ?></small>
									</dd>
								</dl>

							</fieldset><?php

						}
					?>

			
				</div><!-- #page --><?php

			}

		?>



	</div><!-- #themePanel -->



</form>