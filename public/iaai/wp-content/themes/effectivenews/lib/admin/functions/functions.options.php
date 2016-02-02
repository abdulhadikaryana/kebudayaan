<?php

add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{
		//Access the WordPress Tags via an Array
		$of_tags = array();  
		$of_tags_obj = get_tags('hide_empty=0');
		foreach ($of_tags_obj as $of_tag) {
		    $of_tags[$of_tag->name] = $of_tag->name;}
		$tags_tmp = array_unshift($of_tags, "Select a Tag:");
		
		//Access the WordPress Categories via an Array
		$of_categories 		= array();  
		$of_categories_obj 	= get_categories('hide_empty=0');
		foreach ($of_categories_obj as $of_cat) {
		    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
		    
		//Access the WordPress Sidebars via an Array
		$sidebars = $GLOBALS['wp_registered_sidebars'];
                foreach ($sidebars as $sidebar) {
                    $of_sidebars[$sidebar['id']] = $sidebar['name'];
                }
		//$sidebars_tmp = array_unshift($sidebar, "Select a Sidebar:");
		
		    
		//Access the WordPress Pages via an Array
		$of_pages 			= array();
		$of_pages_obj 		= get_pages('sort_column=post_parent,menu_order');    
		foreach ($of_pages_obj as $of_page) {
		    $of_pages[$of_page->ID] = $of_page->post_name; }
		$of_pages_tmp 		= array_unshift($of_pages, "Select a page:");       
	
		//Testing 
		$of_options_select 	= array("one","two","three","four","five"); 
		$of_options_radio 	= array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
		
		//Sample Homepage blocks for the layout manager (sorter)
		$of_options_homepage_blocks = array
		( 
			"disabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				"lv"		=> "Latest Vidoes",
				"nb2"		=> "NewsBox2",
				"nb3"		=> "NewsBox3",
				"nb4"		=> "NewsBox4",
				"nb5"		=> "NewsBox5",
				"nb6"		=> "NewsBox6",
				"nb7"		=> "NewsBox7",
				"nb8"		=> "NewsBox8",
				"nb9"		=> "NewsBox9",
				"nb10"		=> "NewsBox10",
				"ads2"		=> "Banner2",
				"ads3"		=> "Banner3",
				"ads4"		=> "Banner4",
				"ads5"		=> "Banner5",
				"tabs"		=> "News Tabs",
			), 
			"enabled" => array (
				"placebo" => "placebo", //REQUIRED!
				"slider"		=> "Slider",
				"nc"		=> "News Scroller",
				"nb1"		=> "NewsBox1",
				"ads1"		=> "Banner1",
				"nip"		=> "News Pictuer",
			),
		);
		
		$of_options_bottomarea_blocks = array
		( 
			"disabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				"bb5"		=> "Box5",
				"bb6"		=> "Box6",
				"bb7"		=> "Box7",
				"bb8"		=> "Box8",
				"bb9"		=> "Box9",
				"bb10"		=> "Box10",
				"bb11"		=> "Box11",
				"bb12"		=> "Box12",
			), 
			"enabled" => array (
				"placebo" => "placebo", //REQUIRED!
				"bb1"		=> "Box1",
				"bb2"		=> "Box2",
				"bb3"		=> "Box3",
				"bb4"		=> "Box4",
			),
		);


		//Stylesheets Reader
		$alt_stylesheet_path = LAYOUT_PATH;
		$alt_stylesheets = array();
		
		if ( is_dir($alt_stylesheet_path) ) 
		{
		    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) 
		    { 
		        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) 
		        {
		            if(stristr($alt_stylesheet_file, ".css") !== false)
		            {
		                $alt_stylesheets[] = $alt_stylesheet_file;
		            }
		        }    
		    }
		}


		//Background Images Reader
		$bg_images_path = get_stylesheet_directory(). '/images/patterns/'; // change this to where you store your bg images
		$bg_images_url = get_template_directory_uri().'/images/patterns/'; // change this to where you store your bg images
		$bg_images = array();
		
		if ( is_dir($bg_images_path) ) {
		    if ($bg_images_dir = opendir($bg_images_path) ) { 
		        while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
		            if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
				natsort($bg_images); //Sorts the array into a natural order
		                $bg_images[] = $bg_images_url . $bg_images_file;
		            }
		        }    
		    }
		}
		

		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/
		
		//More Options
		$uploads_arr 		= wp_upload_dir();
		$all_uploads_path 	= $uploads_arr['path'];
		$all_uploads 		= get_option('of_uploads');
		$other_entries 		= array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
		$body_repeat 		= array("no-repeat","repeat-x","repeat-y","repeat");
		$body_pos 			= array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");
		
		// Image Alignment radio box
		$of_options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 
		
		// Image Links to Options
		$of_options_image_link_to = array("image" => "The Image","post" => "The Post"); 

$eff_images_url = get_template_directory_uri().'/images/';
$url =  ADMIN_DIR . 'assets/images/';
/*-----------------------------------------------------------------------------------*/
/* The Options Array */
/*-----------------------------------------------------------------------------------*/

// Set the Options Array
global $of_options;
$of_options = array();

//Genral Settings
$of_options[] = array( "name" => "General Settings",
                    "type" => "heading");
				
				$of_options[] = array( "name" => "Main Layout",
					"desc" => __("Select main layout. Choose between Boxed / Wide layout.", 'framework'),
					"id" => "layout",
					"std" => "fixed",
					"type" => "images",
					"options" => array(
						'wide' => $url . '1col.png',
						'fixed' => $url . '3cm.png')
					);
				
				$of_options[] = array( "name" => "Custom Favicon",
					"desc" => __("Upload a 16px x 16px Png/Gif image that will represent your website's favicon.", 'framework'),
					"id" => "custom_favicon",
					"std" => "",
					"type" => "upload");
				
				$of_options[] = array( "name" => "Custom Gravatar",
					"desc" => __("Enter your Gravatar Link here.", 'framework'),
					"id" => "custom_gravatar",
					"std" => "",
					"type" => "text");
				
				$of_options[] = array( "name" => "Responsive",
					"desc" => __("Enable / Disable Responsive.", 'framework'),
					"id" => "responsive",
					"std" => 1,
					"type" => "switch");
				
				$of_options[] = array( "name" => "Images effect",
					"desc" => __("Enable / Disable Image fade-in effect in homepage.", 'framework'),
					"id" => "img_effect",
					"std" => 1,
					"type" => "switch");
				
				$of_options[] = array( "name" => "Date Format For Home page",
					"id" => "hp_date_format",
					"std" => "F d, Y",
					"type" => "text");
				
				$of_options[] = array( "name" => "(x) Comments in Hompe page",
					"desc" => __("Enable / Disable (x) Comments in news boxes in home page.", 'framework'),
					"id" => "hp_comment",
					"std" => 1,
					"type" => "switch");
				
				$of_options[] = array( "name" => "Breadcrumb",
					"desc" => __("Enable / Disable breadcrumb in Pages.", 'framework'),
					"id" => "breadcrumb",
					"std" => 1,
					"type" => "switch");
				
				
				$of_options[] = array( "name" => "Recipient Email",
					"desc" => __("Contact us Recipient Email.", 'framework'),
					"id" => "contact_email",
					"std" => "",
					"type" => "text");
				
				
				$of_options[] = array( "name" => "Tracking Code",
					"desc" => __("Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.", 'framework'),
					"id" => "google_analytics",
					"std" => "",
					"type" => "textarea");
				
				
				$of_options[] = array( "name" => "",
						"id" => "a34",
						"std" => "Notification Options",
						"type" => "title");
				
				
				$of_options[] = array( "name" => "Notification Box",
					"desc" => __("Enable / Disable Notification Box.", 'framework'),
					"id" => "notification",
					"std" => 0,
					"folds" => 1,
					"type" => "switch");
				
				$of_options[] = array( "name" => "Notification Box Content",
					"desc" => __("Add your notification box text.", 'framework'),
					"id" => "notification_text",
					"std" => "",
					"fold" => "notification",
					"type" => "textarea");
				
				$of_options[] = array( "name" => "Notification link text",
					"desc" => __("if you want add link in notification type text here and link below.", 'framework'),
					"id" => "notification_link",
					"std" => "",
					"fold" => "notification",
					"type" => "textarea");
				
				$of_options[] = array( "name" => "Notification link url",
					"desc" => __("Add url as you want.", 'framework'),
					"id" => "notification_url",
					"std" => "",
					"fold" => "notification",
					"type" => "text");
