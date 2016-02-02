<?php if ( !defined( 'ABSPATH' ) ) exit; ?><!DOCTYPE html>

<html <?php language_attributes(); ?>>

	<head>
		<title><?php wp_title( '-', true, 'right' ); bloginfo( 'name' ); ?></title>
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
	
		<div id="layout">
		
			<div id="header">

				<div id="header-layout-2">

					<div id="header-holder-2">

						<?php
							// Menu Secondary
							st_menu_secondary();

							// Icons the Social
							if ( function_exists( 'st_icons_social' ) ) {
								st_icons_social(); }
						?>

						<div class="clear"><!-- --></div>

					</div><!-- #header-holder-2 -->

				</div><!-- #header-layout-2 -->

				<div id="header-layout">

					<div id="header-holder">

						<div id="logo" class="div-as-table">
							<div>
								<div>
									<?php
										// Logo
										st_logo();
									?>
								</div>
							</div>
						</div><!-- #logo -->

						<div id="hcustom" class="div-as-table">
							<div>
								<div>
									<?php
										// Sidebar Ad A
										get_template_part( '/includes/sidebars/sidebar_ad_a' );
									?>
								</div>
							</div>
						</div><!-- #hcustom -->

						<div id="menu" class="div-as-table <?php global $st_Settings; if ( !empty( $st_Settings['stickymenu'] ) && $st_Settings['stickymenu'] == 'no' ) echo 'no-sticky-menu' ?>">
							<div>
								<div>
									<span id="menu-select"></span>
									<?php
										// Menu Primary
										st_menu_primary();
									?>
									<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search" id="search-form-header">
										<span></span>
										<input
											type="text"
											name="s"
											value=""
											placeholder="<?php _e( 'Search...', 'strictthemes' ) ?>"
										/>
									</form>
								</div>
							</div>
						</div><!-- #menu -->

						<div class="clear"><!-- --></div>

					</div><!-- #header-holder -->

				</div><!-- #header-layout -->

			</div><!-- #header -->