<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package OrbitNews
 */
?>

<?php
	// Restore $wp_query and global post data to the original main query	  
	wp_reset_query();
	
	// Setup Sidebar and Sidebar Layout
	$sidebar 	  = orbitnews_sidebars($post->ID);  // Get sidebar array
	$sidebar_pos  = $sidebar['layout'];		 		// Get sidebar layout
	$sidebar_name = $sidebar['name'];		 		// Get sidebar name
 
?>
  
<aside id="sidebar" class="four column pull-<?php echo $sidebar_pos; ?>">
    <ul class="no-bullet">
    <?php do_action( 'before_sidebar' ); ?>
           
    <?php if ( ! dynamic_sidebar( $sidebar_name ) ) : ?>

        <aside id="search" class="widget search_form">
            <?php get_search_form(); ?>
        </aside>

    <?php endif; // end sidebar widget area ?>
    </ul>
</aside><!-- aside -->
    