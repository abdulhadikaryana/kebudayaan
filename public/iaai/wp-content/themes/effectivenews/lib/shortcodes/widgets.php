<?php 

function twitter_sc($atts, $content = null) {
	extract(shortcode_atts(array(
	'count' => '3',
	'user' => 'Envato'
	), $atts));
	
	ob_start();
	$rndn = rand(1,500);
	?>
			<?php wp_enqueue_script('Tweets'); ?>
			<script type="text/javascript">
				  jQuery.noConflict();
				jQuery(function(){
				  jQuery(".tweet_<?php echo $rndn; ?>").tweet({
					join_text: "auto",
					username: "<?php echo $user ?>",
					avatar_size: false,
					count: <?php echo $count ?>,
					<?php if( is_rtl() ) { ?>
					template: "{text}",

					<?php } else { ?>
					seconds_ago_text: "<?php _e('about %d seconds ago','framework');?>",
					a_minutes_ago_text: "<?php _e('about a minute ago','framework');?>",
					minutes_ago_text: "<?php _e('about %d minutes ago','framework');?>",
					a_hours_ago_text: "<?php _e('about an hour ago','framework');?>",
					hours_ago_text: "<?php _e('about %d hours ago','framework');?>",
					a_day_ago_text: "<?php _e('about a day ago','framework');?>",
					days_ago_text: "<?php _e('about %d days ago','framework');?>",
					view_text: "<?php _e('view tweet on twitter','framework');?>"
				<?php } ?>				  });
				});
			</script>
			    <div class="tweet_<?php echo $rndn; ?>"></div>
        <?php
	$content = ob_get_contents();
	ob_end_clean();

	return ''.$content.'';
}
add_shortcode("twitter", "twitter_sc");

function flickr_sc($atts, $content = null) {
	extract(shortcode_atts(array(
	'count' => '5',
	'id' => '61958348@N03',
	'display' => 'random',
	'type' => 'user'
	), $atts));
	
	ob_start();
	?>
	<div class="flickr_badge_wrapper" class="clearfix">
	<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $count ?>&amp;display=<?php echo $display ?>&amp;size=s&amp;layout=x&amp;source=<?php echo $type ?>&amp;<?php echo $type ?>=<?php echo $id ?>"></script>
	</div>

        <?php
	$content = ob_get_contents();
	ob_end_clean();

	return ''.$content.'';
}
add_shortcode("flickr", "flickr_sc");

