    <div class="clear"></div>
    <?php if(eff_option('bbanner') == true) { ?>
    <?php eff_bottom_banner(); ?>
    <?php } ?>
    <!--Footer-->
    <span class="footer_border"></span>
    <footer>
        <div class="inner">
	    <?php $footer_layout = eff_option('foot_layout'); if ( $footer_layout == 'third') { ?>
           <div class="footer_widget one_third">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 1')){ }else { ?>
	        <?php } ?>

			</div><!-- End third col -->
			<div class="footer_widget one_third">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 2')){ }else { ?>
	        <?php } ?>
			</div><!-- End third col -->
			<div class="footer_widget one_third last">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 3')){ }else { ?>
	        <?php } ?>

			</div><!-- End third col -->
	    <?php } elseif ($footer_layout == 'one') { ?>
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 1')){ }else { ?>
	        <?php } ?>
	    <?php } elseif ($footer_layout == 'one_half') { ?>
			<div class="footer_widget one_half">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 1')){ }else { ?>
	        <?php } ?>
			</div>
			<div class="footer_widget one_half last">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 2')){ }else { ?>
	        <?php } ?>
			</div>
	    <?php } elseif ($footer_layout == 'fourth') { ?>
			<div class="footer_widget one_fourth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 1')){ }else { ?>
	        <?php } ?>
			</div>
			<div class="footer_widget one_fourth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 2')){ }else { ?>
	        <?php } ?>
			</div>
			<div class="footer_widget one_fourth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 3')){ }else { ?>
	        <?php } ?>
			</div>
			<div class="footer_widget one_fourth last">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 4')){ }else { ?>
	        <?php } ?>
			</div>
	    <?php } elseif ($footer_layout == 'fifth') { ?>
			<div class="footer_widget one_fifth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 1')){ }else { ?>
	        <?php } ?>
			</div>
			<div class="footer_widget one_fifth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 2')){ }else { ?>
	        <?php } ?>
			</div>
			<div class="footer_widget one_fifth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 3')){ }else { ?>
	        <?php } ?>
			</div>
			<div class="footer_widget one_fifth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 4')){ }else { ?>
	        <?php } ?>
			</div>
			<div class="footer_widget one_fifth last">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 5')){ }else { ?>
	        <?php } ?>
			</div>
	    <?php } elseif ($footer_layout == 'sixth') { ?>
			<div class="footer_widget one_sixth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 1')){ }else { ?>
	        <?php } ?>
			</div>
			<div class="footer_widget one_sixth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 2')){ }else { ?>
	        <?php } ?>
			</div>
			<div class="footer_widget one_sixth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 3')){ }else { ?>
	        <?php } ?>
			</div>
			<div class="footer_widget one_sixth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 4')){ }else { ?>
	        <?php } ?>
			</div>
			<div class="footer_widget one_sixth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 5')){ }else { ?>
	        <?php } ?>
			</div>
			<div class="footer_widget one_sixth last">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 6')){ }else { ?>
	        <?php } ?>
			</div>

    	    <?php } elseif ($footer_layout == 'half_twop') { ?>
	    		<div class="footer_widget one_half">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 1')){ }else { ?>
	        <?php } ?>
			</div>

	    		<div class="footer_widget one_fourth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 2')){ }else { ?>
	        <?php } ?>
			</div>

	    		<div class="footer_widget one_fourth last">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 3')){ }else { ?>
	        <?php } ?>
			</div>
	    
    	    <?php } elseif ($footer_layout == 'twop_half') { ?>
	    		<div class="footer_widget one_fourth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 1')){ }else { ?>
	        <?php } ?>
			</div>

	    		<div class="footer_widget one_fourth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 2')){ }else { ?>
	        <?php } ?>
			</div>

	    		<div class="footer_widget one_half last">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 3')){ }else { ?>
	        <?php } ?>
			</div>

    	    <?php } elseif ($footer_layout == 'half_threep') { ?>
	    		<div class="footer_widget one_half">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 1')){ }else { ?>
	        <?php } ?>
			</div>

	    		<div class="footer_widget one_sixth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 2')){ }else { ?>
	        <?php } ?>
			</div>

	    		<div class="footer_widget one_sixth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 3')){ }else { ?>
	        <?php } ?>
			</div>

	    		<div class="footer_widget one_sixth last">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 4')){ }else { ?>
	        <?php } ?>
			</div>
    	    <?php } elseif ($footer_layout == 'threep_half') { ?>

	    		<div class="footer_widget one_sixth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 1')){ }else { ?>
	        <?php } ?>
			</div>

	    		<div class="footer_widget one_sixth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 2')){ }else { ?>
	        <?php } ?>
			</div>

	    		<div class="footer_widget one_sixth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 3')){ }else { ?>
	        <?php } ?>
			</div>

	    		<div class="footer_widget one_half last">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 4')){ }else { ?>
	        <?php } ?>
			</div>

    	    <?php } elseif ($footer_layout == 'third_threep') { ?>
	    		<div class="footer_widget one_third">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 1')){ }else { ?>
	        <?php } ?>
			</div>

	    		<div class="footer_widget one_fifth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 2')){ }else { ?>
	        <?php } ?>
			</div>

	    		<div class="footer_widget one_fifth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 3')){ }else { ?>
	        <?php } ?>
			</div>

	    		<div class="footer_widget one_fifth last">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 4')){ }else { ?>
	        <?php } ?>
			</div>


    	    <?php } elseif ($footer_layout == 'threep_third') { ?>

	    		<div class="footer_widget one_fifth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 1')){ }else { ?>
	        <?php } ?>
			</div>

	    		<div class="footer_widget one_fifth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 2')){ }else { ?>
	        <?php } ?>
			</div>

	    		<div class="footer_widget one_fifth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 3')){ }else { ?>
	        <?php } ?>
			</div>
			
			<div class="footer_widget one_third last">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 4')){ }else { ?>
	        <?php } ?>
			</div>

    	    <?php } elseif ($footer_layout == 'third_fourp') { ?>
			<div class="footer_widget one_third">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 1')){ }else { ?>
	        <?php } ?>
			</div>

	    		<div class="footer_widget one_sixth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 2')){ }else { ?>
	        <?php } ?>
			</div>

	    		<div class="footer_widget one_sixth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 3')){ }else { ?>
	        <?php } ?>
			</div>

	    		<div class="footer_widget one_sixth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 4')){ }else { ?>
	        <?php } ?>
			</div>

	    		<div class="footer_widget one_sixth last">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 5')){ }else { ?>
	        <?php } ?>
			</div>


       	    <?php } elseif ($footer_layout == 'fourp_third') { ?>
	    		<div class="footer_widget one_sixth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 1')){ }else { ?>
	        <?php } ?>
			</div>

	    		<div class="footer_widget one_sixth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 2')){ }else { ?>
	        <?php } ?>
			</div>

	    		<div class="footer_widget one_sixth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 3')){ }else { ?>
	        <?php } ?>
			</div>

	    		<div class="footer_widget one_sixth">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 4')){ }else { ?>
	        <?php } ?>
			</div>
	    
	    <div class="footer_widget one_third last">
		<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 5')){ }else { ?>
	        <?php } ?>
			</div>

	    <?php } ?>
        </div>
    </footer>
    <div class="copyright">
        <div class="inner">
            <div class="copyrights">
                <p><?php echo htmlspecialchars_decode(eff_option('footer_text')) ?></p>
            </div>
            
            <?php if(eff_option('b_social') == true) { ?>
                <?php bottom_social(); ?>
            <?php } ?>
            
        </div>
    </div>
    <!--Footer-->
    <?php if(eff_option('totop')) { ?>
    <div class="to_top" title="Scroll To Top">scroll to top</div>
    <?php } ?>
    <?php if(eff_option('layout') == 'fixed') { ?>
    </div>
    <?php } ?>
<?php wp_footer(); ?>
</body>
</html>