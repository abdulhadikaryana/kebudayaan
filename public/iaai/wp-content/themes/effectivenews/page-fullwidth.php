<?php
/*
Template Name: Full Width
*/
?>
<?php get_header(); ?>
    
    <?php if(get_post_meta($post->ID, 'eff_page_breadcrumb', true)) { ?>
    <?php the_breadcrumb(); ?>
    <?php } ?>
    
    </div>
    <!--wrap-->
    
    <div class="page_title">
	<h2><?php the_title(); ?></h2>
	<span></span>
    </div>
    
    <div class="page_wrap">
        <div class="page_inner">            
            <div class="entry-content">
		<?php the_content(); ?>
            </div>
        </div>
    </div>
    
    <?php if($comments) { ?>
	<?php comments_template(); ?>
    <?php } ?>
    
</div>
    <!--Main-->
    
<div class="clear"></div>

<?php get_footer(); ?>