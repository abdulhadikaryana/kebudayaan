<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.','framework');?></p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->
<div id="comments">
<?php if ( have_comments() ) : ?>
	
	<div class="block_box_title">
		<h2 class="up_comments">	
		<?php _e('Comments', 'framework'); ?> (<?php echo get_comments_number(); ?>)
		</h2>
		<span></span>
	</div>

	
	<ul class="commentlist">
	<?php wp_list_comments('type=comment&callback=custom_comments'); ?>
	</ul>

	<div class="navigation">
		<div class="alignleft oldercomments"><?php previous_comments_link( __( 'Older Comments', 'framework' ) ); ?></div>
		<div class="alignright newercomments"><?php next_comments_link( __( 'Newer Comments', 'framework' ) ); ?></div>
	</div>
	
 <?php else : // this is displayed if there are no comments so far ?>

	
<?php endif; ?>

</div>
<?php if ( comments_open() ) : ?>
	<div class="block_box_title">
		<h2>
			<?php comment_form_title( __('Leave a Comment', 'framework'), __('Leave a Comment to %s', 'framework') ); ?>
		</h2>
		<span></span>
	</div>
	<div id="respond">
	
		<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
		<p><?php printf(__('You must be %1$slogged in%2$s to post a comment.', 'framework'), '<a href="'.get_option('siteurl').'/wp-login.php?redirect_to='.urlencode(get_permalink()).'">', '</a>') ?></p>
		<?php else : ?>
	<div class="add_comment">
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
        
        	<div class="cancel-comment-reply">
				<?php cancel_comment_reply_link(); ?>
		</div>
	
			<?php if ( is_user_logged_in() ) : ?>
		
			<p style="margin-bottom:10px;"><?php printf(__('Logged in as %1$s. %2$sLog out &raquo;%3$s', 'framework'), '<a href="'.get_option('siteurl').'/wp-admin/profile.php">'.$user_identity.'</a>', '<a href="'.(function_exists('wp_logout_url') ? wp_logout_url(get_permalink()) : get_option('siteurl').'/wp-login.php?action=logout" title="').'" title="'.__('Log out of this account', 'framework').'">', '</a>') ?></p>
		
			<?php else : ?>
			
			<p class="name">
                        <input type="text" name="author" id="author" value="<?php if ($comment_author == '') { echo _e('Username', 'framework' ); echo '*'; } elseif ($comment_author >= '') { echo $comment_author; } ?>" onfocus="if(this.value=='<?php _e('Username', 'framework' ); ?>*')this.value='';" onblur="if(this.value=='')this.value='<?php _e('Username', 'framework' ); ?>*';" tabindex="1">
                        </p>
			
			<p class="email">
                        <input type="text" name="email" id="email" value="<?php if ($comment_author_email == '') { echo _e('Email', 'framework' ); echo '*'; } elseif ($comment_author_email >= '') { echo $comment_author_email; } ?>" onfocus="if(this.value=='<?php _e('Email', 'framework' ); ?>*')this.value='';" onblur="if(this.value=='')this.value='<?php _e('Email', 'framework' ); ?>*';" tabindex="2">
                        </p>
			
			<p class="website">
                        <input id="a-site" type="text" name="website" value="<?php if ($comment_author_url == '') { echo _e('Website', 'framework' ); } elseif ($comment_author_url >= '') { echo $comment_author_url; } ?>" onfocus="if(this.value=='<?php _e('Website', 'framework' ); ?>')this.value='';" onblur="if(this.value=='')this.value='<?php _e('Website', 'framework' ); ?>';" tabindex="3">
                        </p>
			
		
			<?php endif; ?>
		
			<p class="commentarea"><textarea aria-required="true" rows="9" cols="50" name="comment" id="comment" onfocus="if (this.value=='Comment...') this.value='';" onblur="if (this.value=='') this.value='Comment...';" tabindex="4">Comment...</textarea></p>
			
			
			
			<!--<p class="allowed-tags"><small><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></small></p>-->
			<p class="post-comment"><button id="submit" class="send_comment" type="submit"><?php _e('Post Comment', 'framework') ?></button>
			<?php comment_id_fields(); ?>
			</p>
			<?php do_action('comment_form', $post->ID); ?>
	
		</form>
	</div>
	<?php endif; // If registration required and not logged in ?>
	</div>

<?php endif; // if you delete this the sky will fall on your head ?>