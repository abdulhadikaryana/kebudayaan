<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <main id="main">
 *
 * @package Generate
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body itemtype="http://schema.org/WebPage" itemscope="itemscope" <?php body_class(); ?>>
	<?php do_action( 'generate_before_header' ); ?>
	<header itemtype="http://schema.org/WPHeader" itemscope="itemscope" id="masthead" role="banner" <?php generate_header_class(); ?>>
		<div <?php generate_inside_header_class(); ?>>
			<?php do_action( 'generate_inside_header'); ?>
			
			<?php if ( is_active_sidebar('header') ) : ?>
				<div class="header-widget">
					<?php dynamic_sidebar( 'header' ); ?>
				</div>
			<?php endif; // end sidebar widget area ?>
		
			<?php if ( !get_theme_mod( 'generate_title' ) || !get_theme_mod( 'generate_tagline' ) ) : ?>
				<div class="site-branding">
				<?php if ( !get_theme_mod( 'generate_title' ) ) : ?>
					<p class="main-title" itemprop="headline"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php endif;
				
				if ( !get_theme_mod( 'generate_tagline' ) ) : ?>
					<p class="site-description"><?php bloginfo( 'description' ); ?></p>
				<?php endif; ?>
				</div>
			<?php endif;
			
			if ( get_theme_mod( 'generate_logo' ) ) : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img class="header-image" src="<?php echo get_theme_mod( 'generate_logo' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" /></a>
			<?php endif; ?>
		</div><!-- .inside-header -->
	</header><!-- #masthead -->
	<?php do_action( 'generate_after_header' ); ?>
	
	<div id="page" class="hfeed site grid-container container grid-parent">
		<div id="content" class="site-content">