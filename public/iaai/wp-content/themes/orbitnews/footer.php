<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package OrbitNews
 */
?>
	
			<!-- Footer -->
			<footer class="row clearfix" id="site-footer">
    			<!-- Footer widgets -->
				<ul class="no-bullet clearfix">
    			<?php if (function_exists('dynamic_sidebar')) { dynamic_sidebar('footer'); } ?>
   		 		</ul><!-- End Footer widgets -->
               	<div class="copyright clearfix">
					<?php 
					$footer_text = ot_get_option( 'orn_copyrighttext' );
					if ( !empty($footer_text) ) {
						echo ot_get_option( 'orn_copyrighttext' );
					} else {
						echo '&copy; Copyright '. date( 'Y' ) .' - ' . get_bloginfo( 'name' );
					}
				?>
				</div>
				<?php if ( 'on' == ot_get_option('orn_gototop') ) : ?>
                  <div id="back-to-top" class="right">
                      <a href="#top">Go to Top</a>
                  </div>
                <?php endif; // Endif Go To Top ?>
			</footer><!-- End Footer -->
       </section><!-- End Inner Container -->
	</section><!-- End Content Section -->
	<?php
		// Google Analytics Code
		$orn_googleanalytics = ot_get_option( 'orn_googleanalytics' );
   		if ( $orn_googleanalytics ) {
				echo $orn_googleanalytics;	
		}
		// Add WP Footer functions
		wp_footer(); 
	?>

</body>
</html>