//header settings
$of_options[] = array( "name" => "Header Settings",
					"type" => "heading");

				
				$of_options[] = array( "name" => "Header Style",
					"id" => "header_style",
					"std" => "style1",
					"type" => "images",
					"options" => array(
						'style1' => $url . 'h1.png',
						'style2' => $url . 'h2.png'
					));
				
				$of_options[] = array( "name" => "Top bar",
					"desc" => __("Enable / Disable Top bar.", 'framework'),
					"id" => "top_nav",
					"std" => 1,
					"type" => "switch");
				
				$of_options[] = array( "name" => "Today Date",
					"desc" => __("Enable / Disable Today Date in Topbar.", 'framework'),
					"id" => "top_date",
					"std" => 1,
					"folds" => 1,
					"type" => "switch");
				
				$of_options[] = array( "name" => "Today Date Format",
					"id" => "date_format",
					"std" => "l ,  j  F Y",
					"fold" => "top_date",
					"type" => "text");
				
				$of_options[] = array( "name" => "",
						"id" => "a33",
						"std" => "Logo Options",
						"type" => "title");

				$of_options[] = array( "name" => "Logo Type",
					"id" => "logo_type",
					"std" => "img",
					"type" => "select",
					"options" => array(
						'img' => 'Image',
						'site_name' => 'Site name'
					));
				
				$of_options[] = array( "name" => "Upload your Logo Image",
					"id" => "logo_img",
					"std" => $eff_images_url."logo.png",
					"type" => "media");
				
				$of_options[] = array( "name" => "Site Name",
					"id" => "site_name",
					"std" => array('size' => '26px','face' => '','style' => '','color' => ''),
					"type" => "typography");
				
				$of_options[] = array( "name" => "Site Description",
					"id" => "site_desc",
					"std" => array('size' => '16px','face' => '','style' => '','color' => ''),
					"type" => "typography");
				
				$of_options[] = array( "name" => "Logo margin top / px",
					"id" => "logo_margin",
					"min" 	=> "0",
					"step"	=> "1",
					"max" 	=> "50",
					"type" 	=> "sliderui",
					"std" => "0",
					);
				
				$of_options[] = array( "name" => "Logo align",
					"id" => "logo_align",
					"std" => "def",
					"type" => "select",
					"options" => array(
						'def' => 'Default',
						'center' => 'Center'
					));
				
				$of_options[] = array( "name" => "",
						"id" => "a32",
						"std" => "Navigation Menu",
						"type" => "title");
				
				$of_options[] = array( "name" => "Sticky Navigation menu",
					"desc" => __("Enable / Disable Sticky Navigation menu.", 'framework'),
					"id" => "stiky_nav",
					"std" => 0,
					"type" => "switch");
				
				$of_options[] = array( "name" => "Navigation menu Shadow",
					"desc" => __("Enable / Disable Bottom Shadow in Navigation menu.", 'framework'),
					"id" => "navshadow",
					"std" => 1,
					"type" => "switch");
				
		
				$of_options[] = array( "name" => "",
						"id" => "a31",
						"std" => "Main bar",
						"type" => "title");
				
				$of_options[] = array( "name" => "Main bar",
					"desc" => __("Enable / Disable main bar after Header.", 'framework'),
					"id" => "main_bar",
					"std" => 1,
					"type" => "switch");
				
				$of_options[] = array( "name" => "Search Form",
					"desc" => __("Enable / Disable Search Form in main bar.", 'framework'),
					"id" => "h_search",
					"std" => 1,
					"type" => "switch");
				
				$of_options[] = array( "name" => "",
						"id" => "a30",
						"std" => "Breaking News",
						"type" => "title");
				
				$of_options[] = array( "name" => "Breaking News",
					"desc" => __("Enable / Disable Breaking News.", 'framework'),
					"id" => "breaking_en",
					"std" => 1,
					"folds" => 1,
					"type" => "switch");
				
				$of_options[] = array( "name" => "Breaking title",
					"id" => "br_tite",
					"std" => "Latest News",
					"fold" => "breaking_en",
					"type" => "text");
				
				$of_options[] = array( "name" => "Breaking News Display",
					"id" => "breaking_display",
					"std" => "latest",
					"type" => "select",
					"fold" => "breaking_en",
					"options" => array(
						'latest' => 'Latest News',
						'cat' => 'Category',
						'custom' => 'Custom',	
					));
				
				$of_options[] = array( "name" => "The Category",
					"id" => "breaking_category",
					"type" => "select",
					"fold" => "breaking_en",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "Custom Text",
					"desc" => __("Insert Custom Text, One Sentence Per Line.", 'framework'),
					"id" => "breaking_custom",
					"type" => "textarea",
					"fold" => "breaking_en",
					);
				
				$of_options[] = array( "name" => "Number of posts",
					"id" => "breaking_number",
					"min" 	=> "5",
					"step"	=> "1",
					"max" 	=> "50",
					"type" 	=> "sliderui",
					"std" => "10",
					"fold" => "breaking_en",
					);
				
				$of_options[] = array( "name" => "Delay Time",
					"id" => "breaking_delay",
					"min" 	=> "500",
					"step"	=> "500",
					"max" 	=> "6000",
					"type" 	=> "sliderui",
					"std" => "1000",
					"fold" => "breaking_en",
					);
				
				$of_options[] = array( "name" => "Duration Time",
					"id" => "breaking_duration",
					"min" 	=> "3000",
					"step"	=> "100",
					"max" 	=> "10000",
					"type" 	=> "sliderui",
					"std" => "7000",
					"fold" => "breaking_en",
					);
// Home Settings
$of_options[] = array( "name" => "Home Settings",
					"type" => "heading");
					
				$of_options[] = array( "name" => "Home Page Display",
					"id" => "hp_display",
					"std" => "nb",
					"type" => "select",
					"options" => array(
						'nb' => 'News Boxes',
						'blog' => 'Blog'
					));
				
				$of_options[] = array( "name" => "Homepage Layout Manager",
					"desc" => __("Organize how you want the layout to appear on the homepage", 'framework'),
					"id" => "homepage_build",
					"std" => $of_options_homepage_blocks,
					"type" => "sorter");
				
				$of_options[] = array( "name" => "Blog Style",
					"desc" => __("Select Blog Style, Choose between Small , Big , Masonry Style", 'framework'),
					"id" => "blog_style",
					"std" => "style1",
					"type" => "radio",
					"options" => array(
						'style1' => 'Style1 (Small)',
						'style2' => 'Style2 (Big)',
						'masonry' => 'Masonry'
					));
				
				$of_options[] = array( "name" => "Enable Slider",
					"desc" => __("Enable Feature Slider in homepage If used blog Style.", 'framework'),
					"id" => "slider_blog",
					"std" => 0,
					"type" => "switch",
					);
				
				$of_options[] = array( "name" => "Enable Scroller",
					"desc" => __("Enable Carousel in homepage If used blog Style.", 'framework'),
					"id" => "c_blog",
					"std" => 0,
					"type" => "switch",
					);
//Sliders
$of_options[] = array( "name" => "Slider Settings",
					"type" => "heading");

				$of_options[] = array( "name" => "Sliders",
					"desc" => __("Select your Slider, Choose between Default , Cycle , Filex Slider , Caro", 'framework'),
					"id" => "sliders",
					"std" => "def",
					"type" => "select",
					"options" => array(
						'def' => 'Default Slider',
						'cyc' => 'Cycle Slider',
						'filex' => 'Filex Slider',
						'caro' => 'Caro Slider',
					));
				
				
				$of_options[] = array( "name" => "Slider Display",
					"id" => "sli_display",
					"std" => "latest",
					"type" => "select",
					"options" => array(
						'cat' => 'Category',
						'latest' => 'Latest News',
						'tag' => 'Tags'
					));
				
				$of_options[] = array( "name" => "The Category",
					"id" => "sli_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "The Tag",
					"id" => "sli_tag",
					"type" => "select",
					"options" => $of_tags);
				
				$of_options[] = array( "name" => "Number of posts",
					"id" => "slider_count",
					"min" 	=> "1",
					"step"	=> "1",
					"max" 	=> "10",
					"type" 	=> "sliderui",
					"std" => "6",
					);
				
				$of_options[] = array( "name" => "",
						"id" => "a29",
						"std" => "Animation & Effects",
						"type" => "title");
				
				//Cycle
				$of_options[] = array( "name" => "Animation Effect",
					"id" => "cycle_effect",
					"std" => "fade",
					"type" => "select",
					"options" => array(
						'all' => 'All',
						'blindX' => 'blindX',
						'blindY' => 'blindY',
						'blindZ' => 'blindZ',
						'cover' => 'cover',
						'curtainX' => 'curtainX',
						'curtainY' => 'curtainY',
						'fade' => 'fade',
						'fadeZoom' => 'fadeZoom',
						'growX' => 'growX',
						'growY' => 'growY',
						'none' => 'none',
						'scrollUp' => 'scrollUp',
						'scrollDown' => 'scrollDown',
						'scrollLeft' => 'scrollLeft',
						'scrollRight' => 'scrollRight',
						'scrollHorz' => 'scrollHorz',
						'scrollVert' => 'scrollVert',
						'shuffle' => 'shuffle',
						'slideX' => 'slideX',
						'slideY' => 'slideY',
						'toss' => 'toss',
						'turnUp' => 'turnUp',
						'turnDown' => 'turnDown',
						'turnLeft' => 'turnLeft',
						'turnRight' => 'turnRight',
						'uncover' => 'uncover',
						'wipe' => 'wipe',
						'zoom' => 'zoom',
					));
				
				// Filex
				$of_options[] = array( "name" => "Animation Effect",
					"id" => "filex_effect",
					"std" => "fade",
					"type" => "select",
					"options" => array(
						'fade' => 'fade',
						'slide' => 'slide',
					));
				
				
				$of_options[] = array( "name" => "SlideShow Speed",
					"id" => "sli_speed",
					"min" 	=> "100",
					"step"	=> "100",
					"max" 	=> "7000",
					"type" 	=> "sliderui",
					"std" => "1000",
					);
//Carousel
$of_options[] = array( "name" => "Carousel Options",
					"type" => "heading");

				
				$of_options[] = array( "name" => "Tabs Style",
					"desc" => __("Select Carousel Style.", 'framework'),
					"id" => "nc_style",
					"std" => "def",
					"type" => "images",
					"options" => array(
						'def' => $url . 'car1.png',
						'style1' => $url . 'car2.png')
					);

				$of_options[] = array( "name" => "Carousel Display",
					"id" => "nc_display",
					"std" => "latest",
					"type" => "select",
					"options" => array(
						'latest' => 'Latest News',
						'cat' => 'Category',
						'tag' => 'Tags'
					));
				
				$of_options[] = array( "name" => "The Category",
					"id" => "nc_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "The Tag",
					"id" => "nc_tag",
					"type" => "select",
					"options" => $of_tags);
				
				$of_options[] = array( "name" => "Carousel Title",
					"id" => "nc_title",
					"std" => "Scroller",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "Number of posts",
					"id" => "nc_posts",
					"min" 	=> "0",
					"step"	=> "1",
					"max" 	=> "50",
					"type" 	=> "sliderui",
					"std" => "8",
					);
				
				$of_options[] = array( "name" => "Auto Scroll",
					"id" => "c_auto",
					"type" => "switch",
					"std" => 0,
					);
				
				$of_options[] = array( "name" => "Auto Scroll Timeout",
					"id" => "c_auto_time",
					"min" 	=> "100",
					"step"	=> "100",
					"max" 	=> "7000",
					"type" 	=> "sliderui",
					"std" => "5000",
					);
				
				$of_options[] = array( "name" => "Scroll Speed",
					"id" => "c_speed",
					"min" 	=> "100",
					"step"	=> "100",
					"max" 	=> "7000",
					"type" 	=> "sliderui",
					"std" => "300",
					);
