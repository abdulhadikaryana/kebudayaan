<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <section id="inner-container">
 *
 * @package OrbitNews
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<?php if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
        header('X-UA-Compatible: IE=edge,chrome=1'); ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<title>
<?php wp_title( '|', true, 'right' ); ?>
</title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<!-- Header -->
<header class="clearfix"> 
	<!-- Top Menu -->
	<?php if (function_exists("wp_nav_menu")) { orbitnews_topmenu(); } ?>
	<!-- End Top Menu -->
	
	<div class="inner-header clearfix">
		<!-- Website Logo -->
		<div id="logo" class="left">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php 
				$logo_url = ot_get_option( 'orn_web_logo' );
				if ( !empty( $logo_url ) ) {
					echo ot_get_option( 'orn_web_logo' );
				} else {
					echo get_template_directory_uri() . '/images/logo.png';
				}
				?>" alt="<?php bloginfo( 'name' ); ?>">
			</a>
		</div>
        <!-- End Website Logo -->
  		<!-- Laderboard Ads -->    
		<?php 
			$header_ad_type    = ot_get_option('orn_header_leaderboard_type');
			$leader_adsense    = ot_get_option('orn_header_leaderboard_adsense');
			$leader_image      = ot_get_option('orn_header_leaderboard_image');
			$leader_image_link = ot_get_option('orn_header_leaderboard_image_link');
			switch ($header_ad_type) {
					case 'image':
					echo '<div class="ads-728x90 right"><a href="'. $leader_image_link .'"><img alt="'. $leader_image_link .'" src="'. $leader_image .'"></a></div>';
					break;
					case 'adsense':
					echo '<div class="ads-728x90 right">'. $leader_adsense .'</div>';
					break;
					case 'disabled':
					break;
			}
		?>
		<!-- End Laderboard Ads -->
	
</header>
<!-- End Header --> 
<!-- Container -->
<section class="container row clearfix">
<header class="clearfix"> 
  <!-- Main Menu -->
  <?php if (function_exists("wp_nav_menu")) { orbitnews_mainmenu(); } ?>
  <!-- End Main Menu -->
  <?php if ( 'on' == ot_get_option('orn_headersearch') ) : ?>
    <div class="search-bar right clearfix">
        <form action="<?php echo home_url(); ?>" id="searchform" method="get">
            <input name="s" type="text" data-value="">
        </form>
    </div>
  <?php endif; //end if show hide search ?>
</header>
<!-- Inner Container -->
<section class="inner-container clearfix">