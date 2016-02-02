<?php if(eff_option('sidebar') == '3cleft' || eff_option('sidebar') == '3cright') { ?>
<aside class="sec_sidebar sidebar">
    <?php dynamic_sidebar( 'Secondary sidebar' ); ?>
</aside>
<?php } ?>
<!--Sidebar-->
<aside class="sidebar">
    <?php
    if(is_home()) {
	$hpsidebar = eff_option('hp_sidebar');
	if($hpsidebar)
	dynamic_sidebar ( sanitize_title($hpsidebar) );          
	else dynamic_sidebar( 'Main sidebar' );	  
    } elseif (is_category()) {
	$catsidebar = eff_option('cat_sidebar');
	if($catsidebar)
	dynamic_sidebar ( sanitize_title($catsidebar) );          
	else dynamic_sidebar( 'Main sidebar' );
    } elseif (is_page()) {
	$pagesidebar = eff_option('pages_sidebar');
	if($pagesidebar)
	dynamic_sidebar ( sanitize_title($pagesidebar) );          
	else dynamic_sidebar( 'Main sidebar' );
    } elseif (is_single()) {
	$postsidebar = eff_option('posts_sidebar');
	if($postsidebar)
	dynamic_sidebar ( sanitize_title($postsidebar) );          
	else dynamic_sidebar( 'Main sidebar' );
    } else {
	dynamic_sidebar( 'Main sidebar' );
    }
    ?>
</aside>
<!--Sidebar--> 
<div class="clear"></div>