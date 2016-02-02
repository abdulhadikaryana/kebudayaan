<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to orbitnews_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package OrbitNews
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>


	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
    <div id="comments_wrap"><!-- #comments-wrap -->
		<h4 class="post-title">
			<?php
				printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'orbitnews' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h4>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'orbitnews' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'orbitnews' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'orbitnews' ) ); ?></div>
		</nav><!-- #comment-nav-above -->
		<?php endif; // check for comment navigation ?>

		<ol id="comments">
			<?php
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use orbitnews_comment() to format the comments.
				 * If you want to override this in a child theme, then you can
				 * define orbitnews_comment() and that will be used instead.
				 * See orbitnews_comment() in inc/template-tags.php for more.
				 */
				wp_list_comments( array( 'callback' => 'orbitnews_comment' ) );
			?>
		</ol><!-- .comment-list -->
        <div class="line"></div>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'orbitnews' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'orbitnews' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'orbitnews' ) ); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

		<?php
			// If comments are closed and there are comments, let's leave a little note, shall we?
			if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
			<p class="no-comments"><?php _e( 'Comments are closed.', 'orbitnews' ); ?></p>
		<?php endif; ?>
		<div class="clear"></div>
		<!-- Contact Form -->
			<?php 
			$name 	 = __('Name', 'orbitnews');
			$email	 = __('E-mail', 'orbitnews');
			$web	 = __('Website', 'orbitnews');
			$comment = __('Comment', 'orbitnews');
			$comment_args = array( 
			
					'comment_notes_before' 	=>	'',
					'fields' 				=>	apply_filters( 'comment_form_default_fields', array(
					'author' 				=>	'<input id="author" name="author" class="left" type="text" data-value="'.$name.'" value="'.$name.'" />',   
					'email'  				=>	'<input id="email" name="email" class="right" type="text" data-value="'.$email.'" value="'.$email.'" />',
					'url'    				=>	'<input id="website" name="website" class="right" type="text" data-value="'.$web.'" value="'.$web.'" />' ) ),
					'comment_field' 		=>	'<textarea id="comment" name="comment" class="twelve column" data-value="'.$comment.'" aria-required="true">'.$comment.'</textarea>',
					'comment_notes_after' 	=>	'',

			);
			comment_form($comment_args); 
			?>
	</div><!-- End #comments-wrap -->


