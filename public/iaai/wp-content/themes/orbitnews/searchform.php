<?php
/**
 * The template for displaying search forms in OrbitNews
 *
 * @package OrbitNews
 */
?>

	
  <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input type="text" data-value="<?php _e('Search','orbitnews'); ?>" value="<?php _e('Search','orbitnews'); ?>" name="s">
    <input type="submit" value="">
  </form>
