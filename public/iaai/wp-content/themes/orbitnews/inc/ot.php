<?php 

/**
 * This function filters all the CSS insertion values.
 */
function filter_css_value( $value, $option_id ) {

  	// Custom Category Background
	if ( $option_id == 'category_background' ) {
		$orn_cat_custom_bg = ot_get_option( 'orn_category_background' );
		if ( $orn_cat_custom_bg ) {
			$category_bckg_settings = '';
			foreach ( $orn_cat_custom_bg as $orn_cat_bg ){
	  
				$cat_bg_sel  = get_category($orn_cat_bg['orn_cat_bg_select']);
				$cat_bg_name = ( isset($cat_bg_sel->name) ) ? $cat_bg_sel->name : false;
				$cat_bg_slug = ( isset($cat_bg_sel->slug) ) ? $cat_bg_sel->slug : false;
				$backgrounds = $orn_cat_bg['orn_cat_bg_image'];
				$cat_bg_img   = '';
				$cat_bg_color = '';
				$cat_bg_prop = '';
				foreach( $backgrounds as $cat_background_key => $cat_background_value ):
					switch( $cat_background_key ) {
					  case 'background-image':
						  if(isset($cat_background_value)){
						  	$cat_bg_img = 'url("' . $cat_background_value . '")';
						  }
						  break;
					  case 'background-color':
						  if(isset($cat_background_value)){
						  	$cat_bg_color = $cat_background_value;
						  }
						  break;
					  default:
						  if($cat_background_value){
						  	$cat_bg_prop .= ' '. $cat_background_value;
						  }
						  break;
					} 
				endforeach;
				
			$category_bckg_settings .= 
				'/* Custom Background for ' . $cat_bg_name . ' Category */' . "\n" .
				'html > body.category-' . $cat_bg_slug . ' { ' . "\n" .
				'	background: '. $cat_bg_color .' '. $cat_bg_img . $cat_bg_prop . 
				';' . "\n" . '}' .	"\n" .
				'';
			}
			return $category_bckg_settings;

		} 
	} elseif ( $option_id == 'orn_font_title' ) {
		// Google Fonts for title
		$orn_title_font = ot_get_option( 'orn_font_title' );
		$select_font = ( ($orn_title_font == 'default') ? 'PT+Sans:400,700' : $orn_title_font );
		$title_font_name = '"'. str_replace( "+"," ",strtok($select_font, ":" )). '";';
		
		return $title_font_name;
	
	} elseif ( $option_id == 'orn_font_body' ) {
		// Google Fonts for Body
		$orn_body_font = ot_get_option( 'orn_font_body' );
		$select_font = ( ($orn_body_font == 'default') ? 'Open+Sans:400,700' : $orn_body_font );
		$body_font_name = '"'. str_replace( "+"," ",strtok($select_font, ":" )). '";';
		
		return $body_font_name;
	
	} elseif ( $option_id == 'orn_font_navigation' ) {
		// Google Fonts for menu
		$orn_nav_font = ot_get_option( 'orn_font_navigation' );
		$select_font = ( ($orn_nav_font == 'default') ? 'Oswald:400,700' : $orn_nav_font );
		$nav_font_name = '"'. str_replace( "+"," ",strtok($select_font, ":" )). '";';
		
		return $nav_font_name;
	
	}
	// Always return $value
	return $value;

}
add_filter( 'ot_insert_css_with_markers_value', 'filter_css_value', 10, 2 );

/**
 * This function holds custom css for theme options
 */
function orbitnews_custom_css(){

$custom_css = '
/* Body Background */
body {
	{{orn_backgroundimage}}
}

/* Navigation Background Color */
.container header, .sf-menu .sub-menu li {
	background: {{orn_menu_color}}
}

/* Custom Colors Scheme */
blockquote {
	border-left-color: {{orn_color_custom}};
	border-right-color: {{orn_color_custom}};
}
.cat-title {
	background-color: {{orn_color_custom}}
}
ul.accordion > li.active,.tabs dd.active {
	border-top-color: {{orn_color_custom}}
}
.tabs-widget .tab-links li.active a {
	background: {{orn_color_custom}};
	border-color: {{orn_color_custom}};
}
.twitter-widget a {
	color: {{orn_color_custom}} !important
}
ol#comments .comment-reply-edit a.comment-reply-link,
ol#comments .comment-reply-edit a.comment-edit-link,
#cancel-comment-reply-link,
.contact-form input[type="submit"],
.wpcf7 input[type="submit"],
li.widget_tag_cloud .tagcloud a:hover,
li.subscribe-widget input[type="submit"],
.comment-form input[type="submit"],
.copyright,
.pagenation li,
.pagenation li span,
#main-menu a:hover,
#main-menu a.active,
#top-menu {
	background: {{orn_color_custom}}
}
a,
.dropcap2 span.large-cap,
.error-404 p b,
li.widget_rss .rss-date,
.tabs-widget > div h3 a,
.post-title,
.comment-reply-title,
.flex-caption a,
.other-posts .post-title {
	color: {{orn_color_custom}}
}

