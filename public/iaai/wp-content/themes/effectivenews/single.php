<?php get_header(); ?>
    
    <?php the_breadcrumb(); ?>
    
    <?php
	$ssidebar = '';
        $ssideoption = get_post_meta($post->ID, 'eff_sidebar_option', true);
	$above_b = get_post_meta($post->ID, 'eff_cus_abanner',true);
	$below_b = get_post_meta($post->ID, 'eff_cus_bbanner',true);
    ?>
	
        <div class="page_wrap">
            <div class="page_inner">
		    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php
			$type = get_post_meta($post->ID, 'eff_article_type',true);
			$image = get_post_meta($post->ID, 'eff_slider_option',true);
			$video_type = get_post_meta($post->ID, 'eff_video_type',true);
			$mvideo_id = get_post_meta($post->ID, 'eff_video_id',true);
			$audio_link = get_post_meta($post->ID, 'eff_audio_url',true);
			?>
			
			<?php if ($type == 'video') { ?>
			<div class="video_frame">
			<?php if ($video_type == 'youtube') { ?>
			<iframe width="100%" height="350" src="http://www.youtube.com/embed/<?php echo $mvideo_id; ?>" frameborder="0" allowfullscreen></iframe>
			 <?php } elseif ($video_type == 'vimo') { ?>
			<iframe src="http://player.vimeo.com/video/<?php echo $mvideo_id; ?>?title=0&amp;portrait=0&amp;badge=0" width="100%" height="350px" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
			<?php } elseif ($video_type == 'daily') { ?>
			<iframe frameborder="0" width="100%" height="350" src="http://www.dailymotion.com/embed/video/<?php echo $mvideo_id ?>?logo=0"></iframe>
			<?php } ?>
			</div>
			<?php } elseif ($type == 'slider') { ?>
			<div class="postSlideshow p_slider">
			<?php
			global $wpdb;
			$images = get_post_meta($post->ID, 'eff_slider_option', false );
			$images = implode( ',' , $images );
			// Re-arrange images with 'menu_order'
			$images = $wpdb->get_col( "
			    SELECT ID FROM {$wpdb->posts}
			    WHERE post_type = 'attachment'
			    AND ID in ({$images})
			    ORDER BY menu_order ASC
			" );
			foreach ( $images as $att )
			{
			    // Get image's source based on size, can be 'thumbnail', 'medium', 'large', 'full' or registed post thumbnails sizes
			    $src = wp_get_attachment_image_src( $att, 'large' );
			    $src = $src[0];
			    // Show image
			?>
			<img width="630px" height="395px" src="<?php echo $src; ?>">
			<?php } ?>
			</div>
			<div class="slideshowControl">
			<a class="slide_next"></a>
			<a class="slide_prev"></a>
			<div class="slidePager"></div>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
		
				//inner slideshow
				$('.postSlideshow').cycle({
				timeout:0,
				speed: 'normal',
				pager:  '.slidePager',
				next:'.slide_next',
				prev:'.slide_prev',
				before: resize_slideshow
				});
				
				function resize_slideshow(curr, next, opts, fwd){
				//get the height of the current slide
				var $ht = $(this).height();
				//set the container's height to that of the current slide
				$(this).parent().animate({
				height : $ht
				});
				}
	
				$('.postSlideshow').click(function() {
					$('.postSlideshow').cycle('next');
				});
		
				});
			</script>
			<?php } elseif ($type == 'audio') { ?>
			<div class="soundcloud">
			<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=<?php echo $audio_link; ?>"></iframe>
			</div>
			<?php } elseif ($type == 'featured') { ?>
			<div class="f_post_thumb">
			<?php eff_thumb('', 588 , 330 ); ?>
			</div>
			<?php } ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
		    <div class="post_header">
			<h2><?php the_title(); ?></h2>
			<?php
			$pmeta = get_post_meta($post->ID, 'eff_pmeta', true);
			if(! empty( $pmeta )) { 
			if(eff_option('post_meta') == true) {
			get_template_part('lib/includes/post-meta');
			}
			}
			?>
		    </div>
		    
		    <?php $get_meta = get_post_custom($post->ID);  ?>
								
		    <?php if ($above_b) { //Above Post Banner ?>
		    <div class="above-banner"><?php echo $above_b ?></div>
		    <?php } ?>
		    
		    <div class="entry-content resize">
			<?php
			    $rt_position = get_post_meta($post->ID, 'eff_review_position', true);
			    if ($rt_position == 'top') { 
			    if(function_exists('eff_review')) { echo eff_review('rt_float'); }
			    }
			?>
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="my-paginated-posts">' . __( 'Pages:', 'framework' ), 'after' => '</div>' ) ); ?>
			<?php
			    $rt_position = get_post_meta($post->ID, 'eff_review_position', true);
			    if ($rt_position == 'bottom') { 
			    if(function_exists('eff_review')) { echo eff_review(''); }
			    }
			?>
		    </div>
		    
		    <?php the_tags( '<span style="display:none">',' ', '</span>'); ?>
		    <span style="display:none" class="updated"><?php the_time( 'Y-m-d' ); ?></span>
		    <div style="display:none" class="vcard author" itemprop="author" itemscope itemtype="http://schema.org/Person"><strong class="fn" itemprop="name"><?php the_author_posts_link(); ?></strong></div>
		    <div style="display: none;">
		    <?php $score = get_post_meta($post->ID, 'eff_rt_final_score_stars', true); ?>
		    <div itemscope itemtype="http://data-vocabulary.org/Review">
		    <span itemprop="itemreviewed"><?php the_title(); ?></span>
		    Reviewed by <span itemprop="reviewer"><?php the_author_posts_link(); ?></span> on
		    <time itemprop="dtreviewed" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php the_time('M d') ?></time>.
		    <span itemprop="summary"><?php echo wp_html_excerpt(get_the_content(), 160); ?></span>
		    <span itemprop="description"><?php echo wp_html_excerpt(get_the_content(), 160); ?></span>
		    Rating: <span itemprop="rating"><?php echo $score; ?></span>
		    </div>
		    </div>
		    
		    <?php if ($below_b) { //Below Post Banner ?>
		    <div class="above-banner"><?php echo $below_b ?></div>
		    <?php } ?> 
		    
		</article>
		<?php endwhile; ?>
		<?php endif; ?>
		<?php wp_reset_query(); ?>
            </div>
	    <?php
	    $postshare = get_post_meta($post->ID, 'eff_pshare', true);
	    if(! empty( $postshare )) {
	    if(eff_option('share_posts') == true) {
	    ?>
	    <div class="article_footer">
		
	    <?php if(eff_option('post_tags') == true) { ?>
		<div class="post_tags">
		    <?php the_tags('<p><span class="tags-title">Tags : </span> ' , '  ' , '</p>'); ?>
		</div>
	    <?php } ?>
    
	    <?php get_template_part('lib/includes/post-share'); ?>
		
	    </div>
	    <?php } ?>
	    <?php } ?>
        </div>
	
	<?php if(eff_option('post_nav') == true) { 
	    $next_post = get_next_post();
	    $prev_post = get_previous_post();
	    $next_title = get_the_title($next_post);
	    $prev_title = get_the_title($prev_post);
	    if (strlen($prev_title) >=35 ) {
		$prev_title = wp_html_excerpt($prev_title, 35) . '...' ;
	    }
	    if (strlen($next_title) >=35 ) {
		$next_title = wp_html_excerpt($next_title, 35) . '...' ;
	    }
	?>
	<div class="post-nav">
	    <?php
	    previous_post_link('<span class="nex">%link</span>', $prev_title); 
	    next_post_link('<span class="prev">%link</span>', $next_title);
	    ?>
	</div>
	<?php } ?>
	
	
	<?php
	$author = get_post_meta($post->ID, 'eff_pauthor', true);
	if( ! empty( $author )) { 
	    if(eff_option('author_box')) { get_template_part('lib/includes/author-box'); } 
	} ?>
	
	
	    <?php
	    $related = get_post_meta($post->ID, 'eff_prelated', true);
	    if(! empty( $related )) { 
	    if(eff_option('relate_posts')) {
	    ?>
	    <div class="block">
		<div class="block_box_title">
		    <h2><?php _e( 'Related Posts', 'framework' ) ?></h2>
		    <span></span>
		</div>
		
		<?php
		$related_style = '';
		if( eff_option('related_style') == 'default' ) $related_style = ' related_posts';
		?>
		<section class="section_box<?php echo $related_style ; ?>">
		    <div class="content_inner">
			<?php get_template_part('lib/includes/related-posts'); ?>
		    </div>
		</section>
	    </div>
	    <?php } 
	    } ?>
	
	<?php
	$comments = get_post_meta($post->ID, 'eff_page_comments', true);  
	if(! empty( $comments )) { ?>
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