<?php if(eff_option('related_style') == 'default') { ?> <ul> <?php } else { ?><ul class="related_list_ul"> <?php } ?>
<?php if (eff_option('related_type')  == 'tags') { ?>
    <?php
        global $post;
        $tags = wp_get_post_tags($post->ID);
        if ($tags) :
        $tag_ids = array();
        foreach($tags as $individual_tag){ $tag_ids[] = $individual_tag->term_id;}

        $args=array(
        'tag__in' => $tag_ids,
        'post__not_in' => array($post->ID),
        'showposts'=> eff_option('related_count'),
        'ignore_sticky_posts'=>1
        );

        query_posts($args);
    ?>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    
    <?php if(eff_option('related_style') == 'default') { ?>
        <li class="related_item_style1">
            <div class="related_image">
                <?php if (has_post_thumbnail( $post->ID )): ?>
                <div class="post_thumb">
                <?php
                $img = eff_post_image('medium');
                $Fimg = aq_resize($img,127, 92, true);
                ?>
                <?php if (strpos(eff_post_image(), 'youtube')) { ?>
                <img src="<?php echo eff_post_image(); ?>" width="127" height="92" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
                
                <?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
                    <img src="<?php echo eff_post_image(); ?>" width="127" height="92" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
                
                <?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
                    <img src="<?php echo eff_post_image(); ?>" width="127" height="92" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
                
                <?php } else { ?>
                    <img src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
                <?php } ?>
                </div>
                <?php endif; ?>
            </div> <!--Related Image-->
        
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    
        </li>
    <?php } else { ?>
    <li class="related_list">
        <h3><a href="<?php the_permalink(); ?>"><span><?php _e('&raquo; ', 'framework'); ?></span><?php the_title(); ?></a></h3>
    </li>
    <?php } ?>
    <?php endwhile; ?>
    <?php  else:  ?>
    <!-- Else in here -->
    <?php  endif; ?>
    <?php wp_reset_query(); ?>
    <?php endif;?>
    
    <?php } else { ?>
    
    <?php
        global $post;
        $cats = get_the_category($post->ID);
        if ($cats) :
            $cat_ids = array();
            foreach($cats as $individual_cat){ $cat_ids[] = $individual_cat->cat_ID;}
        
            $args=array(
                'category__in' => $cat_ids,
                'post__not_in' => array($post->ID),
                'showposts'=>eff_option('related_count'),
                'ignore_sticky_posts'=>1
            );
        query_posts($args);
    ?>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    
    <?php if(eff_option('related_style') == 'default') { ?>
    <li class="related_item_style1">
        <div class="related_image">
            <?php if (has_post_thumbnail( $post->ID )): ?>
            <div class="post_thumb">
            <?php if (eff_post_image() != false) { ?>
                                        <?php
                                        $img = eff_post_image('medium');
                                        $Fimg = aq_resize($img,126, 91, true);
                                        ?>
                                        <a href="<?php the_permalink(); ?>"><img src="<?php echo $Fimg; ?>" alt="<?php the_title(); ?>"></a>
            <?php } ?>
            </div>
            <?php endif; ?>
        </div> <!--Related Image-->
        
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

    </li>
    <?php } else { ?>
    <li class="related_list">
        <h3><a href="<?php the_permalink(); ?>"><span><?php _e('&raquo; ', 'framework'); ?></span><?php the_title(); ?></a></h3>
    </li>
    <?php } ?>
    <?php endwhile; ?>
    <?php  else:  ?>
    <!-- Else in here -->
    <?php  endif; ?>
    <?php wp_reset_query(); ?>
    <?php endif;?>
    <?php } ?>
</ul>