/* Custom Google Fonts Title */
.post-title, 
.comment-reply-title, 
.post-container .post-title, 
.other-posts .post-title, 
footer p, 
.copyright, 
#sidebar .widget-title, 
.tabs-widget .tab-links li a, 
.tabs-widget > div h3, 
.contact-form input[type="text"],
.contact-form textarea,
.comment-form input[type="text"],
.comment-form textarea {
	font-family: {{orn_font_title}}
}

/* Custom Google Fonts Navigation */
#main-menu a,
.cat-title,
.post-navigation, 
.image-navigation,
footer .widget-title {
	font-family: {{orn_font_navigation}}
}

/* Custom Google Fonts Body */
body {
	font-family: {{orn_font_body}}
}

{{category_background}}
';

return $custom_css;

}

/**
 * Get the Google Fonts for your typography fields 
 */
function orn_store_googlefonts(){
	
	$key = 'orn_google_fonts';

	// Let's see if we have a cached version
	$google_fonts = get_transient($key);
	if ( false !== $google_fonts )
		return $google_fonts;
	else
	{
		// If there's no cached version we ask google
		$fontsSeraliazed = "https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyBuM7x0G9JDBuyYVOwcsOHwo8y-vex-gGc";
		$response = wp_remote_get ( $fontsSeraliazed, array ( 'sslverify' => false ) );
		if (is_wp_error($response))
		{
			// In case google is down we return the last successful count
			return get_option($key);
		}
		else
		{
			// If everything's okay, parse the body and json_decode it
			$fontArray = json_decode($response['body'], true);
			//$sliced_fonts = array_slice($fontArray['items'], 0, 100);
			
			if ( $fontArray ) {
				
				$googleFontArray = array();
				// generate the array to store
  				foreach($fontArray['items'] as $index => $value){
					$googleFontArray[] = array(
											'label' => $value['family'],
											'value' => str_replace(' ', '+', $value['family']).':'.implode(',', $value['variants'])
											
										 );
				}	
			
			}
			$other_fonts = array('label' => 'Default Font', 'value' => 'default');
			array_unshift( $googleFontArray, $other_fonts );
			// Store the result in a transient, expires after 3 days
			// Also store it as the last successful using update_option
			set_transient($key, $googleFontArray, 72*60*60);
			update_option($key, $googleFontArray);
			return $googleFontArray;
			
		}
	}
}

/**
 * Remove background size field 
 */
function orbitnews_ot_background_fields( $choices_array ) {

	$choices_array = array( 
		'background-color',
		'background-repeat', 
		'background-attachment', 
		'background-position',
		'background-image'
	);
   	return $choices_array;

}
add_filter( 'ot_recognized_background_fields', 'orbitnews_ot_background_fields', 10, 2 );

/**
 * Modify List Item Label to be more user friendly
 */
function orbitnews_ot_list_label( $list_label, $list_id ) {

   if ( "orn_customsidebars" == $list_id ) {
      $list_label = 'Sidebar Name';
   }

   return $list_label;

}
add_filter( 'ot_list_item_title_label', 'orbitnews_ot_list_label', 10, 2 );

/**
 * Modify List Items Description to be more user friendly
 */
function orbitnews_ot_list_desc( $list_desc, $list_id ) {

   if ( "orn_category_background" == $list_id ) {
      $list_desc = 'Click on "Add New" to add a custom backgrond for a categroy you select';
   }
   if ( "orn_customsidebars" == $list_id ) {
      $list_desc = '';
   }
   if ( "orn_categorysidebars" == $list_id ) {
      $list_desc = '';
   }

   return $list_desc;

}
add_filter( 'ot_list_item_description', 'orbitnews_ot_list_desc', 10, 2 );
