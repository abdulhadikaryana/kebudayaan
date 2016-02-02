<?php get_header(); ?>
	
	<div class="page_title">
                <h2><a href="<?php the_permalink();?>"><h1><?php the_title(); ?></h1></a></h2>
                <span></span>
            </div>
	
        <?php if(have_posts()) : while(have_posts()) : the_post('');?>
        <div class="attach_page">        
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
            <?php endwhile; ?>
            <?php  else:  ?>
            <div class="entry-content">
		<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'framework' ); ?></p>
            </div>
            <?php  endif; ?>
            <?php eff_pagination(); ?>
	    <?php wp_reset_query(); ?>
        </div>
        
    </div>
    <!--wrap-->
        
<?php get_sidebar(); ?>

</div>
<!--Main-->
    
<div class="clear"></div>

<?php get_footer(); ?>