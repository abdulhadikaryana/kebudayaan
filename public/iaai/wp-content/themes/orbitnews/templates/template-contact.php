<?php
/**
 * Template Name: Contact Page
 * Description: Contact Page Template with map Coordinates
 *
 * @package OrbitNews
 */

get_header(); ?>

	<!-- Content -->
	<section id="content" class="twelve column row pull-center singlepost">
 
		<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'content', 'page' ); ?>

		<?php endwhile; // end of the loop. ?>
		
		<section class="row mb25">
			<div class="seven column pull-right">
				<div id="map_extended" class="map_holder"></div></div>
					<?php
						// Get Contact form parameters from Option Tree
						if ( function_exists( 'ot_get_option' ) ) {
							$orn_contactform = ot_get_option( 'orn_contactform' );
							
							// Get Marker and Map Coordinates (Latitude and Longitude)
							
							$orn_map_coordinates = ot_get_option( 'orn_map_coordinates' );
							if ( strpos($orn_map_coordinates, ',') == true ) {
								// Get Lat and Long
								$orn_map_coordinates = explode (',', $orn_map_coordinates);
								$orn_map_lat = $orn_map_coordinates[0];
								$orn_map_long = $orn_map_coordinates[1];
							} else {
								// Invalid Coordinates
								$orn_map_lat = '42.661';
								$orn_map_long = '21.159';
							}
							
							// Get Marker Image or Put Default Placeholder
							$orn_map_marker = ot_get_option( 'orn_map_marker' );
							if ( empty( $orn_map_marker ) ) {
								$orn_map_marker = get_template_directory_uri() .  '/images/marker.png';
								$orn_iconpos = '10,30';
							} else {
								$orn_iconpos = '30,225';
							}
						}   
					?>
					<script type="text/javascript">
					jQuery(window).load(function() {
						jQuery("#map_extended").gMap({
							controls: false,
							scrollwheel: true,
							maptype: 'ROADMAP',
							markers: [
								{
									latitude: <?php echo $orn_map_lat ?>,
									longitude: <?php echo $orn_map_long ?>,
									icon: {
										image: "<?php echo $orn_map_marker; ?>",
										iconsize: [300, 300],
										iconanchor: [<?php echo $orn_iconpos; ?>]
									}
								},
							],
							latitude: <?php echo $orn_map_lat ?>,
							longitude: <?php echo $orn_map_long ?>,
							zoom: 15
						});
					});
					</script>
					<div class="five column pull-left">
						<?php
							if ( !empty( $orn_contactform ) ) {
							echo do_shortcode( '[contact-form-7 id="'. $orn_contactform .'" title="Main Contact Form"]' );
							}
						?>
					</div>
		</section>
	</section><!-- End Content Section -->

<?php get_footer(); ?>