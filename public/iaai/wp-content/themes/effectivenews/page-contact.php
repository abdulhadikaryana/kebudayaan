<?php
/*
    Template Name: Contact Us
*/
?>
<?php 
$nameError = '';
$emailError = '';
$commentError = '';
if(isset($_POST['submitted'])) {
		if(trim($_POST['contactName']) === '') {
			$nameError = __('Please enter your name.', 'framework');
			$hasError = true;
		} else {
			$name = trim($_POST['contactName']);
		}
		
		if(trim($_POST['email']) === '')  {
			$emailError = __('Please enter your email address.', 'framework');
			$hasError = true;
		} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
			$emailError = 'You entered an invalid email address.';
			$hasError = true;
		} else {
			$email = trim($_POST['email']);
		}
			
		if(trim($_POST['comments']) === '') {
			$commentError = __('Please enter a message.', 'framework');
			$hasError = true;
		} else {
			if(function_exists('stripslashes')) {
				$comments = stripslashes(trim($_POST['comments']));
			} else {
				$comments = trim($_POST['comments']);
			}
		}
			
		if(!isset($hasError)) {
			$emailTo = eff_option('contact_email');
			if (!isset($emailTo) || ($emailTo == '') ){
				$emailTo = get_option('admin_email');
			}
			$subject = '[Contact Form] From '.$name;
			$body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
			$headers = 'From: '.$name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
			
			mail($emailTo, $subject, $body, $headers);
			$emailSent = true;
		}
	
} ?>
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
                    <?php if(isset($emailSent) && $emailSent == true) { ?>
                        <div style="" class="box_tip box clear">
                            <p><?php _e('Thanks, your email was sent successfully.', 'framework') ?></p>
                        </div>
                    
                    <?php } else { ?>
                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                        <?php the_content(); ?>
                    <?php endwhile; else: ?>
                    <?php endif; ?>
                    <?php wp_reset_query(); ?>
                    
                    <?php if(isset($hasError) || isset($captchaError)) { ?>
                        <p class="error"><?php _e('Sorry, an error occurred.', 'framework') ?><p>
                    <?php } ?>
                    
                    <div class="contact_form">      
                        <form action="<?php the_permalink(); ?>" id="contactForm" method="post">
                                <p>
                                <label for="contactName"><?php _e('Name:', 'framework') ?></label>
                                    <input type="text" name="contactName" id="contactName" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" class="required requiredField" />
                                    <?php if($nameError != '') { ?>
                                        <span class="error"><?php echo $nameError; ?></span> 
                                    <?php } ?>
                                    </p>
                                
                    
                                <p><label for="email"><?php _e('Email:', 'framework') ?></label>
                                    <input type="text" name="email" id="email" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" class="required requiredField email" />
                                    <?php if($emailError != '') { ?>
                                        <span class="error"><?php echo $emailError; ?></span>
                                    <?php } ?>
                                    </p>
                    
                                <p><label for="commentsText"><?php _e('Message:', 'framework') ?></label>
                                    <textarea name="comments" id="commentsText" rows="20" cols="30" class="required requiredField"><?php if(isset($_POST['comments'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['comments']); } else { echo $_POST['comments']; } } ?></textarea>
                                    <?php if($commentError != '') { ?>
                                        <span class="error message_error"><?php echo $commentError; ?></span> 
                                    <?php } ?>
                                    </p>
                                </li>
                    
                                    <input type="hidden" name="submitted" id="submitted" value="true" />
                                    <button id="submit" type="submit" class="send_comment"><?php _e('Send Email', 'framework') ?></button>
                            </ul>
                        </form>
                    </div>
                    <?php } ?>
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