<?php 

add_action('widgets_init','eff_social_counter');

function eff_social_counter() {
	register_widget('eff_social_counter');
	}

class eff_social_counter extends WP_Widget {
	function eff_social_counter() {
			
		$widget_ops = array('classname' => 'eff_social_counter','description' => __('Widget display a count of your rss subscribers, Twitter followers, facebook fans','framework'));
		
		$this->WP_Widget('eff_social_counter',__('Widget - Social Counter','framework'),$widget_ops);

		}
		
	function widget( $args, $instance ) {
		extract( $args );
		/* User-selected settings. */
	$title = apply_filters('widget_title', $instance['title'] );
	$twitter = $instance['twitter'];
	$facebook = $instance['facebook'];
	$rss_text = $instance['rss_text'];
	$rss_link = $instance['rss_link'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			//echo $before_title . $title . $after_title;

?>
<?php
	//facebook
	function fb_count($facebook)
	{
	    $url='http://api.facebook.com/method/fql.query?query=SELECT fan_count FROM page WHERE';
	    if(is_numeric($facebook)) { $qry=' page_id="'.$facebook.'"';} //If value is a page ID
	    else {$qry=' username="'.$facebook.'"';} //If value is not a ID.
	    $xml = @simplexml_load_file($url.$qry) or die ("invalid operation");
	    $fb_count = $xml->page->fan_count;
	    return $fb_count;
	}
	    
	//twitter
	$interval = 3600;
	
	// Use this function to retrieve the followers count
function eff_followers_count($username){

// WordPress Transient API Caching
$cacheKey = $username . '-cache';
$cached = get_transient($cacheKey);
if (false !== $cached)
{return $cached;}

// Call and instantiate twitterOAuth. Modify the path to where you uploaded twitteroauth
include ( EFF_FW .'/twitteroauth/twitteroauth.php');

// Replace the four parameters below with the information from your Twitter developer application.
$twitterConnection = new TwitterOAuth('ox6Xuug5CPk55E4wW26g','vXWs8vJDjxFtSFP3HBYLWj8Zr4AXxQfRcFcdPDHWA','1230421488-6on6VYWJYf0xxZMGxVKgWKaTaUuE0NA4ZaIYoza', 'cnZPodl9ePUggimbHohmXIysAmM65Y6R2jDzHUcKMhE');

// Send the API request
$twitterData = $twitterConnection->get('users/show', array('screen_name' => $username));

// Extract the follower and tweet counts
$followerCount = $twitterData->followers_count;
$tweetCount = $twitterData->statuses_count;

$output = $followerCount;
set_transient($cacheKey,$output,3600);
return $output;
}


?>

<section class="widget section_widget">
	<ul class="social_counter">
	    <li class="fb_counter">
		<a target="_blank" href="<?php echo get_option('eff_facebook_link'); ?>" class="tip_n" title="Facebook">
		    <img src="<?php echo EFF_IMG; ?>/sc_fb.png" alt="">
		</a>
		<div class="sc_bottom">
		    <small><?php echo get_option('eff_facebook_followers'); ?></small>
		    <p><?php _e('Subscribers', 'framework'); ?></p>
		</div>
	    </li>
	    <li class="twitter_counter">
		<a target="_blank" href="http://twitter.com/<?php echo $twitter ?>" class="tip_n" title="Twitter">
		    <img src="<?php echo EFF_IMG; ?>/sc_twitter.png" alt="">
		</a>
		<div class="sc_bottom">
		    <small><?php echo eff_followers_count($twitter); ?></small>
		    <p><?php _e('Followers', 'framework'); ?></p>
		</div>
	    </li>
	    <li class="rss_counter">
		<?php if($rss_link != '') {
			$rssurl = $rss_link;
		} else {
			$rssurl = get_bloginfo('rss2_url');
		} ?>
		<a target="_blank" href="<?php echo $rssurl; ?>" class="tip_n" title="Rss">
		    <img src="<?php echo EFF_IMG; ?>/sc_rss.png" alt="">
		</a>
		<div class="sc_bottom">
		    <small><?php echo $rss_text; ?></small>
		    <p><?php _e('Subscribers', 'framework'); ?></p>
		</div>
	    </li>
	</ul>
</section>
</div>
<?php 
		/* After widget (defined by themes). */
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['twitter'] = $new_instance['twitter'];
			$instance['facebook'] = $new_instance['facebook'];
			$instance['rss_text'] = $new_instance['rss_text'];
			$instance['rss_link'] = $new_instance['rss_link'];

		return $instance;
	}
	
function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 
			'twitter' => 'envato',
			'facebook' => 'envato',
			'rss_text' => '1000+'
 			);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
	

		<p>
		<label for="<?php echo $this->get_field_id( 'rss_text' ); ?>"><?php _e('rss number (if not use feedburner, or want static number)', 'framework'); ?></label>
		<input id="<?php echo $this->get_field_id( 'rss_text' ); ?>" name="<?php echo $this->get_field_name( 'rss_text' ); ?>" value="<?php echo $instance['rss_text']; ?>" class="widefat" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'rss_link' ); ?>"><?php _e('RSS Link (leave empty to use default rss link)', 'framework'); ?></label>
		<input id="<?php echo $this->get_field_id( 'rss_link' ); ?>" name="<?php echo $this->get_field_name( 'rss_link' ); ?>" value="<?php echo $instance['rss_link']; ?>" class="widefat" />
		</p>


		<p>
		<label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e('Twitter Name', 'framework'); ?></label>
		<input id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" value="<?php echo $instance['twitter']; ?>" class="widefat" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e('facebook page ID (<a target="_blank" href="http://hellboundbloggers.com/2010/07/10/find-facebook-profile-and-page-id/">more Info</a>)', 'framework'); ?></label>
		<input id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" value="<?php echo $instance['facebook']; ?>" class="widefat" />
		</p>


   <?php 
}
	} //end class