//Latest Vidoes
$of_options[] = array( "name" => "Latest Videos",
					"type" => "heading");

					
				$of_options[] = array( "name" => "Videos Title",
					"id" => "lv_title",
					"std" => "Latest Videos",
					"type" => "text",
					);

				$of_options[] = array( "name" => "Videos Order",
					"id" => "lv_order",
					"std" => "",
					"type" => "select",
					"options" => array(
						'' => __('Latest', 'framework'),
						'rand' => __('Random', 'framework'),
						'comment_count' => __('Popular', 'framework')
					));
				

				$of_options[] = array( "name" => "Number of Videos",
					"id" => "lv_count",
					"min" 	=> "0",
					"step"	=> "1",
					"max" 	=> "50",
					"type" 	=> "sliderui",
					"std" => "8",
					);
				
				$of_options[] = array( "name" => "Auto Scroll",
					"id" => "lv_auto",
					"type" => "switch",
					"std" => 0,
					);
				
				$of_options[] = array( "name" => "Auto Scroll Timeout",
					"id" => "lv_auto_time",
					"min" 	=> "100",
					"step"	=> "100",
					"max" 	=> "7000",
					"type" 	=> "sliderui",
					"std" => "300",
					);
				
				$of_options[] = array( "name" => "Scroll Speed",
					"id" => "lv_speed",
					"min" 	=> "100",
					"step"	=> "100",
					"max" 	=> "7000",
					"type" 	=> "sliderui",
					"std" => "300",
					);
//News Boxes
$of_options[] = array( "name" => "News Boxes",
					"type" => "heading");

				$of_options[] = array( "name" => "",
					"id" => "a28",
					"std" => "News Box #1",
					"type" => "title");
				
				$of_options[] = array( "name" => "News Box Display",
					"id" => "nb1_display",
					"std" => "latest",
					"type" => "select",
					"options" => array(
						'cat' => 'Category',
						'latest' => 'Latest News',
						'tag' => 'Tags'
					));
				
				$of_options[] = array( "name" => "News Box Category",
					"id" => "nb1_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "News Box Tag",
					"id" => "nb1_tag",
					"type" => "select",
					"options" => $of_tags);
				
				$of_options[] = array( "name" => "News Box Title",
					"id" => "nb1_title",
					"std" => "News Box Title",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "No of Posts",
					"id" => "nb1_posts",
					"min" 	=> "1",
					"step"	=> "1",
					"max" 	=> "100",
					"type" 	=> "sliderui",
					"std" => "4",
					);
				
				$of_options[] = array( "name" => "News Box Style",
					"desc" => __("Select News Box Style. Choose between 1,2,3,4,5 Styles.", 'framework'),
					"id" => "nb1_style",
					"std" => "style1",
					"type" => "images",
					"options" => array(
						'style1' => $url . 'st1.png',
						'style2' => $url . 'st2.png',
						'style3' => $url . 'st3.png',
						'style4' => $url . 'st4.png',
						'style5' => $url . 'st5.png',
					));
				
				$of_options[] = array( "name" => "Excerpt Length",
					"id" => "nb1_num",
					"std" => "140",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "Title Limit",
					"desc" => __("number of characters in the title if empty will show full title.", 'framework'),
					"id" => "nb1_tl",
					"std" => "",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "",
					"id" => "a27",
					"std" => "News Box #2",
					"type" => "title");
				
				$of_options[] = array( "name" => "News Box Display",
					"id" => "nb2_display",
					"std" => "latest",
					"type" => "select",
					"options" => array(
						'cat' => 'Category',
						'latest' => 'Latest News',
						'tag' => 'Tags'
					));
				
				$of_options[] = array( "name" => "News Box Category",
					"id" => "nb2_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "News Box Tag",
					"id" => "nb2_tag",
					"type" => "select",
					"options" => $of_tags);
				
				$of_options[] = array( "name" => "News Box Title",
					"id" => "nb2_title",
					"std" => "News Box Title",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "No of Posts",
					"id" => "nb2_posts",
					"min" 	=> "1",
					"step"	=> "1",
					"max" 	=> "100",
					"type" 	=> "sliderui",
					"std" => "4",
					);
				
				$of_options[] = array( "name" => "News Box Style",
					"desc" => __("Select News Box Style. Choose between 1,2,3,4,5 Styles.", 'framework'),
					"id" => "nb2_style",
					"std" => "style2",
					"type" => "images",
					"options" => array(
						'style1' => $url . 'st1.png',
						'style2' => $url . 'st2.png',
						'style3' => $url . 'st3.png',
						'style4' => $url . 'st4.png',
						'style5' => $url . 'st5.png',
					));
				
				$of_options[] = array( "name" => "Excerpt Length",
					"id" => "nb2_num",
					"std" => "140",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "Title Limit",
					"desc" => __("number of characters in the title if empty will show full title.", 'framework'),
					"id" => "nb2_tl",
					"std" => "",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "",
					"id" => "a26",
					"std" => "News Box #3",
					"type" => "title");
				
				$of_options[] = array( "name" => "News Box Display",
					"id" => "nb3_display",
					"std" => "latest",
					"type" => "select",
					"options" => array(
						'cat' => 'Category',
						'latest' => 'Latest News',
						'tag' => 'Tags'
					));
				
				$of_options[] = array( "name" => "News Box Category",
					"id" => "nb3_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "News Box Tag",
					"id" => "nb3_tag",
					"type" => "select",
					"options" => $of_tags);
				
				$of_options[] = array( "name" => "News Box Title",
					"id" => "nb3_title",
					"std" => "News Box Title",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "No of Posts",
					"id" => "nb3_posts",
					"min" 	=> "1",
					"step"	=> "1",
					"max" 	=> "100",
					"type" 	=> "sliderui",
					"std" => "4",
					);
				
				$of_options[] = array( "name" => "News Box Style",
					"desc" => __("Select News Box Style. Choose between 1,2,3,4,5 Styles.", 'framework'),
					"id" => "nb3_style",
					"std" => "style3",
					"type" => "images",
					"options" => array(
						'style1' => $url . 'st1.png',
						'style2' => $url . 'st2.png',
						'style3' => $url . 'st3.png',
						'style4' => $url . 'st4.png',
						'style5' => $url . 'st5.png',
					));
				
				$of_options[] = array( "name" => "Excerpt Length",
					"id" => "nb3_num",
					"std" => "140",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "Title Limit",
					"desc" => __("number of characters in the title if empty will show full title.", 'framework'),
					"id" => "nb3_tl",
					"std" => "",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "",
					"id" => "a25",
					"std" => "News Box #4",
					"type" => "title");
				
				$of_options[] = array( "name" => "News Box Display",
					"id" => "nb4_display",
					"std" => "latest",
					"type" => "select",
					"options" => array(
						'cat' => 'Category',
						'latest' => 'Latest News',
						'tag' => 'Tags'
					));
				
				$of_options[] = array( "name" => "News Box Category",
					"id" => "nb4_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "News Box Tag",
					"id" => "nb4_tag",
					"type" => "select",
					"options" => $of_tags);
				
				$of_options[] = array( "name" => "News Box Title",
					"id" => "nb4_title",
					"std" => "News Box Title",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "No of Posts",
					"id" => "nb4_posts",
					"min" 	=> "1",
					"step"	=> "1",
					"max" 	=> "100",
					"type" 	=> "sliderui",
					"std" => "4",
					);
				
				$of_options[] = array( "name" => "News Box Style",
					"desc" => __("Select News Box Style. Choose between 1,2,3,4,5 Styles.", 'framework'),
					"id" => "nb4_style",
					"std" => "style3",
					"type" => "images",
					"options" => array(
						'style1' => $url . 'st1.png',
						'style2' => $url . 'st2.png',
						'style3' => $url . 'st3.png',
						'style4' => $url . 'st4.png',
						'style5' => $url . 'st5.png',
					));
				
				$of_options[] = array( "name" => "Excerpt Length",
					"id" => "nb4_num",
					"std" => "140",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "Title Limit",
					"desc" => __("number of characters in the title if empty will show full title.", 'framework'),
					"id" => "nb4_tl",
					"std" => "",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "",
					"id" => "a24",
					"std" => "News Box #5",
					"type" => "title");
				
				$of_options[] = array( "name" => "News Box Display",
					"id" => "nb5_display",
					"std" => "latest",
					"type" => "select",
					"options" => array(
						'cat' => 'Category',
						'latest' => 'Latest News',
						'tag' => 'Tags'
					));
				
				$of_options[] = array( "name" => "News Box Category",
					"id" => "nb5_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "News Box Tag",
					"id" => "nb5_tag",
					"type" => "select",
					"options" => $of_tags);
				
				$of_options[] = array( "name" => "News Box Title",
					"id" => "nb5_title",
					"std" => "News Box Title",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "No of Posts",
					"id" => "nb5_posts",
					"min" 	=> "1",
					"step"	=> "1",
					"max" 	=> "100",
					"type" 	=> "sliderui",
					"std" => "4",
					);
				
				$of_options[] = array( "name" => "News Box Style",
					"desc" => __("Select News Box Style. Choose between 1,2,3,4,5 Styles.", 'framework'),
					"id" => "nb5_style",
					"std" => "style4",
					"type" => "images",
					"options" => array(
						'style1' => $url . 'st1.png',
						'style2' => $url . 'st2.png',
						'style3' => $url . 'st3.png',
						'style4' => $url . 'st4.png',
						'style5' => $url . 'st5.png',
					));
				
				$of_options[] = array( "name" => "Excerpt Length",
					"id" => "nb5_num",
					"std" => "140",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "Title Limit",
					"desc" => __("number of characters in the title if empty will show full title.", 'framework'),
					"id" => "nb5_tl",
					"std" => "",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "",
					"id" => "a23",
					"std" => "News Box #6",
					"type" => "title");
				
				$of_options[] = array( "name" => "News Box Display",
					"id" => "nb6_display",
					"std" => "latest",
					"type" => "select",
					"options" => array(
						'cat' => 'Category',
						'latest' => 'Latest News',
						'tag' => 'Tags'
					));
				
				$of_options[] = array( "name" => "News Box Category",
					"id" => "nb6_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "News Box Tag",
					"id" => "nb6_tag",
					"type" => "select",
					"options" => $of_tags);
				
				$of_options[] = array( "name" => "News Box Title",
					"id" => "nb6_title",
					"std" => "News Box Title",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "No of Posts",
					"id" => "nb6_posts",
					"min" 	=> "1",
					"step"	=> "1",
					"max" 	=> "100",
					"type" 	=> "sliderui",
					"std" => "4",
					);
				
				$of_options[] = array( "name" => "News Box Style",
					"desc" => __("Select News Box Style. Choose between 1,2,3,4,5 Styles.", 'framework'),
					"id" => "nb6_style",
					"std" => "style5",
					"type" => "images",
					"options" => array(
						'style1' => $url . 'st1.png',
						'style2' => $url . 'st2.png',
						'style3' => $url . 'st3.png',
						'style4' => $url . 'st4.png',
						'style5' => $url . 'st5.png',
					));
				
				$of_options[] = array( "name" => "Excerpt Length",
					"id" => "nb6_num",
					"std" => "140",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "Title Limit",
					"desc" => __("number of characters in the title if empty will show full title.", 'framework'),
					"id" => "nb6_tl",
					"std" => "",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "",
					"id" => "a22",
					"std" => "News Box #7",
					"type" => "title");
				
				$of_options[] = array( "name" => "News Box Display",
					"id" => "nb7_display",
					"std" => "cat",
					"type" => "select",
					"options" => array(
						'cat' => 'Category',
						'latest' => 'Latest News',
						'tag' => 'Tags'
					));
				
				$of_options[] = array( "name" => "News Box Category",
					"id" => "nb7_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "News Box Tag",
					"id" => "nb7_tag",
					"type" => "select",
					"options" => $of_tags);
				
				$of_options[] = array( "name" => "News Box Title",
					"id" => "nb7_title",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "No of Posts",
					"id" => "nb7_posts",
					"min" 	=> "1",
					"step"	=> "1",
					"max" 	=> "100",
					"type" 	=> "sliderui",
					"std" => "4",
					);
				
				$of_options[] = array( "name" => "News Box Style",
					"desc" => __("Select News Box Style. Choose between 1,2,3,4,5 Styles.", 'framework'),
					"id" => "nb7_style",
					"std" => "style1",
					"type" => "images",
					"options" => array(
						'style1' => $url . 'st1.png',
						'style2' => $url . 'st2.png',
						'style3' => $url . 'st3.png',
						'style4' => $url . 'st4.png',
						'style5' => $url . 'st5.png',
					));
				
				$of_options[] = array( "name" => "Excerpt Length",
					"id" => "nb7_num",
					"std" => "140",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "Title Limit",
					"desc" => __("number of characters in the title if empty will show full title.", 'framework'),
					"id" => "nb7_tl",
					"std" => "",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "",
					"id" => "a21",
					"std" => "News Box #8",
					"type" => "title");
				
				$of_options[] = array( "name" => "News Box Display",
					"id" => "nb8_display",
					"std" => "cat",
					"type" => "select",
					"options" => array(
						'cat' => 'Category',
						'latest' => 'Latest News',
						'tag' => 'Tags'
					));
				
				$of_options[] = array( "name" => "News Box Category",
					"id" => "nb8_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "News Box Tag",
					"id" => "nb8_tag",
					"type" => "select",
					"options" => $of_tags);
				
				$of_options[] = array( "name" => "News Box Title",
					"id" => "nb8_title",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "No of Posts",
					"id" => "nb8_posts",
					"min" 	=> "1",
					"step"	=> "1",
					"max" 	=> "100",
					"type" 	=> "sliderui",
					"std" => "4",
					);
				
				$of_options[] = array( "name" => "News Box Style",
					"desc" => __("Select News Box Style. Choose between 1,2,3,4,5 Styles.", 'framework'),
					"id" => "nb8_style",
					"std" => "style1",
					"type" => "images",
					"options" => array(
						'style1' => $url . 'st1.png',
						'style2' => $url . 'st2.png',
						'style3' => $url . 'st3.png',
						'style4' => $url . 'st4.png',
						'style5' => $url . 'st5.png',
					));
				
				$of_options[] = array( "name" => "Excerpt Length",
					"id" => "nb8_num",
					"std" => "140",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "Title Limit",
					"desc" => __("number of characters in the title if empty will show full title.", 'framework'),
					"id" => "nb8_tl",
					"std" => "",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "",
					"id" => "a21",
					"std" => "News Box #9",
					"type" => "title");
				
				$of_options[] = array( "name" => "News Box Display",
					"id" => "nb9_display",
					"std" => "cat",
					"type" => "select",
					"options" => array(
						'cat' => 'Category',
						'latest' => 'Latest News',
						'tag' => 'Tags'
					));
				
				$of_options[] = array( "name" => "News Box Category",
					"id" => "nb9_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "News Box Tag",
					"id" => "nb9_tag",
					"type" => "select",
					"options" => $of_tags);
				
				$of_options[] = array( "name" => "News Box Title",
					"id" => "nb9_title",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "No of Posts",
					"id" => "nb9_posts",
					"min" 	=> "1",
					"step"	=> "1",
					"max" 	=> "100",
					"type" 	=> "sliderui",
					"std" => "4",
					);
				
				$of_options[] = array( "name" => "News Box Style",
					"desc" => __("Select News Box Style. Choose between 1,2,3,4,5 Styles.", 'framework'),
					"id" => "nb9_style",
					"std" => "style1",
					"type" => "images",
					"options" => array(
						'style1' => $url . 'st1.png',
						'style2' => $url . 'st2.png',
						'style3' => $url . 'st3.png',
						'style4' => $url . 'st4.png',
						'style5' => $url . 'st5.png',
					));
				
				$of_options[] = array( "name" => "Excerpt Length",
					"id" => "nb9_num",
					"std" => "140",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "Title Limit",
					"desc" => __("number of characters in the title if empty will show full title.", 'framework'),
					"id" => "nb9_tl",
					"std" => "",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "",
					"id" => "a20",
					"std" => "News Box #10",
					"type" => "title");
				
				$of_options[] = array( "name" => "News Box Display",
					"id" => "nb10_display",
					"std" => "cat",
					"type" => "select",
					"options" => array(
						'cat' => 'Category',
						'latest' => 'Latest News',
						'tag' => 'Tags'
					));
				
				$of_options[] = array( "name" => "News Box Category",
					"id" => "nb10_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "News Box Tag",
					"id" => "nb10_tag",
					"type" => "select",
					"options" => $of_tags);
				
				$of_options[] = array( "name" => "News Box Title",
					"id" => "nb10_title",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "No of Posts",
					"id" => "nb10_posts",
					"min" 	=> "1",
					"step"	=> "1",
					"max" 	=> "100",
					"type" 	=> "sliderui",
					"std" => "4",
					);
				
				$of_options[] = array( "name" => "News Box Style",
					"desc" => __("Select News Box Style. Choose between 1,2,3,4,5 Styles.", 'framework'),
					"id" => "nb10_style",
					"std" => "style1",
					"type" => "images",
					"options" => array(
						'style1' => $url . 'st1.png',
						'style2' => $url . 'st2.png',
						'style3' => $url . 'st3.png',
						'style4' => $url . 'st4.png',
						'style5' => $url . 'st5.png',
					));
				
				$of_options[] = array( "name" => "Excerpt Length",
					"id" => "nb10_num",
					"std" => "140",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "Title Limit",
					"desc" => __("number of characters in the title if empty will show full title.", 'framework'),
					"id" => "nb10_tl",
					"std" => "",
					"type" => "text",
					);
