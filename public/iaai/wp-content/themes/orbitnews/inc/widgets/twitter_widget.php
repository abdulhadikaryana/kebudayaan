<?php

class Tweets_Widget extends WP_Widget {
	
	function Tweets_Widget()
	{
		$widget_ops = array('classname' => 'tweets', 'description' => 'Display latest tweets from twitter');

		$control_ops = array('id_base' => 'orn-twitter-feed-widget');

		$this->WP_Widget('orn-twitter-feed-widget', '&#58;&#58; Twitter Feed - Orbit News &#58;&#58;', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);
		$title 			 = apply_filters('widget_title', $instance['title']);
		$consumer_key 	 = ot_get_option( 'orn_twitter_consumer' );
		$consumer_secret = ot_get_option( 'orn_twitter_c_secret' );
		$twitter_id 	 = $instance['twitter_id'];
		$count 			 = (int) $instance['count'];
		$cacheTime 		 = (int) $instance['cacheTime'];

		echo $before_widget;

		if ( $title ) {
			echo $before_title.$title.$after_title;
		}

		if ( $twitter_id && $consumer_key && $consumer_secret ) {
			
			$transName = 'orn_list_tweets_'.$args['widget_id'];
			$token = maybe_unserialize(get_option('ornTwitterToken'));
		
			// getting new auth bearer only if we don't have one
			if ( !is_array($token) || empty($token) || $token['consumer_key'] != $consumer_key || empty($token['access_token']) ) { 
				// preparing credentials
				$credentials = $consumer_key . ':' . $consumer_secret;
				$toSend = base64_encode($credentials);
	  
				// http post arguments
				$args = array(
					'httpversion' => '1.1',
					'headers' => array(
						'Authorization' => 'Basic ' . $toSend,
						'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
					),
					'body' => array( 'grant_type' => 'client_credentials' )
				);
				add_filter('https_ssl_verify', '__return_false');
					
				$response = wp_remote_post('https://api.twitter.com/oauth2/token', $args);
				$keys = json_decode( wp_remote_retrieve_body($response) );
				if ( $keys ) {
					$token = serialize( array('consumer_key' => $consumer_key, 'access_token' => $keys->access_token ) );
					// saving token to wp_options table
					update_option('ornTwitterToken', $token);
					$token = maybe_unserialize($token);
				}	
			
			}
			
			$twitterData = get_transient( $transName );
			/* if our transient with  old tweets expired */
			/* we get new tweets and set new transient   */
			if ($twitterData === false) {
				// we use the bearer token we obtained from API above
				$user_args = array(
					'httpversion' => '1.1',
					'headers' => array(
						'Authorization' => 'Bearer '. (is_array($token) && isset($token['access_token']) ? $token['access_token'] : '')
					),
					'sslverify'=> false
				);
				$api_url = 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name='.$twitter_id.'&count='.$count;
				$response = wp_remote_get($api_url, $user_args);
				$twitterData = json_decode(wp_remote_retrieve_body($response), true);
				set_transient($transName, $twitterData, 60 * $cacheTime);
			}

        	if( empty( $twitterData ) || ( isset( $twitterData['errors'] ) && ( $twitterData['errors'][0]['code'] == 89 || $twitterData['errors'][0]['code'] == 215 ) ) ) {
				delete_option( 'ornTwitterToken' );
				delete_transient( $transName ); 
			}
			
			if ( $twitterData && is_array($twitterData) ) {

			?>
			<div class="twitter-widget" id="tweets_<?php echo $args['widget_id']; ?>">
				<ul>
					<?php foreach($twitterData as $tweet){ ?>
					<li>
						<p>
						<?php
						$name 	 = $tweet['user']['name'];
						$user_scr_name = $tweet['user']['screen_name'];
						$latestTweet = $tweet['text'];
						$latestTweet = preg_replace('/http:\/\/([a-z0-9_\.\-\+\&\!\#\~\/\,]+)/i', '&nbsp;<a href="http://$1" target="_blank">http://$1</a>&nbsp;', $latestTweet);
        				$latestTweet = preg_replace('/\#([a-zA-Z0-9_-]+)/i', '&nbsp;<a href="https://twitter.com/search?q=%23$1&src=hash" title="" target="_blank">$0</a>&nbsp;', $latestTweet);
						$latestTweet = preg_replace('/@([a-z0-9_]+)/i', '&nbsp;<a href="http://twitter.com/$1" target="_blank">@$1</a>&nbsp;', $latestTweet);
						$timeAgo = human_time_diff( strtotime($tweet['created_at']), time() );
						$tweet_id = $tweet['id_str'];
						echo "<div class='clearfix'><a target='_blank' href='http://twitter.com/$user_scr_name/statuses/$tweet_id' class='jtwt_date'>$timeAgo ago</a>";
						echo " $latestTweet</div>";
						echo "<a target='_blank' href='https://twitter.com/$user_scr_name'>$name</a>";
						?>
						</p>
					</li>
					<?php } ?>
				</ul>
			</div>
			<?php 
			}
		}
		echo $after_widget;
	}

	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['twitter_id'] = $new_instance['twitter_id'];
		$instance['count'] = $new_instance['count'];
		$instance['cacheTime'] = $new_instance['cacheTime'];

		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => 'Recent Tweets', 'twitter_id' => '', 'count' => 3, 'cacheTime' => 10 );
		$instance = wp_parse_args((array) $instance, $defaults); ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'orbitnews'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('twitter_id'); ?>"><?php _e('Twitter ID:', 'orbitnews'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('twitter_id'); ?>" name="<?php echo $this->get_field_name('twitter_id'); ?>" value="<?php echo $instance['twitter_id']; ?>" />
		</p>

			<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Number of Tweets: ', 'orbitnews'); ?></label>
			<input class="small-text" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" value="<?php echo $instance['count']; ?>" />

        </p>
		</p>
			<label for="<?php echo $this->get_field_id('cacheTime'); ?>"><?php _e('Refresh Every: ', 'orbitnews'); ?>
			<input class="small-text" id="<?php echo $this->get_field_id('cacheTime'); ?>" name="<?php echo $this->get_field_name('cacheTime'); ?>" value="<?php echo $instance['cacheTime']; ?>" />
			<small><?php _e('min', 'orbitnews'); ?></small>
            </label>
        </p>

	<?php
	}
}
