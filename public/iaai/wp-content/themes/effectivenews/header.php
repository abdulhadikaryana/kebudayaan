<?php
?><!DOCTYPE html>
    <!--[if IE 6]>
    <html id="ie6" <?php language_attributes(); ?>>
    <![endif]-->
    <!--[if IE 7]>
    <html id="ie7" <?php language_attributes(); ?>>
    <![endif]-->
    <!--[if IE 8]>
    <html id="ie8" <?php language_attributes(); ?>>
    <![endif]-->
    <!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
    <html <?php language_attributes(); ?> prefix="og: http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml">
    <!--<![endif]-->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <?php
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
                        wp_enqueue_script( 'comment-reply' );
                        
        wp_head();
    ?>
</head>
<?php $layout = '';
if( eff_option('sidebar') == '3cleft' ) $layout = ' tcol';
if( eff_option('sidebar') == '3cright' ) $layout = ' tcol'; ?>
<body <?php body_class($layout); ?>>
    <div class="background"></div>
    <?php if(eff_option('layout') == 'fixed') { ?>
    <!--Header Area-->
    <div class="boxed">
    <?php } ?>  
    <header>
	<?php if(eff_option('top_nav') == true) { ?>
        <div class="top_bar">
            <div class="inner">
                <?php if(eff_option('top_date')) { ?>
                <?php $date_format = eff_option('date_format'); ?>
                <div class="today_date">
                    <p><?php  echo date_i18n( $date_format , strtotime("11/15-1976") ); ?></p>
                </div>
                <?php } ?>
                <div class="t_menu">
                    <?php if ( has_nav_menu( 'topnav' ) ) { ?>
                        <?php  wp_nav_menu ( array( 'menu_class' => 'top_menu', 'theme_location' => 'topnav' )); ?>
                    <?php } ?>
                </div>
                <?php if ( has_nav_menu( 'topnav' ) ) { ?>
		<div class="mobileTopMenu_wrap">
		   <?php  echo wp_top_menu_select(); ?>
		</div>
                <?php } else { ?>
                <div class="mobileTopMenu_wrap">
                        <?php wp_dropdown_pages(array(
                                'name' => 'mobileTopMenu'
                        )); ?>
                </div>
                <?php } ?>
                <?php if(eff_option('h_social') == true) { ?>
                    <?php header_social(); ?>
                <?php } ?>
            </div>
        </div>
	<?php } ?>
	<?php if(eff_option('header_style') == 'style1') { ?>
	<?php if(eff_option('main_bar') == true) { ?>
	<div class="main_bar">
	    <div class="inner">
		<?php if(eff_option('breaking_en')) { ?>
		<?php eff_breaking(); ?>
		<?php } ?>
		
		<?php if(eff_option('h_search')) { ?>
		<div class="search_form">
		   <form method="get" id="s" action="<?php echo home_url(); ?>/">
			<input type="text" class="sf" name="s" id="search" value="<?php _e('Search ...', 'framework'); ?>" name="s" onfocus="if(this.value == '<?php _e('Search ...', 'framework'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Search ...', 'framework'); ?>';}">
			<div class="submit-container">
			<input type="submit" value="" class="submit">
			</div>
		    </form>
		</div>
		<?php } ?>
	    </div>
	</div>
	<?php } ?>
	<?php
	$logoclass = ''; 
	if( eff_option('logo_align') == 'center') $logoclass = 'align_center ';
	?>
        <div class="<?php echo $logoclass ; ?>header_content">
            <div class="inner">
                <div class="logo">
                    <?php if(eff_option('logo_type') == 'img') { ?>
                    <a href="<?php echo home_url(); ?>" title="<?php bloginfo('name') ;?>">
                        <img src="<?php echo eff_option('logo_img'); ?>" alt="<?php bloginfo('name') ;?>" >
                    </a>
                    <?php } elseif(eff_option('logo_type') == 'site_name') { ?>
                    <h1 id="site_title"><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span></h1>
		    <h2 id="site_desc"><?php bloginfo( 'description' ); ?></h2>
                    <?php } ?>
                </div>
                <?php if(eff_option('tbanner') == true) { ?>
                <?php eff_top_banner(); ?>
                <?php } ?>
            </div>
        </div>
    </header>
    <?php if(eff_option('stiky_nav') == true) { 
	eff_stiky();
    } ?>
    <nav class="navigation">
        <div class="inner">
            <?php if ( has_nav_menu( 'main' ) ) { ?>
                <?php  wp_nav_menu ( array( 'menu_class' => 'main_menu', 'theme_location' => 'main', 'walker' => new eff_Mega_Walker() )); ?>
            <?php } else { ?>
            <ul class="main_menu">
                <?php wp_list_pages(array(
                    'title_li' => false
                    )); ?>
            </ul>
            <?php } ?>
            
             <?php if ( has_nav_menu( 'main' ) ) { ?>
		<div class="mobileTopMenu_wrap">
		   <?php  echo wp_nav_menu_select(); ?>
		</div>
            <?php } else { ?>
                <div class="mobileTopMenu_wrap">
                        <?php wp_dropdown_pages(array(
                                'name' => 'mobileTopMenu'
                        )); ?>
                </div>
            <?php } ?>
        </div>
    </nav>
    <!--Header Area-->
    <?php } else { ?>
	<?php
	$logoclass = ''; 
	if( eff_option('logo_align') == 'center') $logoclass = 'align_center ';
	?>
        <div class="<?php echo $logoclass ; ?>header_content">
            <div class="inner">
                <div class="logo">
                    <?php if(eff_option('logo_type') == 'img') { ?>
                    <a href="<?php echo home_url(); ?>" title="<?php bloginfo('name') ;?>">
                        <img src="<?php echo eff_option('logo_img'); ?>" alt="<?php bloginfo('name') ;?>" >
                    </a>
                    <?php } elseif(eff_option('logo_type') == 'site_name') { ?>
                    <h1 id="site_title"><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span></h1>
		    <h2 id="site_desc"><?php bloginfo( 'description' ); ?></h2>
                    <?php } ?>
                </div>
                <?php if(eff_option('tbanner') == true) { ?>
                <?php eff_top_banner(); ?>
                <?php } ?>
            </div>
        </div>
    </header>
    <?php if(eff_option('stiky_nav') == true) { 
	eff_stiky();
    } ?>
    <nav class="navigation">
        <div class="inner">
            <?php if ( has_nav_menu( 'main' ) ) { ?>
                <?php  wp_nav_menu ( array( 'menu_class' => 'main_menu', 'theme_location' => 'main', 'walker' => new eff_Mega_Walker() )); ?>
            <?php } else { ?>
            <ul class="main_menu">
                <?php wp_list_pages(array(
                    'title_li' => false
                    )); ?>
            </ul>
            <?php } ?>
            
             <?php if ( has_nav_menu( 'main' ) ) { ?>
		<div class="mobileTopMenu_wrap">
		   <?php  echo wp_nav_menu_select(); ?>
		</div>
            <?php } else { ?>
                <div class="mobileTopMenu_wrap">
                        <?php wp_dropdown_pages(array(
                                'name' => 'mobileTopMenu'
                        )); ?>
                </div>
            <?php } ?>
        </div>
    </nav>
    <!--Header Area-->
    <?php if(eff_option('main_bar') == true) { ?>
    <div class="main_bar">
	<div class="inner">
	    <?php if(eff_option('breaking_en')) { ?>
	    <?php eff_breaking(); ?>
	    <?php } ?>
	    
	    <?php if(eff_option('h_search')) { ?>
	    <div class="search_form">
	       <form method="get" id="s" action="<?php echo home_url(); ?>/">
		    <input type="text" class="sf" name="s" id="search" value="<?php _e('Search ...', 'framework'); ?>" name="s" onfocus="if(this.value == '<?php _e('Search ...', 'framework'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Search ...', 'framework'); ?>';}">
		    <div class="submit-container">
		    <input type="submit" value="" class="submit">
		    </div>
		</form>
	    </div>
	    <?php } ?>
	</div>
    </div>
    <?php } ?>
    <?php } ?>
    <?php 
        $sidebar = '';
        if( eff_option('sidebar') == 'left' ) $sidebar = ' psidebar-left';
        if( eff_option('sidebar') == 'right' ) $sidebar = ' psidebar-right';
	if( eff_option('sidebar') == '3cleft' ) $sidebar = ' psidebar-left';
        if( eff_option('sidebar') == '3cright' ) $sidebar = ' psidebar-right';
 
        $ssidebar = '';
        $ssideoption = get_post_meta($post->ID, 'eff_sidebar_option', true);
        if( $ssideoption == 'lefts' ) $ssidebar = ' sidebar-left';
        if( $ssideoption == 'rights' ) $ssidebar = ' sidebar-right';
        if( $ssideoption == 'fullw' ) $ssidebar = ' sidebar-hide';
    ?>
    <?php if(is_front_page() && eff_option('hp_display') !== 'nb' && eff_option('blog_style') == 'masonry'){ ?>
    <div class="main_content_masonry">
        
        <?php if(eff_option('notification') == true) { ?>
            <?php eff_notification(); ?>
        <?php } ?>
        
    <?php } else { ?>
    <!--Main-->
    <div class="main_content<?php echo $sidebar; ?><?php echo $ssidebar ; ?>">
        
        <?php if(eff_option('notification') == true) { ?>
            <?php eff_notification(); ?>
        <?php } ?>
        <!--wrap-->
        <div class="wrap">
    <?php } ?>