//News Tabs
$of_options[] = array( "name" => "News Tabs",
					"type" => "heading");

					
				$of_options[] = array( "name" => "Tabs Style",
					"desc" => __("Select Tabs Style. Choose between Horizontal / Vertical.", 'framework'),
					"id" => "tabs_style",
					"std" => "style1",
					"type" => "images",
					"options" => array(
						'style1' => $url . 'tab2.png',
						'style2' => $url . 'tab1.png')
					);
				
				$of_options[] = array( "name" => __('Number Of Posts', 'framework'),
					"id" => "tabs_posts",
					"min" 	=> "0",
					"step"	=> "1",
					"max" 	=> "50",
					"type" 	=> "sliderui",
					"std" => "5",
					);
				// Tab1
				$of_options[] = array( "name" => "",
					"id" => "a19",
					"std" => "Tab #1",
					"type" => "title");
				
				
				$of_options[] = array( "name" => "Tab Title",
					"desc" => __('If empty there is no tab', 'framework'),
					"id" => "tab1_title",
					"std" => "Tab Title",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "Tab Display",
					"id" => "tab1_display",
					"std" => "lates",
					"type" => "select",
					"options" => array(
						'cat' => 'Category',
						'lates' => 'Latest News',
						'tag' => 'Tags'
					));
				
				$of_options[] = array( "name" => "The Category",
					"id" => "tab1_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "The Tag",
					"id" => "tab1_tag",
					"type" => "select",
					"options" => $of_tags);
				// Tab2
				$of_options[] = array( "name" => "",
					"id" => "a18",
					"std" => "Tab #2",
					"type" => "title");
				
				
				$of_options[] = array( "name" => "Tab Title",
					"desc" => __('If empty there is no tab', 'framework'),
					"id" => "tab2_title",
					"std" => "Tab2 Title",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "Tab Display",
					"id" => "tab2_display",
					"std" => "lates",
					"type" => "select",
					"options" => array(
						'cat' => 'Category',
						'lates' => 'Latest News',
						'tag' => 'Tags'
					));
				
				$of_options[] = array( "name" => "The Category",
					"id" => "tab2_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "The Tag",
					"id" => "tab2_tag",
					"type" => "select",
					"options" => $of_tags);
				// Tab3
				
				$of_options[] = array( "name" => "",
					"id" => "a17",
					"std" => "Tab #3",
					"type" => "title");
				
				
				$of_options[] = array( "name" => "Tab Title",
					"desc" => __('If empty there is no tab', 'framework'),
					"id" => "tab3_title",
					"std" => "Tab3 Title",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "Tab Display",
					"id" => "tab3_display",
					"std" => "lates",
					"type" => "select",
					"options" => array(
						'cat' => 'Category',
						'lates' => 'Latest News',
						'tag' => 'Tags'
					));
				
				$of_options[] = array( "name" => "The Category",
					"id" => "tab3_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "The Tag",
					"id" => "tab3_tag",
					"type" => "select",
					"options" => $of_tags);
				// Tab4
				$of_options[] = array( "name" => "",
					"id" => "a16",
					"std" => "Tab #4",
					"type" => "title");
				
				
				$of_options[] = array( "name" => "Tab Title",
					"desc" => __('If empty there is no tab', 'framework'),
					"id" => "tab4_title",
					"std" => "Tab4 Title",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "Tab Display",
					"id" => "tab4_display",
					"std" => "lates",
					"type" => "select",
					"options" => array(
						'cat' => 'Category',
						'lates' => 'Latest News',
						'tag' => 'Tags'
					));
				
				$of_options[] = array( "name" => "The Category",
					"id" => "tab4_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "The Tag",
					"id" => "tab4_tag",
					"type" => "select",
					"options" => $of_tags);
				// Tab5
				$of_options[] = array( "name" => "",
					"id" => "a15",
					"std" => "Tab #5",
					"type" => "title");
				
				
				$of_options[] = array( "name" => "Tab Title",
					"desc" => __('If empty there is no tab', 'framework'),
					"id" => "tab5_title",
					"std" => "Tab5 Title",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "Tab Display",
					"id" => "tab5_display",
					"std" => "lates",
					"type" => "select",
					"options" => array(
						'cat' => 'Category',
						'lates' => 'Latest News',
						'tag' => 'Tags'
					));
				
				$of_options[] = array( "name" => "The Category",
					"id" => "tab5_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "The Tag",
					"id" => "tab5_tag",
					"type" => "select",
					"options" => $of_tags);
				// Tab6
				$of_options[] = array( "name" => "",
					"id" => "a14",
					"std" => "Tab #6",
					"type" => "title");
				
				
				$of_options[] = array( "name" => "Tab Title",
					"desc" => __('If empty there is no tab', 'framework'),
					"id" => "tab6_title",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "Tab Display",
					"id" => "tab6_display",
					"std" => "cat",
					"type" => "select",
					"options" => array(
						'cat' => 'Category',
						'lates' => 'Latest News',
						'tag' => 'Tags'
					));
				
				$of_options[] = array( "name" => "The Category",
					"id" => "tab6_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "The Tag",
					"id" => "tab6_tag",
					"type" => "select",
					"options" => $of_tags);
