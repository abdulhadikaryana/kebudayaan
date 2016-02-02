<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package OrbitNews
 */

if ( ! function_exists( 'orbitnews_paginate' ) ) :
/**
 *  Display navigation to next/previous set of posts when applicable.
 *  Pagination by Kriesi.at
 */
 
function orbitnews_paginate($pages = '', $range = 2)
{
    global $data;

     $showitems = ($range * 2)+1;

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }

     if(1 != $pages)
     {
         echo "<div class='pagenation clearfix'><ul class='no-bullet'>";
         //if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link(1)."'>&laquo; First</a></li>";
         if($paged > 1) echo "<li><a class='pagination-prev' href='".get_pagenum_link($paged - 1)."'>".__('&laquo; Previous', 'orbitnews')."</li></a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<li class='active'><a>".$i."</a></li>":"<li><a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a></li>";
             }
         }

         if ($paged < $pages) echo "<li><a class='pagination-next' href='".get_pagenum_link($paged + 1)."'>".__('Next &raquo;', 'orbitnews')."</a></li>";
         //if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($pages)."'>Last &raquo;</a></li>";
         echo "</ul></div>\n";
     }
}
endif; // orbitnews_paginate()

if ( ! function_exists( 'orbitnews_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function orbitnews_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'post-navigation' : 'paging-navigation';

	?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>  clearfix">

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '', 'Previous post link', 'orbitnews' ) . '</span> %title ' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', ' %title <span class="meta-nav">' . _x( '', 'Next post link', 'orbitnews' ) . '</span>' ); ?>
	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="alignleft"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'orbitnews' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="alignright"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'orbitnews' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php
}
endif; // orbitnews_content_nav()

if ( ! function_exists( 'orbitnews_topmenu' ) ) :
/**
 * Top Menu Configuration
 */
function orbitnews_topmenu() {
	wp_nav_menu(
		array(
			'theme_location'  => 'top_menu',
			'menu'            => 'Top Menu', 
			'container'       => 'nav', 
			'container_class' => 'clearfix', 
			'container_id'    => 'top-menu',
			'menu_class'      => 'no-bullet inline-list m0', 
			'menu_id'         => '',
			'echo'            => true,
			'fallback_cb'     => 'orbitnews_fallback_menu',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'           => -1,
			'walker'		   => ''
		)
	);
}
endif; // orbitnews_topnmenu

if ( ! function_exists( 'orbitnews_mainmenu' ) ) :
/**
 * Main Menu Configuration
 */
function orbitnews_mainmenu() {
	wp_nav_menu(
		array(
			'theme_location'  => 'main_menu',
			'menu'            => 'Main Menu', 
			'container'       => 'nav', 
			'container_class' => 'left navigation', 
			'container_id'    => 'main-menu',
			'menu_class'      => 'sf-menu no-bullet inline-list m0', 
			'menu_id'         => 'header-menu',
			'echo'            => true,
			'fallback_cb'     => 'orbitnews_fallback_menu',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'           => 0,
			'walker'		   => ''
		)
	);
}
endif; // orbitnews_mainmenu

if ( ! function_exists( 'orbitnews_fallback_menu' ) ) :
/**
 * Fallback Menu Function
 */
function orbitnews_fallback_menu( $args ) {
    
    extract( $args );
	
	if ( ! current_user_can( 'manage_options' ) ) {
       $link = $link_before .'<a href="'. home_url('/') .'">'. $before .'Home'. $after .'</a>' . $link_after;
    } else {
	   $link = $link_before .'<a href="'. admin_url('nav-menus.php') .'">'. $before .'Add a menu'. $after .'</a>' . $link_after;
	}

    // We have a list
    if ( FALSE !== stripos( $items_wrap, '<ul' ) || FALSE !== stripos( $items_wrap, '<ol' ) ) {
        $link = "<li>$link</li>";
    }

    $output = sprintf( $items_wrap, $menu_id, $menu_class, $link );
    
	if ( ! empty ( $container ) ) {
        $output  = "<$container class='$container_class' id='$container_id'>$output</$container>";
    }

    if ( $echo ) {
        echo $output;
    }

    return $output;
}
endif; // orbitnews_fallback_menu 

if ( ! function_exists( 'orbitnews_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function orbitnews_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class('depth-1'); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', 'orbitnews' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'orbitnews' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
				<div class="author-avatar">
					<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
				</div><!-- .comment-author -->
				<div class="comment-author"><?php comment_author(); ?></div>
					<div class="comment-date">                    
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'orbitnews' ), get_comment_date(), get_comment_time() ); ?>
						</time>
                    </div>
					
			<div class="comment-text">
				<?php comment_text(); ?>
			</div><!-- .comment-content -->
			<div class="comment-reply-edit">
			<?php
				comment_reply_link( array_merge( $args, array(
					'add_below' => 'div-comment',
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'before'    => '',
					'after'     => '',
				) ) );
			?>
             <?php edit_comment_link( __( 'Edit', 'orbitnews' )); ?>
            </div><!-- .comment-reply-edit -->          
				<?php if ( '0' == $comment->comment_approved ) : ?>
                <div class="four column">
					<div class="comment-awaiting-moderation alert-box secondary"><?php _e( 'Your comment is awaiting moderation.', 'orbitnews' ); ?>
                	<a href="#" class="close">&times;</a>
                	</div>
                </div>
				<?php endif; ?>
		</article><!-- .comment-body -->

	<?php
	endif;
}
endif; // orbitnews_comment()

