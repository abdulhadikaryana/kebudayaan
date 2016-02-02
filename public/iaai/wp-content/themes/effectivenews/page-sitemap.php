<?php
/*
Template Name: Sitemap
*/
?>
<?php get_header(); ?>
    
        <?php if(get_post_meta($post->ID, 'eff_page_breadcrumb', true)) { ?>
	<?php the_breadcrumb(); ?>
        <?php } ?>
	
	<?php
	$ssidebar = '';
        $ssideoption = get_post_meta($post->ID, 'eff_sidebar_option', true);
	$comments = get_post_meta($post->ID, 'eff_page_comments', true);
	?>
	<div class="page_title">
	    <h2><?php the_title(); ?></h2>
	    <span></span>
	</div>
	
        <div class="page_wrap">
            <div class="page_inner">
                
		<div class="entry-content">
		    <?php the_content(); ?>
                    
                    <ul class="sitemap_page">
                        <li class="sitemap_col">
                            <div class="sitemap_title">
                                <h2><?php _e('Pages','framework'); ?></h2>
                            </div>
                            <ul>
                            <?php wp_list_pages('title_li='); ?>
                            </ul>
                        </li>
                        <li class="sitemap_col">
                            <div class="sitemap_title">
                                <h2><?php _e('Category','framework'); ?></h2>
                            </div>
                            <ul>
                            <?php wp_list_categories('title_li='); ?>
                            </ul>
                        </li>
                        <li class="sitemap_col">
                            <div class="sitemap_title">
                                <h2><?php _e('Tags','framework'); ?></h2>
                            </div>
                            <ul>
                            <?php $tags = get_tags();
                            if ($tags) {
                                foreach ($tags as $tag) {
                                    echo '<li><a href="' . get_tag_link( $tag->term_id ) . '">' . $tag->name . '</a></li> ';
                                }
                            } ?>
                            </ul>
                        </li>
                        <li class="sitemap_col">
                            <div class="sitemap_title">
                                <h2><?php _e('Authors','framework'); ?></h2>
                            </div>
                            <ul>
                            <?php wp_list_authors('optioncount=1&exclude_admin=0'); ?>
                            </ul>
                        </li>
                    </ul>
		</div>
            </div>
        </div>
        
	<?php if($comments) { ?>
	<?php comments_template(); ?>
	<?php } ?>
	
        </div>
        <!--wrap-->
        
	<?php if( $ssideoption !== 'fullw' ) { ?>
	<?php if(eff_option('sidebar') == '3cleft' || eff_option('sidebar') == '3cright') { ?>
	<aside class="sec_sidebar sidebar">
	    <?php dynamic_sidebar( 'Secondary sidebar' ); ?>
	</aside>
	<?php } ?>
        <aside class="sidebar">
            <?php global $wp_query; $postid = $wp_query->post->ID; $cus = get_post_meta($postid, 'sbg_selected_sidebar_replacement', true);?>
		<?php if ($cus != '') { ?>
		<?php if ($cus[0] != '0') { ?>
		     <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar($cus[0])){ }else { ?>
			<p class="noside"><?php _e('There Is No Sidebar Widgets Yet', 'framework'); ?></p>
		 <?php } ?>
		<?php } else { ?>
		 <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Main sidebar')){ }else { ?>
			<p class="noside"><?php _e('There Is No Sidebar Widgets Yet', 'framework'); ?></p>
		 <?php } ?>
		<?php } ?>
		<?php } else { ?>
		 <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Main sidebar')){ }else { ?>
			<p class="noside"><?php _e('There Is No Sidebar Widgets Yet', 'framework'); ?></p>
		 <?php } ?>
	    <?php } ?>
        </aside>
	<?php } ?>
        
    </div>
    <!--Main-->
    
<div class="clear"></div>

<?php get_footer(); ?>