//News Picture
$of_options[] = array( "name" => "News Picture",
					"type" => "heading");

					
				$of_options[] = array( "name" => "Box Style",
					"desc" => __("Select News in picture Box Style. Choose between 1,2 Styles.", 'framework'),
					"id" => "nip_style",
					"std" => "style2",
					"type" => "images",
					"options" => array(
						'style1' => $url . 'nip1.png',
						'style2' => $url . 'nip2.png',
						));

						
				$of_options[] = array( "name" => "The Title",
					"id" => "nip_title",
					"std" => "News Picture",
					"type" => "text",
					);
				
				
				$of_options[] = array( "name" => "News in picture Display",
					"id" => "nip_display",
					"std" => "latest",
					"type" => "select",
					"options" => array(
						'cat' => 'Category',
						'latest' => 'Latest News'
					));
				
				$of_options[] = array( "name" => "The Category",
					"id" => "nip_cat",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "Number of pictures",
					"desc" => __("You can specify the number of pictures if you choose style 2.", 'framework'),
					"id" => "nip_number",
					"min" 	=> "0",
					"step"	=> "1",
					"max" 	=> "50",
					"type" 	=> "sliderui",
					"std" => "14",
					);
//Banners Settings
$of_options[] = array( "name" => "Banners Settings",
					"type" => "heading");

				$of_options[] = array( "name" => "",
						"id" => "a13",
						"std" => "Header Banner",
						"type" => "title");
				
				$of_options[] = array( "name" => "Top Header Banner",
					"desc" => __("Enable / Disable Header banner.", 'framework'),
					"id" => "tbanner",
					"std" => 1,
					"folds" => 1,
					"type" => "switch",
					);
				
				$of_options[] = array( "name" => "Banner Size",
					"id" => "tb_size",
					"std" => "small",
					"type" => "radio",
					"fold" => "tbanner",
					"options" => array(
						'small' => '468*60 (Small)',
						'big' => '728*90 (Big)',
					));
				
				$of_options[] = array( "name" => "Banner Image",
					"id" => "tb_img",
					"std" => "",
					"fold" => "tbanner",
					"type" => "media",
					);
				
				$of_options[] = array( "name" => "Banner URL",
					"id" => "tb_url",
					"std" => "",
					"fold" => "tbanner",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "Adsense Code",
					"id" => "tb_code",
					"std" => "",
					"fold" => "tbanner",
					"type" => "textarea",
					);
				
				$of_options[] = array( "name" => "",
						"id" => "a12",
						"std" => "Bottom Banner",
						"type" => "title");
				
				$of_options[] = array( "name" => "Bottom Banner",
					"desc" => __("Enable / Disable Header banner.", 'framework'),
					"id" => "bbanner",
					"std" => 1,
					"folds" => 1,
					"type" => "switch",
					);
				
				
				$of_options[] = array( "name" => "Banner Image",
					"id" => "bb_img",
					"std" => "",
					"fold" => "bbanner",
					"type" => "media",
					);
				
				$of_options[] = array( "name" => "Banner URL",
					"id" => "bb_url",
					"std" => "",
					"fold" => "bbanner",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "Adsense Code",
					"id" => "bb_code",
					"std" => "",
					"fold" => "bbanner",
					"type" => "textarea",
					);
				
				
				$of_options[] = array( "name" => "",
						"id" => "a11",
						"std" => "Homepage Layout Banner #1",
						"type" => "title");
				
				$of_options[] = array( "name" => "Banner Image",
					"id" => "hb1_img",
					"std" => "",
					"type" => "media",
					);
				
				$of_options[] = array( "name" => "Banner URL",
					"id" => "hb1_url",
					"std" => "",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "Adsense Code",
					"id" => "hb1_code",
					"std" => "",
					"type" => "textarea",
					);
				
				$of_options[] = array( "name" => "",
						"id" => "a10",
						"std" => "Homepage Layout Banner #2",
						"type" => "title");
				
				$of_options[] = array( "name" => "Banner Image",
					"id" => "hb2_img",
					"std" => "",
					"type" => "media",
					);
				
				$of_options[] = array( "name" => "Banner URL",
					"id" => "hb2_url",
					"std" => "",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "Adsense Code",
					"id" => "hb2_code",
					"std" => "",
					"type" => "textarea",
					);
				
				$of_options[] = array( "name" => "",
						"id" => "a9",
						"std" => "Homepage Layout Banner #3",
						"type" => "title");
				
				$of_options[] = array( "name" => "Banner Image",
					"id" => "hb3_img",
					"std" => "",
					"type" => "media",
					);
				
				$of_options[] = array( "name" => "Banner URL",
					"id" => "hb3_url",
					"std" => "",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "Adsense Code",
					"id" => "hb3_code",
					"std" => "",
					"type" => "textarea",
					);
				
				$of_options[] = array( "name" => "",
						"id" => "a8",
						"std" => "Homepage Layout Banner #4",
						"type" => "title");
				
				$of_options[] = array( "name" => "Banner Image",
					"id" => "hb4_img",
					"std" => "",
					"type" => "media",
					);
				
				$of_options[] = array( "name" => "Banner URL",
					"id" => "hb4_url",
					"std" => "",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "Adsense Code",
					"id" => "hb4_code",
					"std" => "",
					"type" => "textarea",
					);
				
				$of_options[] = array( "name" => "",
						"id" => "a7",
						"std" => "Homepage Layout Banner #5",
						"type" => "title");
				
				$of_options[] = array( "name" => "Banner Image",
					"id" => "hb5_img",
					"std" => "",
					"type" => "media",
					);
				
				$of_options[] = array( "name" => "Banner URL",
					"id" => "hb5_url",
					"std" => "",
					"type" => "text",
					);
				
				$of_options[] = array( "name" => "Adsense Code",
					"id" => "hb5_code",
					"std" => "",
					"type" => "textarea",
					);

//Sidebars
$of_options[] = array( "name" => "Sidebars",
					"type" => "heading");

				$of_options[] = array( "name" => "Sidebar Position",
					"desc" => __("Select sidebar alignment.", 'framework'),
					"id" => "sidebar",
					"std" => "right",
					"type" => "images",
					"options" => array(
						'right' => $url . '2cr.png',
						'left' => $url . '2cl.png',
						'3cright' => $url . '3cr.png',
						'3cleft' => $url . '3cl.png')
					);

				$of_options[] = array( "name" => "Home Page sidebar",
					"id" => "hp_sidebar",
					"type" => "select",
					"options" => array( "Select a Sidebar" ) + $of_sidebars);
				
				$of_options[] = array( "name" => "Categories sidebar",
					"id" => "cat_sidebar",
					"type" => "select",
					"options" => array( "Select a Sidebar" ) + $of_sidebars);
				
				$of_options[] = array( "name" => "Pages sidebar",
					"id" => "pages_sidebar",
					"type" => "select",
					"options" => array( "Select a Sidebar" ) + $of_sidebars);
				
				$of_options[] = array( "name" => "Posts sidebar",
					"id" => "posts_sidebar",
					"type" => "select",
					"options" => array( "Select a Sidebar" ) + $of_sidebars);
				
