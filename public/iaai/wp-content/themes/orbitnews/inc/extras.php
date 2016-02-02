<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package OrbitNews
 */

/**
 * Adds custom classes to the array of body classes.
 */
function orbitnews_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'orbitnews_body_classes' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function orbitnews_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'orbitnews_enhanced_image_navigation', 10, 2 );

/**
 * Filter search results to show only pages if user selected
 */
function orbitnews_search_filter($query) {
	$posts_only = ot_get_option('orn_search_posts_only');
	if ( 'on' == $posts_only ) {
		if ($query->is_search) {
			$query->set('post_type', 'post');
		}
		return $query;
	}
}
add_filter('pre_get_posts','orbitnews_search_filter');

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 */
function orbitnews_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'orbitnews' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'orbitnews_wp_title', 10, 2 );

/**
 * Add Meta Keys for Fancybox Link & Embed for Video Posts 
 */
function orbitnews_fancy_video( $post_ID ) {
	
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
	return;
	
	if ( get_post_status( $post_ID ) != 'publish' ) 
	return;
		
	/* Delete Existing Metakeys */	
	delete_post_meta($post_ID, '_orn_oembed_body');
	delete_post_meta($post_ID, '_orn_embed_link');
	
	// Video Formats
	$video_link   = trim( get_post_meta($post_ID , "orn_oembed_videos", true) );
	$video_format = has_post_format('video', $post_ID);
	
	// Video Type Embed
	if ( !empty( $video_link ) && $video_format ) { 

		// Get Video Data with wordpress oembed class
		require_once( ABSPATH . WPINC . '/class-oembed.php' );
		$oembed = new WP_oEmbed();
		$provider = $oembed->discover( $video_link );
		$data = $oembed->fetch( $provider, $video_link );
		
		if ( isset($data) && $data != false ) {

			// Setup variables
			$provider   = $data->provider_name; 			// Video Provider Name
			$html_embed = $data->html; 						// Video Embed html
			$thumb_link = $data->thumbnail_url; 			// Video Post Thumbnail
			preg_match('/<iframe.*src=\"(.*)\".*><\/iframe>/isU', $html_embed, $url_embed);
			$url_embed  = $url_embed[1]; 					// Embed Url
			$filename   = sanitize_title( $data->title ); 	// Create filename from video title
				
			//Set meta key with feteched video embed html
			update_post_meta( $post_ID, '_orn_oembed_body', $html_embed );
			
			//Video link and thumbnail for video posts
			switch ( $provider ) {
				case 'YouTube':
					$url_embed .= '&amp;showinfo=0&amp;iv_load_policy=3&amp;modestbranding=0&amp;nologo=1&amp;vq=large&amp;autoplay=1&amp;ps=docs&amp;wmode=opaque&amp;rel=0';
					break;
				case 'Vimeo':
					$thumb_link = str_replace('_295.jpg', '_640.jpg', $thumb_link);
					break;	
				default: // do nothing;
         			break;
			} //end switch
			
			// Add Meta key with embed link
			update_post_meta( $post_ID, '_orn_embed_link', $url_embed );

			if ( !has_post_thumbnail( $post_ID ) ) {	
	
				//Fetch and Store the Image	
				$remote_file = wp_remote_get( $thumb_link, array( 'sslverify' => false ));
				$file_type = wp_remote_retrieve_header( $remote_file, 'content-type' ); // Get image type
				$filename .= '-' . rawurldecode( basename( $thumb_link )); // add image file name to file
				$local_file_url = wp_upload_bits( $filename, '', $remote_file['body']); // save image in local server 
				
				//Attachment options
				$attachment = array(
					'post_title'=>  $filename,
					'post_mime_type' => $file_type,
					'post_content' => '',
					'post_status' => 'inherit',
					'ping_status' => 'closed', 
				);
				
				// Add the image to your media library and set as featured image
				$attach_id = wp_insert_attachment( $attachment, $local_file_url['file'], $post_ID );
				$attach_data = wp_generate_attachment_metadata( $attach_id, $local_file_url['file'] );
				wp_update_attachment_metadata( $attach_id, $attach_data );
				set_post_thumbnail( $post_ID, $attach_id );
						
			} // end !has_post_thumbnail()
							
		} //end isset( $data )
	
	} //end $video_link empty 

} //end function orbitnews_fancy_video()
add_action('save_post', 'orbitnews_fancy_video', 100, 1);

/**
 * Underconstruction Page
 */	
function orn_underconstruction(){
	$enabled 	  = ot_get_option( 'orn_underc_enable');
	$future_time  = strtotime( ot_get_option( 'orn_underc_date' ));
	$current_time = strtotime( date_i18n( 'Y-m-d H:i:s' ));
	
	// If current time is lower than future time show underconstuction
	if( ( 'on' == $enabled) && ( $future_time > $current_time ) ){
		// Show underconstruction only to visitors
		if(!current_user_can('manage_options')){
			orn_underconstruction_html();
			exit;
		}
	}
}
add_action('template_redirect', 'orn_underconstruction' );

function orn_underconstruction_html(){
	$title 			 = ot_get_option( 'orn_underc_title' );
	$url_exp 		 = ot_get_option( 'orn_underc_url' );
	$logo_img		 = ot_get_option( 'orn_underc_logo' );
	$backgr_img		 = ot_get_option( 'orn_underc_background' );
	$backg_img_def 	 = get_template_directory_uri() . '/images/underconstruction/bg.jpg';
	$future_time	 = strtotime(ot_get_option( 'orn_underc_date' ));
	$year    		 = date('Y', $future_time);
	$month   		 = date('n', $future_time);
	$month  		 = $month - 1;
	$day     		 = date('j', $future_time);
	$hour    		 = date('G', $future_time);
	$min     		 = intval(date('i', $future_time));
	$sec     		 = intval(date('s', $future_time));

?>
<!DOCTYPE html>
<?php if ( empty ( $backgr_img ) ) { $backgr_img = $backg_img_def; } ?>
<html <?php echo 'style="background-image: url('. $backgr_img .'); "'; ?>>
<head>
	<title><?php bloginfo('name'); ?></title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php 
	if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
	header('X-UA-Compatible: IE=edge,chrome=1'); 
	?>

	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri().'/layouts/underconstruction.css'; ?>">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    
	<script type="text/javascript" src="<?php echo includes_url().'js/jquery/jquery.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri().'/js/jquery.countdown.min.js'; ?>"></script>
</head>
<body>

	<div id="underconstruction-container">
		<div id="logo">
			<a href="<?php echo home_url(); ?>"><img alt="" src="<?php echo $logo_img; ?>"></a>
		</div>
		<div id="content">
			<h1 id="underconstruction-title"><?php echo $title; ?></h1>
			<div id="countdown-container">
			</div>
		</div>
	</div>

	<script type="text/javascript">
		(function($) {
			"use strict";
			var date_end   = new Date(<?php echo $year; ?>, <?php echo $month; ?>, <?php echo $day ?>, <?php echo $hour; ?>, <?php echo $min; ?>, <?php echo $sec; ?>);
			$('#countdown-container').countdown({until: date_end, format: 'DHMS', expiryUrl: "<?php echo $url_exp; ?>"});
		})(jQuery);
	</script>
</body>
</html>
<?php
}
