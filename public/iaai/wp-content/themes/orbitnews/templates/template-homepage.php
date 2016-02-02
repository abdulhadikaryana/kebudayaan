<?php
/**
 *  Template Name: Home Page
 * 	Custom Home Page template
 *
 * @package OrbitNews
 */

get_header(); ?>

    <?php
	$sidebar_pos = ot_get_option('orn_sidebar_home_layout');
	switch ($sidebar_pos) {
		case 'left':
		$content_pos = 'right'; 
		$column_size = 'eight';
		break;
		case 'right':
		$content_pos = 'left'; 
		$column_size = 'eight';
		break;
		case 'no-sidebar':
		$content_pos = 'center'; 
		$column_size = 'twelve';
		break;
		default:
		$content_pos = 'left'; 
		$column_size = 'eight';
	}
	?>
	<!-- Content -->
	<section id="content" class="<?php echo $column_size. ' column row pull-' . $content_pos; ?>">
	 
      <?php get_template_part('templates/flexislider'); ?>
      <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('home_page')): ?>	  
	  <div class="alert-box secondary"><h4>Go to Widgets, add multiple Home widgets to Home Widgets area.</h4><a href="#" class="close">x</a></div>
      <?php endif ?><!-- End if Sidebar Home Exists -->
	</section><!-- End Content Section -->
	
<?php if ( 'no-sidebar' != $sidebar_pos ) { get_sidebar(); } ?>
<?php get_footer(); ?>