//Social icons
$of_options[] = array( "name" => "Social Networks",
					"type" => "heading");

				$of_options[] = array( "name" => "",
					"id" => "a6",
					"std" => "Header Social Icons options",
					"type" => "title");
				
				$of_options[] = array( "name" => "Header Social Icons",
					"id" => "h_social",
					"std" => 1,
					"folds" => 1,
 					"type" => "switch",
					"desc" => __("Enable / Disable Social Icons In Top Header To custom it from Appearance > Social icons", 'framework'),
					);

				$of_options[] = array( "name" => "",
					"id" => "a5",
					"std" => "Footer Social Icons options",
					"type" => "title");

				$of_options[] = array( "name" => "footer Social Icons",
					"id" => "b_social",
					"std" => 1,
					"folds" => 1,
 					"type" => "switch",
					"desc" => __("Enable / Disable Social Icons In footer.", 'framework'),
					);
				
				$of_options[] = array( "name" => "Facebook",
					"id" => "bs_fb",
					"std" => "https://www.facebook.com/effectivews",
					"type" => "text",
					"fold" => "b_social",
					);
				
				$of_options[] = array( "name" => "Twitter",
					"id" => "bs_twitter",
					"std" => "https://twitter.com/effectivelab",
					"type" => "text",
					"fold" => "b_social",
					);
				
				$of_options[] = array( "name" => "Google+",
					"id" => "bs_gplus",
					"std" => "https://plus.google.com/u/0/communities/114488623733885866375",
					"type" => "text",
					"fold" => "b_social",
					);
				
				$of_options[] = array( "name" => "Linkedin",
					"id" => "bs_linked",
					"std" => "#",
					"type" => "text",
					"fold" => "b_social",
					);
				
				$of_options[] = array( "name" => "Youtube",
					"id" => "bs_youtube",
					"std" => "#",
					"type" => "text",
					"fold" => "b_social",
					);
				
				$of_options[] = array( "name" => "Picasa",
					"id" => "bs_picasa",
					"std" => "",
					"type" => "text",
					"fold" => "b_social",
					);
				
				$of_options[] = array( "name" => "Digg",
					"id" => "bs_digg",
					"std" => "",
					"type" => "text",
					"fold" => "b_social",
					);
				
				$of_options[] = array( "name" => "Vimeo",
					"id" => "bs_vimeo",
					"std" => "#",
					"type" => "text",
					"fold" => "b_social",
					);
				
				$of_options[] = array( "name" => "Feedburner",
					"id" => "bs_feed",
					"std" => "",
					"type" => "text",
					"fold" => "b_social",
					);
//Post Settings
$of_options[] = array( "name" => "Post Settings",
					"type" => "heading");

				$of_options[] = array( "name" => "",
					"id" => "a4",
					"std" => "Post Meta Options",
					"type" => "title");
				
				$of_options[] = array( "name" => "Post Meta",
					"id" => "post_meta",
					"std" => 1,
					"type" => "switch",
					"desc" => __("Enable / Disable Post Meta bar in Posts.", 'framework'),
					);
				
				$of_options[] = array( "name" => "The Date",
					"id" => "meta_date",
					"std" => 1,
					"type" => "switch",
					"desc" => __("Enable / Disable Date in Post Meta.", 'framework'),
					);
				
				$of_options[] = array( "name" => "The Author",
					"id" => "meta_author",
					"std" => 1,
					"type" => "switch",
					"desc" => __("Enable / Disable Author in Post Meta.", 'framework'),
					);
				
				$of_options[] = array( "name" => "The Category",
					"id" => "meta_cat",
					"std" => 1,
					"type" => "switch",
					"desc" => __("Enable / Disable Category in Post Meta.", 'framework'),
					);
				
				$of_options[] = array( "name" => "Comment",
					"id" => "meta_comment",
					"std" => 1,
					"type" => "switch",
					"desc" => __("Enable / Disable Comment in Post Meta.", 'framework'),
					);
				
				$of_options[] = array( "name" => "Font Resize",
					"id" => "meta_resize",
					"std" => 1,
					"type" => "switch",
					"desc" => __("Enable / Disable Font Resize in Post Meta.", 'framework'),
					);
				
				
				$of_options[] = array( "name" => "",
					"id" => "a3",
					"std" => "Post Options",
					"type" => "title");
				
				$of_options[] = array( "name" => "Next/Prev Article",
					"id" => "post_nav",
					"std" => 1,
 					"type" => "switch",
					"desc" => __("Enable / Disable Next/Prev Article.", 'framework'),
					);
				
				$of_options[] = array( "name" => "Post Tags",
					"id" => "post_tags",
					"std" => 1,
 					"type" => "switch",
					"desc" => __("Enable / Disable Post Tags.", 'framework'),
					);
				
				$of_options[] = array( "name" => "Author Box",
					"id" => "author_box",
					"std" => 1,
 					"type" => "switch",
					"desc" => __("Enable / Disable Author Box.", 'framework'),
					);
				
				
				$of_options[] = array( "name" => "",
					"id" => "a2",
					"std" => "Related Posts Options",
					"type" => "title");
				
				$of_options[] = array( "name" => "Related Posts",
					"id" => "relate_posts",
					"std" => 1,
					"folds" => 1,
 					"type" => "switch",
					"desc" => __("Enable / Disable Related Posts.", 'framework'),
					);
				
				$of_options[] = array( "name" => __("Number Of Posts", 'framework'),
					"id" => "related_count",
					"fold" => "relate_posts",
					"min" 	=> "0",
					"step"	=> "1",
					"max" 	=> "50",
					"type" 	=> "sliderui",
					"std" => "4",
					);
				
				$of_options[] = array( "name" => __("Related Posts By", 'framework'),
					"id" => "related_type",
					"type" => "select",
					"std" => "cat",
					"fold" => "relate_posts",	
					"options" => array (
						"cat" => __('Category', 'framework'),
						"tags" => __('Tags', 'framework'),
					)
					);
				
				$of_options[] = array( "name" => __("Related Posts Style", 'theme'),
					"id" => "related_style",
					"type" => "select",
					"std" => "default",
					"fold" => "relate_posts",
					"options" => array (
						'default' => 'Style1(with images)',
						'list' => 'Style2(list)'
					));
				
				$of_options[] = array( "name" => "",
					"id" => "a1",
					"std" => "Share Posts Options",
					"type" => "title");
				
				$of_options[] = array( "name" => "Share Posts",
					"id" => "share_posts",
					"std" => 1,
					"folds" => 1,
 					"type" => "switch",
					"desc" => __("Enable / Disable Share Posts .", 'framework'),
					);
				
				$of_options[] = array( "name" => "FaceBook",
					"id" => "fb_share",
					"std" => 1,
					"fold" => "share_posts",
 					"type" => "switch",
					);
				
				$of_options[] = array( "name" => "Twitter",
					"id" => "twitter_share",
					"std" => 1,
					"fold" => "share_posts",
 					"type" => "switch",
					);
				
				$of_options[] = array( "name" => "Google+",
					"id" => "plus_share",
					"std" => 1,
					"fold" => "share_posts",
 					"type" => "switch",
					);
				
				$of_options[] = array( "name" => "Pinterest",
					"id" => "pin_share",
					"std" => 1,
					"fold" => "share_posts",
 					"type" => "switch",
					);
				
				$of_options[] = array( "name" => "Reddit",
					"id" => "reddit_share",
					"std" => 1,
					"fold" => "share_posts",
 					"type" => "switch",
					);
				
				$of_options[] = array( "name" => "StumbleUpon",
					"id" => "stumble_share",
					"std" => 0,
					"fold" => "share_posts",
 					"type" => "switch",
					);
				
				$of_options[] = array( "name" => "Linkedin",
					"id" => "linkedin_share",
					"std" => 0,
					"fold" => "share_posts",
 					"type" => "switch",
					);
				
				$of_options[] = array( "name" => "Slashdot",
					"id" => "slashdot_share",
					"std" => 0,
					"fold" => "share_posts",
 					"type" => "switch",
					);
				
				$of_options[] = array( "name" => "Tumblr",
					"id" => "tumblr_share",
					"std" => 0,
					"fold" => "share_posts",
 					"type" => "switch",
					);
				
				$of_options[] = array( "name" => "Google Bookmarks",
					"id" => "googleb_share",
					"std" => 0,
					"fold" => "share_posts",
 					"type" => "switch",
					);
				
				$of_options[] = array( "name" => "Newsvine",
					"id" => "newsvine_share",
					"std" => 0,
					"fold" => "share_posts",
 					"type" => "switch",
					);
				
				$of_options[] = array( "name" => "Evernote",
					"id" => "evernote_share",
					"std" => 0,
					"fold" => "share_posts",
 					"type" => "switch",
					);
				
				$of_options[] = array( "name" => "Email",
					"id" => "email_share",
					"std" => 0,
					"fold" => "share_posts",
 					"type" => "switch",
					);
				
//Category Settings
$of_options[] = array( "name" => "Category Settings",
					"type" => "heading");

				$of_options[] = array( "name" => "Category Color in Home page",
					"id" => "home_cats",
					"std" => 0,
 					"type" => "switch",
					"desc" => __("Enable / Disable Category Color in Home page.", 'framework'),
					);

				$of_options[] = array( "name" => "Rss Icon",
					"id" => "category_rss",
					"std" => 1,
 					"type" => "switch",
					"desc" => __("Enable / Disable Rss Feed Subscription in category.", 'framework'),
					);

				$of_options[] = array( "name" => "Description",
					"id" => "category_desc",
					"std" => 1,
 					"type" => "switch",
					"desc" => __("Enable / Disable Category description.", 'framework'),
					);
				
				$of_options[] = array( "name" => "Slider in Category",
					"id" => "cat_slider",
					"std" => 1,
 					"type" => "switch",
					"desc" => __("Enable / Disable Slidshow in Category page.", 'framework'),
					);
				
				$of_options[] = array( "name" => "Number of posts",
					"id" => "cat_filex_posts",
					"min" 	=> "1",
					"step"	=> "1",
					"max" 	=> "100",
					"type" 	=> "sliderui",
					"std" => "4",
					);
				
				$of_options[] = array( "name" => "Animation Effect",
					"id" => "cat_filex_effect",
					"std" => "fade",
					"type" => "select",
					"options" => array(
						'fade' => 'fade',
						'slide' => 'slide',
					));
				
				
				$of_options[] = array( "name" => "SlideShow Speed",
					"id" => "cat_sli_speed",
					"min" 	=> "100",
					"step"	=> "100",
					"max" 	=> "8000",
					"type" 	=> "sliderui",
					"std" => "4000",
					);						