if ( ! function_exists( 'custom_excerpt' ) ) :
/**
 * Custom Excerpt with wp_trim_words
 */
function custom_excerpt($num_words) {
	$trimexcerpt = get_the_excerpt();
	if ( empty( $num_words ) ) {
		$num_words='';
	}
	$shortexcerpt = wp_trim_words( $trimexcerpt, $num_words ); 
	echo $shortexcerpt; 
}
endif; // custom_excerpt()

if ( ! function_exists( 'orbitnews_the_attached_image' ) ) :
/**
 * Prints the attached image with a link to the next attached image.
 */
function orbitnews_the_attached_image() {
	$post                = get_post();
	$attachment_size     = apply_filters( 'orbitnews_attachment_size', array( 935, 700 ) );
	$next_attachment_url = wp_get_attachment_url();

	/**
	 * Grab the IDs of all the image attachments in a gallery so we can get the
	 * URL of the next adjacent image in a gallery, or the first image (if
	 * we're looking at the last image in a gallery), or, in a gallery of one,
	 * just the link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id )
			$next_attachment_url = get_attachment_link( $next_id );

		// or get the URL of the first image attachment.
		else
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
	}

	printf( '<a href="%1$s" class="th" rel="attachment">%2$s</a>',
		esc_url( $next_attachment_url ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	); 
}
endif; // orbitnews_the_attached_image()

if ( ! function_exists( 'orbitnews_sidebars' ) ) :
/**
 *  Custom Sidebar & Sidebar layout with conditional formating
 */
function orbitnews_sidebars($post_ID = null) {
	
	$post_ID = $post_ID ? $post_ID : false;
	$sidebar['layout'] = 'right'; 			// Set Default Sidebar Position
	$sidebar['name']   = 'default-sidebar'; // Set Default Sidebar

	if ( is_home() || is_page_template('template-homepage.php') ) {
		 
		$sidebar['layout'] = ot_get_option('orn_sidebar_home_layout');	// Home Sidebar Layout
		$sidebar['name']   = ot_get_option('orn_sidebar_home');  		// Home Sidebar
		  
	} elseif( is_page() || is_single() ) {
		  
		$sidebar['layout'] = get_post_meta($post_ID, "orn_sidebar_layout", true); 	  // Page Sidebar Layout
		$sidebar['name']   = get_post_meta($post_ID, "orn_post_page_sidebar", true);  // Get page sidebar from meta key if avaliable
		  
	} elseif ( is_category() ) {
		
		$sidebar['layout'] = ot_get_option('orn_sidebar_cat_layout');	// Theme Options default Categories Sidebar Layout
		$sidebar['name']   = ot_get_option('orn_sidebar_category'); 	// Theme Options default Categories Sidebar
		$cat_id 	       = intval( get_query_var('cat') );		    // Current Category ID
		$cat_sidebars 	   = ot_get_option('orn_categorysidebars');		// Custom Sidebars for category

		if ( $cat_sidebars ) { 	
			foreach( $cat_sidebars as $cat_sidebar ) {	
				if ( $cat_id == $cat_sidebar['orn_categorysidebars_category'] ) {
					$sidebar['layout'] = $cat_sidebar['orn_categorysidebars_layout'];		// custom sidebar layout for category
					$sidebar['name']   = $cat_sidebar['orn_categorysidebars_sidebar']; 		// set custom sidebar for category
				} 
			}  // end foreach
		} // end if $cat_sidebars
	
	} elseif ( is_archive() ) {
		  //Archives Sidebar Position
		$sidebar['layout'] = ot_get_option('orn_sidebar_arch_layout');	// Arhives Sidebar Layout
		$sidebar['name']   = ot_get_option('orn_sidebar_archive');      // Arhives Sidebar
	}

	if ( empty($sidebar['layout']) ) { $sidebar['layout'] = 'right'; } 			 // Fallback to Default Sidebar Position
	if ( empty($sidebar['name']) )   { $sidebar['name']   = 'default-sidebar'; } // Fallback to Default Sidebar

	return $sidebar; // Return array with sidebar postition and name
	
}
endif; // orbitnews_sidebars()

if ( ! function_exists( 'orbitnews_breadcrumbs' ) ) :
/**
 *  Based on "Dimox" breadcrumbs.
 *	Source link: http://dimox.net/wordpress-breadcrumbs-without-a-plugin/
 */
function orbitnews_breadcrumbs() {

	/* === OPTIONS === */
	$text['home']     = __( 'Home', 'orbitnews' ); // text for the 'Home' link
	$text['category'] = __( 'Archive by Category "%s"', 'orbitnews' ); // text for a category page
	$text['search']   = __( 'Search Results for "%s"', 'orbitnews' ); // text for a search results page
	$text['tag']      = __( 'Posts Tagged "%s"', 'orbitnews' ); // text for a tag page
	$text['author']   = __( 'Articles Posted by %s', 'orbitnews' ); // text for an author page
	$text['format']	  = __( 'Post Format: %s', 'orbitnews' ); // Text for post formats

	$show_current   = 1; // 1 - show current post/page/category title in breadcrumbs, 0 - don't show
	$show_home_link = 1; // 1 - show the 'Home' link, 0 - don't show
	$show_title     = 1; // 1 - show the title for the links, 0 - don't show
	$delimiter      = ' &raquo; '; // delimiter between crumbs
	$before         = '<span class="current">'; // tag before the current crumb
	$after          = '</span>'; // tag after the current crumb
	/* === END OF OPTIONS === */

	global $post;
	$home_link    = home_url('/');
	$link_before  = '<span typeof="v:Breadcrumb">';
	$link_after   = '</span>';
	$link_attr    = ' rel="v:url" property="v:title"';
	$link         = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
	$parent_id    = $parent_id_2 = $post->post_parent;
	$frontpage_id = get_option('page_on_front');

	echo '<div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#"><h4 class="cat-title home-icon mb25">';
	if ($show_home_link == 1) {
		echo '<a href="' . $home_link . '" rel="v:url" property="v:title">' . $text['home'] . '</a>';
		if ($frontpage_id == 0 || $parent_id != $frontpage_id) echo $delimiter;
	}

	if ( is_category() ) {
		$this_cat = get_category(get_query_var('cat'), false);
		if ($this_cat->parent != 0) {
			$cats = get_category_parents($this_cat->parent, TRUE, $delimiter);
			if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
			$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
			$cats = str_replace('</a>', '</a>' . $link_after, $cats);
			if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
			echo $cats;
		}
		if ($show_current == 1) echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;

	} elseif ( is_search() ) {
		echo $before . sprintf($text['search'], get_search_query()) . $after;

	} elseif ( is_day() ) {
		echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
		echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
		echo $before . get_the_time('d') . $after;

	} elseif ( is_month() ) {
		echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
		echo $before . get_the_time('F') . $after;

	} elseif ( is_year() ) {
		echo $before . get_the_time('Y') . $after;

	} elseif ( is_single() && !is_attachment() ) {
		if ( get_post_type() != 'post' ) {
			$post_type = get_post_type_object(get_post_type());
			$slug = $post_type->rewrite;
			printf($link, $home_link . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
			if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;
		} else {
			$cat = get_the_category(); $cat = $cat[0];
			$cats = get_category_parents($cat, TRUE, $delimiter);
			if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
			$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
			$cats = str_replace('</a>', '</a>' . $link_after, $cats);
			if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
			echo $cats;
			if ($show_current == 1) echo $before . get_the_title() . $after;
		}

	} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
		$post_type = get_post_type_object(get_post_type());
		echo $before . $post_type->labels->singular_name . $after;

	} elseif ( is_attachment() ) {
		$parent = get_post($parent_id);
		$cat = get_the_category($parent->ID); $cat = $cat[0];
		if ($cat) {
			$cats = get_category_parents($cat, TRUE, $delimiter);
			$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
			$cats = str_replace('</a>', '</a>' . $link_after, $cats);
			if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
			echo $cats;
		}
		printf($link, get_permalink($parent), $parent->post_title);
		if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;

	} elseif ( is_page() && !$parent_id ) {
		if ($show_current == 1) echo $before . get_the_title() . $after;

	} elseif ( is_page() && $parent_id ) {
		if ($parent_id != $frontpage_id) {
			$breadcrumbs = array();
			while ($parent_id) {
				$page = get_page($parent_id);
				if ($parent_id != $frontpage_id) {
					$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
				}
				$parent_id = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			for ($i = 0; $i < count($breadcrumbs); $i++) {
				echo $breadcrumbs[$i];
				if ($i != count($breadcrumbs)-1) echo $delimiter;
			}
		}
		if ($show_current == 1) {
			if ($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) echo $delimiter;
			echo $before . get_the_title() . $after;
		}

	} elseif ( is_tag() ) {
		echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

	} elseif ( is_author() ) {
		global $author;
		$userdata = get_userdata($author);
		echo $before . sprintf($text['author'], $userdata->display_name) . $after;

	} elseif ( is_tax( 'post_format', 'post-format-'. get_post_format() .'' ) ) {
		$postformat = get_post_format_string(get_post_format());
		echo $before . sprintf($text['format'], $postformat) . $after;
	}
	

	if ( get_query_var('paged') ) {
		if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
		 printf( __( 'Page %s', 'orbitnews' ), get_query_var('paged') );
		if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
	}

	echo '</h4></div><!-- .breadcrumbs -->';

} // end orbitnews_breadcrumbs()
endif;
