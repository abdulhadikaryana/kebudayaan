<?php 
/**
 * The template part that displays audio post formats
 * The following content displays on single posts before post title
 * @package OrbitNews
 */ 
$post_id       = get_the_ID();
$get_meta      = get_post_custom($post_id );
$sidebar_pos   = ( isset($get_meta["orn_sidebar_layout"][0]) ? $get_meta["orn_sidebar_layout"][0] : false );
$audio_src     = ( isset($get_meta["orn_audio_source"][0]) ? $get_meta["orn_audio_source"][0] : false );
$mp3_audio     = ( isset($get_meta["orn_self_hosted_mp3"][0]) ? $get_meta["orn_self_hosted_mp3"][0] : false );
$m4a_audio     = ( isset($get_meta["orn_self_hosted_m4a"][0]) ? $get_meta["orn_self_hosted_m4a"][0] : false );
$oga_audio     = ( isset($get_meta["orn_self_hosted_oga"][0]) ? $get_meta["orn_self_hosted_oga"][0] : false );
$sound_cloud   = ( isset($get_meta["orn_sound_cloud"][0]) ? $get_meta["orn_sound_cloud"][0] : false );
$single_thumb  = ( ( 'no-sidebar' == $sidebar_pos ) ? 'full-thumb' : 'post-thumbnail' );
$audio_sources = array_filter(array( 'mp3' => $mp3_audio, 'ogg' => $oga_audio, 'm4a' => $m4a_audio ));

// Audio Type Embed
if ( !empty( $sound_cloud ) && ( 'soundcloud' == $audio_src ) ) {
	
	echo '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url='.$sound_cloud.'&amp;auto_play=false&amp;show_artwork=true"></iframe>';

} elseif ( ( isset( $audio_sources['mp3'] ) || isset( $audio_sources['ogg'] ) || isset( $audio_sources['m4a'] ) ) && ( 'selfhosted' == $audio_src ) ) {
	
	// Container for player and featured image
	echo '<div class="audio-container">';

		// Post Audio Player 
		echo '<div class="self-hosted-audio">';
		
			if ( count($audio_sources) == 3 ) {
				
				echo do_shortcode('[audio mp3="'.$mp3_audio.'" oga="'.$oga_audio.'" m4a="'.$m4a_audio.'"]');
			
			} elseif ( count($audio_sources) == 2 ) { 
				
				$sources2 = '';
				foreach ( $audio_sources as $audio_ext => $file_src ) {
					$sources2 .= $audio_ext.'='.$file_src.' '; 
				} 
				echo do_shortcode('[audio '.$sources2.']');
			
			} else {
				foreach ( $audio_sources as $source1 ) {
					echo do_shortcode('[audio src='.$source1.']');
				}
			}
			
		echo '</div>';
		
		// Post Featured Image
		if ( ( has_post_thumbnail() ) ) {
			$big_thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');
			echo '<a rel="image" class="featured-img fancybox" href="'. $big_thumb[0] .'" title="'. get_the_title() .'">';
			echo the_post_thumbnail($single_thumb);
			echo '</a>';
		}
			
	echo '</div>';
	
}