//Typography
$of_options[] = array( "name" => "Typography",
					"type" => "heading");

				$of_options[] = array( "name" => "",
					"id" => "a45",
					"std" => "Body Font",
					"type" => "title");
				
				$of_options[] = array( "name" => "Top Menu Font",
					"id" => "tmenu_font",
					"std" => array('size' => '12px','face' => '','style' => '','color' => ''),
					"type" => "typography");
				
				$of_options[] = array( "name" => "Main Menu Font",
					"id" => "mmenu_font",
					"std" => array('size' => '15px','face' => '','style' => '','color' => ''),
					"type" => "typography");
	
				$of_options[] = array( "name" => "Main Font",
					"id" => "main_font",
					"std" => array('size' => '13px','face' => 'Open Sans','style' => '','color' => ''),
					"type" => "typography");
				
				$of_options[] = array( "name" => "News Title In Homepage",
					"id" => "hpt_font",
					"std" => array('size' => '15px','face' => '','style' => '','color' => ''),
					"type" => "typography");
				
				$of_options[] = array( "name" => "News Boxes & Widget Heading",
					"id" => "nbh_font",
					"std" => array('size' => '17px','face' => '','style' => '','color' => ''),
					"type" => "typography");
				
				$of_options[] = array( "name" => "",
					"id" => "a44",
					"std" => "Headlines",
					"type" => "title");
				
				$of_options[] = array( "name" => "H1",
					"id" => "h1_font",
					"std" => array('size' => '36px','face' => '','style' => '','color' => ''),
					"type" => "typography");
				
				$of_options[] = array( "name" => "H2",
					"id" => "h2_font",
					"std" => array('size' => '30px','face' => '','style' => '','color' => ''),
					"type" => "typography");
				
				$of_options[] = array( "name" => "H3",
					"id" => "h3_font",
					"std" => array('size' => '24px','face' => '','style' => '','color' => ''),
					"type" => "typography");
				
				$of_options[] = array( "name" => "H4",
					"id" => "h4_font",
					"std" => array('size' => '18px','face' => '','style' => '','color' => ''),
					"type" => "typography");
				
				$of_options[] = array( "name" => "H5",
					"id" => "h5_font",
					"std" => array('size' => '14px','face' => '','style' => '','color' => ''),
					"type" => "typography");
				
				$of_options[] = array( "name" => "H6",
					"id" => "h6_font",
					"std" => array('size' => '12px','face' => '','style' => '','color' => ''),
					"type" => "typography");
//Styling
$of_options[] = array( "name" => "Styling Options",
					"type" => "heading");

				$of_options[] = array( "name" => "Theme Style",
					"id" => "t_style",
					"std" => "light",
					"type" => "select",
					"options" => array(
						'light' => 'Light',
						'dark' => 'Dark',
					));

				$of_options[] = array( "name" => "",
						"id" => "a43",
						"std" => "Skins",
						"type" => "title");

				$of_options[] = array( "name" => "Skins",
					"id" => "skin",
					"std" => "",
					"type" => "select",
					"options" => array(
						'' => 'Default (Red)',
						'blue' => 'Blue',
						'orang' => 'Orang',
						'green' => 'Green',
						'peru' => 'peru',
						'pink' => 'Pink',
						'gray' => 'Gray',
					));
				
				$of_options[] = array( "name" => "",
						"id" => "a42",
						"std" => "Background",
						"type" => "title");
					
					
				$of_options[] = array( "name" => "Background Images",
					"desc" => "Select a background pattern.",
					"id" => "body_bg_img",
					"std" => $bg_images_url."brushed_alu_dark.png",
					"type" => "tiles",
					"options" => $bg_images,
					);
				
				$of_options[] = array( "name" => "",
					"desc" => "Or upload your background.",
					"id" => "body_bg_cu",
					"std" => "",
					"type" => "media",
					);
				
				
				$of_options[] = array( "name" => "Background Color",
					"desc" => "Or select a background Color.",
					"id" => "body_bg",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "Full screen background slideshow",
					"id" => "slide_bg",
					"std" => 0,
					"on" => "Enable",
					"off" => "Disable",
					"folds"	=> 1,
					"type" => "switch",
					);
				
				$of_options[] = array( "name" => "",
					"desc" => "Upload background slider images.",
					"id" => "body_bg_sl",
					"std" => "",
					"fold" => "slide_bg",
					"type" => "slider",
					);
				
				$of_options[] = array( "name" => "",
						"id" => "a42df",
						"std" => "Unlimited Colors",
						"type" => "title");
				
				
				$of_options[] = array( "name" => "Links Color",
					"id" => "link_color",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "Links Color in Hover",
					"id" => "link_color_hover",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "",
						"id" => "a41",
						"std" => "Topbar and Top Menu",
						"type" => "title");
				
				
				$of_options[] = array( "name" => "Topbar Background Color",
					"id" => "topbar_bg",
					"std" => "",
					"type" => "color",
					);
				
				
				$of_options[] = array( "name" => "Today Date Background",
					"id" => "date_bg",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "Top Menu Items Color",
					"id" => "top_menu_color",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "Top Menu Items Color in hover",
					"id" => "top_menu_hover",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "Top Menu DropDown Backgorund",
					"id" => "top_drop_bg",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "Top Menu DropDown Hover Backgorund",
					"id" => "top_drop_hover",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "Top Menu DropDown Items Color",
					"id" => "top_drop_color",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "Top Menu DropDown Items Hover Color",
					"id" => "top_drophover_color",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "",
						"id" => "a40",
						"std" => "Header",
						"type" => "title");
				
				$of_options[] = array( "name" => "Header Content Background",
					"id" => "header_bg",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "",
					"desc" => "Select a background pattern.",
					"id" => "header_bg_img",
					"std" => "",
					"type" => "tiles",
					"options" => $bg_images,
					);
				
				$of_options[] = array( "name" => "",
					"desc" => "Or upload your background.",
					"id" => "header_bg_cu",
					"std" => "",
					"type" => "media",
					);
				
				
				$of_options[] = array( "name" => "",
						"id" => "a39",
						"std" => "Navigation Menu",
						"type" => "title");
				
				
				$of_options[] = array( "name" => "Navigation Background",
					"id" => "nav_bg",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "Navigation Border Color",
					"id" => "nav_border",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "Menu Background in hover",
					"id" => "menu_hover_bg",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "Menu Border Bottom in hover",
					"id" => "menu_hover_bottom",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "Menu Item Color",
					"id" => "menu_color",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "Menu Item Hover Color",
					"id" => "menu_color_hover",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "Dropdown Menu Item Color",
					"id" => "drop_menu_color",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "Dropdown Menu Item Hover Color",
					"id" => "drop_menu_color_hover",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "",
						"id" => "a38",
						"std" => "Mainbar Breaking News",
						"type" => "title");
				
				$of_options[] = array( "name" => "Mainbar background",
					"id" => "mainbar_bg",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "Mainbar Border",
					"id" => "mainbar_border",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "Mainbar Border Bottom",
					"id" => "mainbar_bborder",
					"std" => "#c9c9c9",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "breaking news Background",
					"id" => "breaking_bg",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "breaking news Border Color",
					"id" => "breaking_bg_border",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "breaking news Font Color",
					"id" => "breaking_color",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "breaking news wrap background",
					"id" => "breaking_wrap_bg",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "breaking news Items Color",
					"id" => "breaking_items",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "breaking news Items Hover color",
					"id" => "breaking_items_hover",
					"std" => "",
					"type" => "color",
					);
					
				
				$of_options[] = array( "name" => "",
						"id" => "a322",
						"std" => "Notification Box",
						"type" => "title");
				
				$of_options[] = array( "name" => "Notification Box background",
					"id" => "nof_bg",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "Notification Box Border Bottom",
					"id" => "nof_border",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "Notification Box Font",
					"id" => "nof_font",
					"std" => array('size' => '12px','face' => '','style' => '','color' => ''),
					"type" => "typography");
				
				
				$of_options[] = array( "name" => "",
						"std" => "Footer",
						"id" => "a36",
						"type" => "title");
				
				$of_options[] = array( "name" => "Footer Background color",
					"id" => "footer_bg",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "Footer font color",
					"id" => "footer_color",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "Footer Border top color",
					"id" => "footer_border",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "Copyright area background",
					"id" => "copyright_bg",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "Copyright area font color",
					"id" => "copyright_color",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "",
						"id" => "aa9",
						"std" => "Review",
						"type" => "title");
				
				$of_options[] = array( "name" => "review box background",
					"id" => "review_bg",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "review box border",
					"id" => "review_bd",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "review head and footer background",
					"id" => "review_hf_bg",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "review head and footer text color",
					"id" => "review_hf_tx",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "review Criteria background",
					"id" => "review_cr_bg",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "review Criteria color",
					"id" => "review_cr_tx",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "review summary and score bg",
					"id" => "review_ss_bg",
					"std" => "",
					"type" => "color",
					);
				
				$of_options[] = array( "name" => "review summary and score text color",
					"id" => "review_ss_tx",
					"std" => "",
					"type" => "color",
					);
				
				
				$of_options[] = array( "name" => "",
						"id" => "a35",
						"std" => "Custom CSS",
						"type" => "title");
					
				$of_options[] = array( "name" => "Custom CSS",
					"desc" => "Quickly add some CSS to your theme by adding it to this block.",
					"id" => "custom_css",
					"std" => "",
					"type" => "textarea");
				
				$of_options[] = array( "name" => __('Custom CSS For device with 768px width like ipad', 'framework'),
					"id" => "custom_768_css",
					"std" => "",
					"type" => "textarea");
				
				
				$of_options[] = array( "name" => __('Custom CSS For device with 480px width like Landscape phones', 'framework'),
					"id" => "custom_480_css",
					"std" => "",
					"type" => "textarea");
				
				
				$of_options[] = array( "name" => __('Custom CSS For device with 320px width like iPhones', 'framework'),
					"id" => "custom_320_css",
					"std" => "",
					"type" => "textarea");    
