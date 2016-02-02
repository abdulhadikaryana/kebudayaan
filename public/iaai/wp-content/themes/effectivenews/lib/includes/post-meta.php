<span class="p_meta">
<?php if(eff_option('meta_date')) { ?>
<span class="date"><?php the_time('F j, Y g:i a') ?></span>
<?php } ?>
<?php if(eff_option('meta_author')) { ?>
<span class="author"><?php _e( 'by: ' , 'framework' ); ?> <a rel="author" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) )?>" title="<?php sprintf( esc_attr__( 'View all posts by %s', 'framework' ), get_the_author() ) ?>"><?php echo get_the_author() ?> </a></span>
<?php } ?>
<?php if(eff_option('meta_cat')) { ?>
<span class="category"><?php _e( 'Category: ' , 'framework' ); ?><?php printf('%1$s', get_the_category_list( ', ' ) ); ?></span>
<?php } ?>
<?php if(eff_option('meta_comment')) { ?>
<span class="comments"><?php comments_popup_link( __( 'Leave a comment', 'framework' ), __( '1 Comment', 'framework' ), __( '% Comments', 'framework' ) ); ?></span>
<?php } ?>
<?php if(eff_option('meta_resize')) { ?>
<span class="resize-t"><a id="increase-font" href="#"> A+ </a>/<a id="decrease-font" href="#"> A- </a> </span></span>
<?php } ?>
