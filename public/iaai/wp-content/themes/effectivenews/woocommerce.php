<?php get_header(); ?>
    	
	<?php the_breadcrumb(); ?>
	
	<div class="page_title">
	    <h2><?php the_title(); ?></h2>
	    <span></span>
	</div>
	
        <div class="page_wrap">
            <div class="page_inner">
                
		<div class="entry-content">
		    <?php woocommerce_content(); ?>
		</div>
            </div>
        </div>
	
        </div>
        <!--wrap-->
	<?php if(eff_option('sidebar') == '3cleft' || eff_option('sidebar') == '3cright') { ?>
	<aside class="sec_sidebar sidebar">
	    <?php dynamic_sidebar( 'Secondary sidebar' ); ?>
	</aside>
	<?php } ?>
	<aside class='sidebar'>
	<?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('WooCommerce sidebar')){ }else { ?>
        	<p class="noside"><?php _e('There Is No Sidebar Widgets Yet', 'framework'); ?></p>
        <?php } ?>
	</aside>
        
    </div>
    <!--Main-->
    
<div class="clear"></div>

<?php get_footer(); ?>