//Bottom Settings
$of_options[] = array( "name" => "Bottom Area",
					"type" => "heading");

				$of_options[] = array( "name" => "Bottom Area",
					"desc" => __("Enable / Disable Bottom Area.", 'framework'),
					"id" => "bottom_area",
					"std" => 0,
					"type" => "switch");

				$of_options[] = array( "name" => "Homepage Layout Manager",
					"desc" => __("How many chose boxes that you want to appear on the Bottom", 'framework'),
					"id" => "bottom_build",
					"std" => $of_options_bottomarea_blocks,
					"type" => "sorter");
				
				$of_options[] = array( "name" => "Box1 Category",
					"id" => "bb1_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "No of Posts",
					"id" => "bb1_number",
					"min" 	=> "1",
					"step"	=> "1",
					"max" 	=> "100",
					"type" 	=> "sliderui",
					"std" => "4",
					);
				
				$of_options[] = array( "name" => "Box2 Category",
					"id" => "bb2_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "No of Posts",
					"id" => "bb2_number",
					"min" 	=> "1",
					"step"	=> "1",
					"max" 	=> "100",
					"type" 	=> "sliderui",
					"std" => "4",
					);
				
				$of_options[] = array( "name" => "Box3 Category",
					"id" => "bb3_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "No of Posts",
					"id" => "bb3_number",
					"min" 	=> "1",
					"step"	=> "1",
					"max" 	=> "100",
					"type" 	=> "sliderui",
					"std" => "4",
					);
				
				$of_options[] = array( "name" => "Box4 Category",
					"id" => "bb4_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "No of Posts",
					"id" => "bb4_number",
					"min" 	=> "1",
					"step"	=> "1",
					"max" 	=> "100",
					"type" 	=> "sliderui",
					"std" => "4",
					);
				
				$of_options[] = array( "name" => "Box5 Category",
					"id" => "bb5_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "No of Posts",
					"id" => "bb5_number",
					"min" 	=> "1",
					"step"	=> "1",
					"max" 	=> "100",
					"type" 	=> "sliderui",
					"std" => "4",
					);
				
				$of_options[] = array( "name" => "Box6 Category",
					"id" => "bb6_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "No of Posts",
					"id" => "bb6_number",
					"min" 	=> "1",
					"step"	=> "1",
					"max" 	=> "100",
					"type" 	=> "sliderui",
					"std" => "4",
					);
				
				$of_options[] = array( "name" => "Box7 Category",
					"id" => "bb7_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "No of Posts",
					"id" => "bb7_number",
					"min" 	=> "1",
					"step"	=> "1",
					"max" 	=> "100",
					"type" 	=> "sliderui",
					"std" => "4",
					);
				
				$of_options[] = array( "name" => "Box8 Category",
					"id" => "bb8_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "No of Posts",
					"id" => "bb8_number",
					"min" 	=> "1",
					"step"	=> "1",
					"max" 	=> "100",
					"type" 	=> "sliderui",
					"std" => "4",
					);
				
				$of_options[] = array( "name" => "Box9 Category",
					"id" => "bb9_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "No of Posts",
					"id" => "bb9_number",
					"min" 	=> "1",
					"step"	=> "1",
					"max" 	=> "100",
					"type" 	=> "sliderui",
					"std" => "4",
					);
				
				$of_options[] = array( "name" => "Box10 Category",
					"id" => "bb10_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "No of Posts",
					"id" => "bb10_number",
					"min" 	=> "1",
					"step"	=> "1",
					"max" 	=> "100",
					"type" 	=> "sliderui",
					"std" => "4",
					);
				
				$of_options[] = array( "name" => "Box11 Category",
					"id" => "bb11_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "No of Posts",
					"id" => "bb11_number",
					"min" 	=> "1",
					"step"	=> "1",
					"max" 	=> "100",
					"type" 	=> "sliderui",
					"std" => "4",
					);
				
				$of_options[] = array( "name" => "Box12 Category",
					"id" => "bb12_category",
					"type" => "select",
					"options" => $of_categories);
				
				$of_options[] = array( "name" => "No of Posts",
					"id" => "bb12_number",
					"min" 	=> "1",
					"step"	=> "1",
					"max" 	=> "100",
					"type" 	=> "sliderui",
					"std" => "4",
					);
//Footer Settings
$of_options[] = array( "name" => "Footer Settings",
					"type" => "heading");

				$of_options[] = array( "name" => "Footer Layout",
					"desc" => __("Select Footer Layout", 'framework'),
					"id" => "foot_layout",
					"std" => "fourth",
					"type" => "images",
					"options" => array(
						'one' => $url . '/footer/1.png',
						'one_half' => $url . '/footer/2.png',
						'third' => $url . '/footer/3.png',
						'fourth' => $url . '/footer/4.png',
						'fifth' => $url . '/footer/5.png',
						'sixth' => $url . '/footer/6.png',
						'half_twop' => $url . '/footer/half_twop.png',
						'twop_half' => $url . '/footer/twop_half.png',
						'half_threep' => $url . '/footer/half_threep.png',
						'threep_half' => $url . '/footer/threep_half.png',
						'third_threep' => $url . '/footer/third_threep.png',
						'threep_third' => $url . '/footer/threep_third.png',
						'third_fourp' => $url . '/footer/third_fourp.png',
						'fourp_third' => $url . '/footer/fourp_third.png'
					));

				$of_options[] = array( "name" => "To Top",
					"desc" => __("Enable / Disable To Top.", 'framework'),
					"id" => "totop",
					"std" => 1,
					"type" => "switch");
				
				$of_options[] = array( "name" => "To Top Image",
					"desc" => __("Change to top image.", 'framework'),
					"id" => "totop_img",
					"std" => $eff_images_url."totop.png",
					"type" => "upload");
				

				$of_options[] = array( "name" => "Footer Text",
					"id" => "footer_text",
					"std" => "Some Text Here - Copyright 2012. Powered by WordPress.",
					"type" => "textarea");
				
//Advanced
$of_options[] = array( "name" => "Advanced Options",
					"type" => "heading");

				$of_options[] = array( "name" => "Wordpress Logo",
					"desc" => __("Upload Wordpress admin Login page Logo.", 'framework'),
					"id" => "wp_logo",
					"std" => $eff_images_url."logo.png",
					"type" => "media");

				$of_options[] = array( "name" => "Enable SEO",
					"desc" => __("Disable Theme SEO if you use SEO plugin.", 'framework'),
					"id" => "eff_seo",
					"std" => 1,
					"folds" => 1,
					"type" => "switch");

				$of_options[] = array( "name" => "Meta Description",
					"desc" => __("Enable / Disable Meta Description Tag in pages.", 'framework'),
					"id" => "meta_desc",
					"std" => 1,
					"fold" => "eff_seo",
					"type" => "switch");
				
				$of_options[] = array( "name" => "Keywords",
					"desc" => __("Add you keywords saperate each keyword with comma", 'framework'),
					"id" => "keywords",
					"fold" => "eff_seo",
					"type" => "text");
				
				$of_options[] = array( "name" => "Facebook Open graph",
					"desc" => __("Enable / Disable Facebook Open graph , disbale it if you need to use facebook open graph plugin.", 'framework'),
					"id" => "fb_og",
					"std" => 1,
					"type" => "switch");
				
				$of_options[] = array( "name" => "Exclude Pages from Search",
					"desc" => __("Exclude all Pages from Search Results.", 'framework'),
					"id" => "ex_pages",
					"std" => 1,
					"type" => "switch");
				
				$of_options[] = array( "name" => "Exclude Category from Search",
					"desc" => __("Use minus sign (-) to exclude categories. Example: (2,4,-20) = search only in Category 2 & 4, and exclude Category 20", 'framework'),
					"id" => "ex_cat",
					"type" => "text");
				
				$of_options[] = array( "name" => "",
						"id" => "a3455",
						"std" => "Twitter API",
						"type" => "title");
				
				$of_options[] = array(  "name"  => "Hello there!",
                                                "desc"  => "",
                                                "id"    => "introduction",
                                                "std"   => "This information will uses in Twitter Widget and Social Counter .. You need to create <a href=\"http://iag.me/socialmedia/how-to-create-a-twitter-app-in-8-easy-steps/\" target=\"_blank\">Twitter APP</a> to get this info.",
                                                "icon"  => true,
                                                "type"  => "info");
				
				$of_options[] = array( "name" => "Consumer key",
					"id" => "twitter_ck",
					"std" => "",
					"type" => "text");
				
				$of_options[] = array( "name" => "Consumer secret",
					"id" => "twitter_cs",
					"std" => "",
					"type" => "text");
				
				$of_options[] = array( "name" => "Access token",
					"id" => "twitter_at",
					"std" => "",
					"type" => "text");
				
				$of_options[] = array( "name" => "Access token secret",
					"id" => "twitter_ats",
					"std" => "",
					"type" => "text");
				
// Backup Options
$of_options[] = array( 	"name" 		=> "Backup Options",
						"type" 		=> "heading"
				);
				
$of_options[] = array( 	"name" 		=> "Backup and Restore Options",
						"id" 		=> "of_backup",
						"std" 		=> "",
						"type" 		=> "backup",
						"desc" 		=> 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.',
				);
				
$of_options[] = array( 	"name" 		=> "Transfer Theme Options Data",
						"id" 		=> "of_transfer",
						"std" 		=> "",
						"type" 		=> "transfer",
						"desc" 		=> 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".',
				);		
	}//End function: of_options()
}//End chack if function exists: of_options()
?>