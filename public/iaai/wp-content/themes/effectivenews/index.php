<?php get_header(); ?>
<?php effective_hp(); ?>
        <?php if(is_front_page() && eff_option('blog_style') == 'masonry' && eff_option('hp_display') == 'blog') { ?>
        <!--here-->
        <?php } else { ?>
        </div>
        <!--wrap-->
        <?php get_sidebar(); ?>
        <?php } ?>
        
        <?php if(eff_option('bottom_area') == true) { ?>
        <div class="bottom_area">
        <?php effective_bottom(); ?>
        </div>
        <?php } ?>
    </div>
    <!--Main-->
    <div class="clear"></div>
<?php get_footer(); ?>
