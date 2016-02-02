<?php

/**
 * Initialize the custom theme options.
 */
add_action( 'admin_init', 'custom_theme_options' );

/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {
  
  /**
   * Get a copy of the saved settings array.
   */
  $saved_settings = get_option( 'option_tree_settings', array() );

  /**
   * Custom settings array that will eventually be
   * passes to the OptionTree Settings API Class.
   */
  $custom_settings = array(
    'contextual_help' => array(
      'sidebar'       => ''
    ),
    'sections'        => array(
      array(
        'id'          => 'general',
        'title'       => 'General'
      ),
      array(
        'id'          => 'orn_colors_sec',
        'title'       => 'Color Settings'
      ),
      array(
        'id'          => 'orn_post_sec',
        'title'       => 'Post Settings'
      ),
      array(
        'id'          => 'orn_video_sec',
        'title'       => 'Video Page'
      ),
      array(
        'id'          => 'orn_header_sec',
        'title'       => 'Header Settings'
      ),
      array(
        'id'          => 'orn_footer_sec',
        'title'       => 'Footer Settings'
      ),
      array(
        'id'          => 'orn_categorybackg_sec',
        'title'       => 'Category Background'
      ),
      array(
        'id'          => 'orn_typography_sec',
        'title'       => 'Typography'
      ),
      array(
        'id'          => 'orn_slider_settings',
        'title'       => 'Slider Settings'
      ),
      array(
        'id'          => 'orn_contact_sec',
        'title'       => 'Contact Page'
      ),
      array(
        'id'          => 'orn_sidebars_sec',
        'title'       => 'Sidebars'
      ),
      array(
        'id'          => 'orn_twitter_sec',
        'title'       => 'Twitter App Data'
      ),
      array(
        'id'          => 'orn_tracking_code',
        'title'       => 'Tracking Code'
      ),
      array(
        'id'          => 'orn_rendered_code',
        'title'       => 'Custom CSS'
      ),
      array(
        'id'          => 'orn_under_construction',
        'title'       => 'Under Construction'
      )
    ),
    'settings'        => array(
      array(
        'id'          => 'orn_web_logo',
        'label'       => 'Website Logo',
        'desc'        => 'Upload your Logo. Best fit size is 245x90 pixels.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'orn_web_logo_padding',
        'label'       => 'Website Logo Padding',
        'desc'        => 'Set top and left logo padding here to center the logo.',
        'std'         => '',
        'type'        => 'measurement',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'label'       => 'Search Posts Only',
        'id'          => 'orn_search_posts_only',
        'type'        => 'on_off',
        'desc'        => 'If on pages will be excluded from search results.',
        'std'         => 'off',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'section'     => 'general'
      ),
      array(
        'id'          => 'orn_favicon',
        'label'       => 'Favicon Upload',
        'desc'        => 'Upload favorite icon of the website. File dimension should be 16 x 16 pixels in .png or .ico formats.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'orn_backgroundimage',
        'label'       => 'Background Image/Color',
        'desc'        => 'Upload a background image for the site. Background image overrides background color.',
        'std'         => '',
        'type'        => 'background',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'label'       => 'Select Color Scheme',
        'id'          => 'orn_color_scheme',
        'type'        => 'select',
        'desc'        => 'Select a predefined color scheme.',
        'choices'     => array(
          array(
            'label'       => 'Default',
            'value'       => 'default'
          ),
          array(
            'label'       => 'Beige',
            'value'       => 'beige'
          ),
          array(
            'label'       => 'Blue',
            'value'       => 'blue'
          ),
          array(
            'label'       => 'Celadon',
            'value'       => 'celadon'
          ),
          array(
            'label'       => 'Cherry',
            'value'       => 'cherry'
          ),
          array(
            'label'       => 'Cyan',
            'value'       => 'cyan'
          ),
          array(
            'label'       => 'Dark',
            'value'       => 'dark'
          ),
          array(
            'label'       => 'Green',
            'value'       => 'green'
          ),
          array(
            'label'       => 'Orchid',
            'value'       => 'orchid'
          ),
          array(
            'label'       => 'Red',
            'value'       => 'red',
          )
        ),
        'std'         => 'default',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'section'     => 'orn_colors_sec'
      ),
      array(
        'label'       => 'Custom Color Scheme',
        'id'          => 'orn_color_custom',
        'type'        => 'colorpicker',
        'desc'        => 'Pick a color to create a new scheme based on that color. Default #fc7100',
        'std'         => '',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'section'     => 'orn_colors_sec'
      ),
      array(
        'label'       => 'Custom Menu Color',
        'id'          => 'orn_menu_color',
        'type'        => 'colorpicker',
        'desc'        => 'Pick a color for main menu. Default #2e2e2e',
        'std'         => '',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'section'     => 'orn_colors_sec'
      ),
      array(
        'label'       => 'Post Navigation Show/Hide',
        'id'          => 'orn_post_navigation',
        'type'        => 'select',
        'desc'        => 'Show or Hide post navigation in single posts.',
        'choices'     => array(
          array(
            'label'       => 'Show',
            'value'       => 'show'
          ),
          array(
            'label'       => 'Hide',
            'value'       => 'hide'
          )
        ),
        'std'         => 'show',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'section'     => 'orn_post_sec'
      ),
      array(
        'label'       => 'Featured Image Show/Hide',
        'id'          => 'orn_post_featuredimg',
        'type'        => 'select',
        'desc'        => 'Show or Hide Featured Image in single posts.',
        'choices'     => array(
          array(
            'label'       => 'Show',
            'value'       => 'show'
          ),
          array(
            'label'       => 'Hide',
            'value'       => 'hide'
          )
        ),
        'std'         => 'show',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'section'     => 'orn_post_sec'
      ),
      array(
        'label'       => 'Post Tags Show/Hide',
        'id'          => 'orn_post_tags',
        'type'        => 'select',
        'desc'        => 'Show or Hide Post Tags in single posts.',
        'choices'     => array(
          array(
            'label'       => 'Show',
            'value'       => 'show'
          ),
          array(
            'label'       => 'Hide',
            'value'       => 'hide'
          )
        ),
        'std'         => 'show',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'section'     => 'orn_post_sec'
      ),
	  array(
		'id'          => 'orn_videopage_type',
		'label'       => 'Video Page Filter',
		'desc'        => 'Filter videos by category, tag or show all video posts without filter',
		'std'         => 'all',
		'type'        => 'radio',
		'section'     => 'orn_video_sec',
		'rows'        => '',
		'post_type'   => '',
		'taxonomy'    => '',
		'class'       => '',
		'choices'     => array(
		  array(
			'value'       => 'all',
			'label'       => 'All Videos',
			'src'         => ''
		  ),
		  array(
			'value'       => 'category',
			'label'       => 'Category',
			'src'         => ''
		  ),
		  array(
			'value'       => 'tag',
			'label'       => 'Tag',
			'src'         => ''
		  )
		),
	  ),
      array(
        'label'       => 'Filter Videos by Category',
        'id'          => 'orn_videopage_cat',
        'type'        => 'category-select',
        'desc'        => 'Only video posts from selected category will show in video page template.',
        'std'         => '',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
		'condition'   => 'orn_videopage_type:is(category)',
        'section'     => 'orn_video_sec'
      ),
      array(
        'label'       => 'Filter Videos by Tag',
        'id'          => 'orn_videopage_tag',
        'type'        => 'tag-select',
        'desc'        => 'Only video posts that are tagged with tag you selected will show in video page template.',
        'std'         => '',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
		'condition'   => 'orn_videopage_type:is(tag)',
        'section'     => 'orn_video_sec'
      ),
      array(
        'id'          => 'orn_video_posts_per_page',
        'label'       => 'Video Posts per Page',
        'desc'        => 'Enter number of posts to show in Video Page.',
        'std'         => '12',
        'type'        => 'text',
        'section'     => 'orn_video_sec',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
       array(
          'id'          => 'orn_header_leaderboard_type',
          'label'       => 'Header Leaderboard Ad Type',
          'desc'        => 'You can use image, adsense ads or disable the header leaderboard',
          'std'         => 'disable',
          'type'        => 'radio',
		  'section'     => 'orn_header_sec',
          'rows'        => '',
          'post_type'   => '',
          'taxonomy'    => '',
          'class'       => '',
          'choices'     => array(
            array(
              'value'       => 'image',
              'label'       => 'Image',
              'src'         => ''
            ),
            array(
              'value'       => 'adsense',
              'label'       => 'Adsense',
              'src'         => ''
            ),
            array(
              'value'       => 'disable',
              'label'       => 'Disable',
              'src'         => ''
            )
          ),
        ),
      array(
        'label'       => 'Upload Image',
        'id'          => 'orn_header_leaderboard_image',
        'type'        => 'upload',
        'desc'        => 'Upload an image for header leaderboard. Size must be 728x90 pixels.',
        'std'         => '',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
		'condition'	  => 'orn_header_leaderboard_type:is(image)',
        'section'     => 'orn_header_sec'
      ),
      array(
        'label'       => 'Enter a link for Image',
        'id'          => 'orn_header_leaderboard_image_link',
        'type'        => 'text',
        'desc'        => 'Add the link for the image you uploaded above.',
        'std'         => '',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
		'condition'	  => 'orn_header_leaderboard_type:is(image)',
        'section'     => 'orn_header_sec'
      ),
      array(
        'id'          => 'orn_header_leaderboard_adsense',
        'label'       => 'Header Leaderboard Ad Code',
        'desc'        => 'Enter your ad code (Eg. Google Adsense) for the 728x90 header ad area.',
        'std'         => '',
        'type'        => 'textarea-simple',
        'rows'        => '7',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => 'orn-toggle-able orn_header_leaderboard_type-adsense',
		'condition'	  => 'orn_header_leaderboard_type:is(adsense)',
        'section'     => 'orn_header_sec'
      ),	  
      array(
        'id'          => 'orn_headersearch',
        'label'       => 'Search in Main Menu',
        'desc'        => 'Show or Hide the search field on the right side of main menu.',
        'std'         => 'on',
        'type'        => 'on_off',
        'section'     => 'orn_header_sec',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
      ),
      array(
        'id'          => 'orn_copyrighttext',
        'label'       => 'Copyright Text',
        'desc'        => 'Copyright message on footer of the site',
        'std'         => '&copy; Copyright '. date('Y') . ' - ' . get_bloginfo('name') .'.',
        'type'        => 'textarea-simple',
        'section'     => 'orn_footer_sec',
        'rows'        => '5',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'orn_gototop',
        'label'       => 'Go To Top Icon',
        'desc'        => 'Show or Hide Go To Top icon located in footer area.',
        'std'         => 'on',
        'type'        => 'on_off',
        'section'     => 'orn_footer_sec',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
      ),
      array(
        'label'       => 'Custom Background per Category',
        'id'          => 'orn_category_background',
        'type'        => 'list-item',
        'desc'        => '',
        'settings'    => array(
          array(
            'label'       => 'Select Category',
            'id'          => 'orn_cat_bg_select',
            'type'        => 'category-select',
            'desc'        => 'Select a category to add a custom background.',
            'std'         => '',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => ''
          ),
          array(
            'label'       => 'Upload Image',
            'id'          => 'orn_cat_bg_image',
            'type'        => 'background',
            'desc'        => 'Upload an image and configure properties. Note that Image overrides background color.',
            'std'         => '',
			'choices'	  => '',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => ''
          )
        ),
        'std'         => '',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'section'     => 'orn_categorybackg_sec'
      ),
      array(
        'id'          => 'orn_font_body',
        'label'       => 'Body Font',
        'desc'        => 'Select Body Font ( Default Font = Open Sans )',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'orn_typography_sec',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
		'choices' 	  => orn_store_googlefonts()
      ),
      array(
        'id'          => 'orn_font_title',
        'label'       => 'Title Font',
        'desc'        => 'Select Title Font ( Default Font = PT Sans )',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'orn_typography_sec',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
		'choices' 	  => orn_store_googlefonts()
      ),
      array(
        'id'          => 'orn_font_navigation',
        'label'       => 'Navigation Font',
        'desc'        => 'Select Navigation font ( Default Font = Oswald font )',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'orn_typography_sec',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
		'choices' 	  => orn_store_googlefonts()
      ),
	  array(
		'id'          => 'orn_flexislider_type',
		'label'       => 'Slider Type',
		'desc'        => 'Chose Category or Tag for Flexi Slider',
		'std'         => 'category',
		'type'        => 'radio',
		'section'     => 'orn_slider_settings',
		'rows'        => '',
		'post_type'   => '',
		'taxonomy'    => '',
		'class'       => '',
		'choices'     => array(
		  array(
			'value'       => 'category',
			'label'       => 'Category',
			'src'         => ''
		  ),
		  array(
			'value'       => 'tag',
			'label'       => 'Tag',
			'src'         => ''
		  )
		),
	  ),
      array(
        'label'       => 'Select Category for Slider',
        'id'          => 'orn_flexislider_cat',
        'type'        => 'category-select',
        'desc'        => 'All posts from selected category will show on slider.',
        'std'         => '',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
		'condition'	  => 'orn_flexislider_type:is(category)',
        'section'     => 'orn_slider_settings',
      ),
      array(
        'label'       => 'Select Tag for Slider',
        'id'          => 'orn_flexislider_tag',
        'type'        => 'tag-select',
        'desc'        => 'All posts that are tagged with tag you selected will show in slider.',
        'std'         => '',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
		'condition'	  => 'orn_flexislider_type:is(tag)',
        'section'     => 'orn_slider_settings'
      ),
      array(
        'label'       => 'Number of posts for Slider',
        'id'          => 'orn_flexislider_nrposts',
        'type'        => 'text',
        'desc'        => 'Number of posts to show in Flexi Slider.',
        'std'         => '7',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'section'     => 'orn_slider_settings'
      ),
      array(
        'id'          => 'orn_contactform',
        'label'       => 'Choose a Contact Form',
        'desc'        => 'Choose a contact form which you have created it in Contact Form 7 plugin. This form will be shown on your contact page.',
        'std'         => '',
        'type'        => 'custom-post-type-select',
        'section'     => 'orn_contact_sec',
        'rows'        => '',
        'post_type'   => 'wpcf7_contact_form',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'orn_map_coordinates',
        'label'       => 'Map Coordinates',
        'desc'        => 'Enter your place coordinates on the map. You can find your place coordinates on maps.google.com <br><Br>e.g. 42.672,21.164 - The first number before comma is latitude and the second one after comma is longitude.',
        'std'         => '40.738794,-73.991402',
        'type'        => 'text',
        'section'     => 'orn_contact_sec',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'orn_map_marker',
        'label'       => 'Upload Marker Image',
        'desc'        => 'Upload marker image. It should be a transparent png file in 250x250 pixels. You can write your address on it.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'orn_contact_sec',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
	  array(
		'id'          => 'orn_sidebarinfo',
		'label'       => 'SideBarInfo',
		'desc'        => 'Below you can set/add sidebars and layouts for Home, Categories and Archive. For every Post and Page you can select a custom sidebar and custom sidebar layout in post/page edit mode.',
		'std'         => '',
		'type'        => 'textblock',
		'rows'        => '',
		'post_type'   => '',
		'taxonomy'    => '',
		'class'       => '',
		'section' 	  => 'orn_sidebars_sec',
      ),
      array(
        'id'          => 'orn_customsidebars',
        'label'       => 'Add Custom Sidebars',
        'desc'        => 'Click on "Add New" to add a new sidebar',
        'std'         => '',
        'type'        => 'list-item',
        'section'     => 'orn_sidebars_sec',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'settings'    => array(
          array(
            'id'          => 'orn_sidebarhelper',
            'label'       => 'SideBarHelper',
            'desc'        => '<em>Enter the sidebar name you want to create in the field above.</em>',
            'std'         => '',
            'type'        => 'textblock',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => ''
          )
        )
      ),
      array(
        'id'          => 'orn_sidebar_home',
        'label'       => 'Home Sidebar',
        'desc'        => 'Select your sidebar for Home',
        'std'         => '',
        'type'        => 'sidebar-select',
        'section'     => 'orn_sidebars_sec',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'orn_sidebar_home_layout',
        'label'       => 'Home Sidebar Layout',
        'desc'        => 'You can choose the home sidebar layout here.',
        'std'         => '',
        'type'        => 'radio-image',
        'section'     => 'orn_sidebars_sec',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'left',
            'label'       => 'Left Sidebar',
            'src'         => OT_URL . '/assets/images/layout/left-sidebar.png'
          ),
          array(
            'value'       => 'no-sidebar',
            'label'       => 'No Sidebar - Full Width',
            'src'         => OT_URL . '/assets/images/layout/full-width.png'
          ),
         array(
            'value'       => 'right',
            'label'       => 'Right Sidebar',
            'src'         => OT_URL . '/assets/images/layout/right-sidebar.png'
          )
		),
      ),
      array(
        'id'          => 'orn_sidebar_archive',
        'label'       => 'Archive Sidebar',
        'desc'        => 'Select your sidebar for Archive',
        'std'         => '',
        'type'        => 'sidebar-select',
        'section'     => 'orn_sidebars_sec',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'orn_sidebar_arch_layout',
        'label'       => 'Archives Sidebar Layout',
        'desc'        => 'You can choose the archive sidebar layout here.',
        'std'         => '',
        'type'        => 'radio-image',
        'section'     => 'orn_sidebars_sec',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'left',
            'label'       => 'Left Sidebar',
            'src'         => OT_URL . '/assets/images/layout/left-sidebar.png'
          ),
          array(
            'value'       => 'no-sidebar',
            'label'       => 'No Sidebar - Full Width',
            'src'         => OT_URL . '/assets/images/layout/full-width.png'
          ),
         array(
            'value'       => 'right',
            'label'       => 'Right Sidebar',
            'src'         => OT_URL . '/assets/images/layout/right-sidebar.png'
          )
		),
      ),
      array(
        'id'          => 'orn_sidebar_category',
        'label'       => 'Deafult Category Sidebar',
        'desc'        => 'Select your default sidebar for Categories',
        'std'         => '',
        'type'        => 'sidebar-select',
        'section'     => 'orn_sidebars_sec',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'orn_sidebar_cat_layout',
        'label'       => 'Default Category Sidebar Layout',
        'desc'        => 'You can choose the default category sidebar layout here.',
        'std'         => '',
        'type'        => 'radio-image',
        'section'     => 'orn_sidebars_sec',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'left',
            'label'       => 'Left Sidebar',
            'src'         => OT_URL . '/assets/images/layout/left-sidebar.png'
          ),
          array(
            'value'       => 'no-sidebar',
            'label'       => 'No Sidebar - Full Width',
            'src'         => OT_URL . '/assets/images/layout/full-width.png'
          ),
         array(
            'value'       => 'right',
            'label'       => 'Right Sidebar',
            'src'         => OT_URL . '/assets/images/layout/right-sidebar.png'
          )
		),
      ),
      array(
        'id'          => 'orn_categorysidebars',
        'label'       => 'Custom Sidebar & Sidebar Layout per Category',
        'desc'        => 'Click "Add New" to select a custom sidebar for a category of your choice. <br />To create a new sidebar go to the top of this page.',
        'std'         => '',
        'type'        => 'list-item',
        'section'     => 'orn_sidebars_sec',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'settings'    => array(
		 array(
			'id'          => 'orn_categorysidebars_category',
			'label'       => 'Select Category',
			'desc'        => 'Select a Category which will have a custom sidebar',
			'std'         => '',
			'type'        => 'category-select',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'class'       => ''
		  ),
		  array(
			'id'          => 'orn_categorysidebars_sidebar',
			'label'       => 'Select Category Sidebar',
			'desc'        => 'Select a sidebar for Category selected above',
			'std'         => '',
			'type'        => 'sidebar-select',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'class'       => ''
		  ),
		  array(
			'id'          => 'orn_categorysidebars_layout',
			'label'       => 'Category Sidebar Layout',
			'desc'        => 'Choose the sidebar layout for this category. If set to No Sidebar the above field is overridden',
			'std'         => '',
			'type'        => 'radio-image',
			'section'     => 'orn_sidebars_sec',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'class'       => '',
			'choices'     => array(
			  array(
				'value'       => 'left',
				'label'       => 'Left Sidebar',
				'src'         => OT_URL . '/assets/images/layout/left-sidebar.png'
			  ),
			  array(
				'value'       => 'no-sidebar',
				'label'       => 'No Sidebar - Full Width',
				'src'         => OT_URL . '/assets/images/layout/full-width.png'
			  ),
			 array(
				'value'       => 'right',
				'label'       => 'Right Sidebar',
				'src'         => OT_URL . '/assets/images/layout/right-sidebar.png'
			  )
			),
		  )
        )
      ),
      array(
        'label'       => 'Twitter Application Data',
        'id'          => 'twitter_data_header',
        'type'        => 'textblock-titled',
        'desc'        => '<p>To get the following, you have to create an app in Twitter ( http://dev.twitter.com/apps ) with your twitter account. <em>Information below is required to display latest tweets on Twitter widget</em>.</p>',
        'std'         => '',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'section'     => 'orn_twitter_sec'
      ),
      array(
        'id'          => 'orn_twitter_consumer',
        'label'       => 'Consumer key',
        'desc'        => 'Insert your Twitter Consumer key here',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'orn_twitter_sec',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'orn_twitter_c_secret',
        'label'       => 'Consumer secret',
        'desc'        => 'Insert your Twitter Consumer secret here',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'orn_twitter_sec',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'orn_googleanalytics',
        'label'       => 'Tracking Code',
        'desc'        => 'Enter your Google Analytics (or other) tracking code here. This script will be added after theme footer.',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'orn_tracking_code',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'orn_css_printer',
        'label'       => '',
        'desc'        => '',
        'std'         => orbitnews_custom_css(),
        'type'        => 'css',
        'section'     => 'orn_tracking_code',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => 'hidden'
      ),
      array(
        'id'          => 'orn_usercss',
        'label'       => 'Custom CSS',
        'desc'        => 'Put your custom CSS Codes Here.',
        'std'         => '',
        'type'        => 'css',
        'section'     => 'orn_rendered_code',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'label'       => 'Under Construction',
        'id'          => 'orn_underc_enable',
        'type'        => 'on_off',
        'desc'        => 'If on your visitors will be shown the under construction page.',
        'std'         => 'off',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'section'     => 'orn_under_construction'
      ),
      array(
        'id'          => 'orn_underc_title',
        'label'       => 'Under Construction Title',
        'desc'        => 'The info you want to show to your visitors, while your site is under construction!',
        'std'         => 'Our website is Under Construction',
        'type'        => 'text',
        'section'     => 'orn_under_construction',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
		'condition'	  => 'orn_underc_enable:is(on)'
      ),
      array(
        'id'          => 'orn_underc_date',
        'label'       => 'Launching Date',
        'desc'        => 'Set the date when your site will become available for all visitors.',
        'std'         => '',
        'type'        => 'date-time-picker',
        'section'     => 'orn_under_construction',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
		'condition'	  => 'orn_underc_enable:is(on)'
      ),
      array(
        'id'          => 'orn_underc_logo',
        'label'       => 'Logo for Under Construction page',
        'desc'        => 'Upload a logo or use default logo you uploaded for home.',
        'std'         => ot_get_option( 'orn_web_logo' ),
        'type'        => 'upload',
        'section'     => 'orn_under_construction',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
		'condition'	  => 'orn_underc_enable:is(on)'
      ),
      array(
        'id'          => 'orn_underc_background',
        'label'       => 'Background Image for Under Construction page',
        'desc'        => 'Upload a background image to replace the default one.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'orn_under_construction',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
		'condition'	  => 'orn_underc_enable:is(on)'
      ),
      array(
        'id'          => 'orn_underc_url',
        'label'       => 'URL redirect after going live',
        'desc'        => 'If you want to redirect visitors to a different url after your site becomes available, please put it here, othervise leave it as it is to open your homepage!',
        'std'         => home_url(),
        'type'        => 'text',
        'section'     => 'orn_under_construction',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
		'condition'	  => 'orn_underc_enable:is(on)'
      )
    )
  );

  /* allow settings to be filtered before saving */
  $custom_settings = apply_filters( 'option_tree_settings_args', $custom_settings );

  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( 'option_tree_settings', $custom_settings );
  }

}

/**
 * IMPORT EXPORT THEME OPTIONS
 */
add_action( 'init', 'register_options_pages' );

/**
 * Registers all the required admin pages.
 */
function register_options_pages() {

  // Only execute in admin & if OT is installed
  if ( is_admin() && function_exists( 'ot_register_settings' ) ) {

    // Register the pages
    ot_register_settings( 
      array(
        array( 
          'id'              => 'import_export',
          'pages'           => array(
            array(
              'id'              => 'import_export',
              'parent_slug'     => 'themes.php',
              'page_title'      => 'Theme Options Backup/Restore',
              'menu_title'      => 'Options Backup',
              'capability'      => 'edit_theme_options',
              'menu_slug'       => 'orn-theme-backup',
              'icon_url'        => null,
              'position'        => null,
              'updated_message' => 'Options updated.',
              'reset_message'   => 'Options reset.',
              'button_text'     => 'Save Changes',
              'show_buttons'    => false,
              'screen_icon'     => 'themes',
              'contextual_help' => null,
              'sections'        => array(
				array(
                  'id'          => 'orn_import_export',
                  'title'       => __( 'Import/Export', 'orbitnews' )
                )
              ),
              'settings'        => array(
                array(
					'id'          => 'import_data_text',
					'label'       => 'Import Theme Options',
					'desc'        => __( 'Theme Options', 'orbitnews' ),
					'std'         => '',
					'type'        => 'import-data',
					'section'     => 'orn_import_export',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'class'       => ''
				  ),
				  array(
					'id'          => 'export_data_text',
					'label'       => 'Export Theme Options',
					'desc'        => __( 'Theme Options', 'orbitnews' ),
					'std'         => '',
					'type'        => 'export-data',
					'section'     => 'orn_import_export',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'class'       => ''
				  )
              )
            )
          )
        )
      )
    );

  }

}

/**
 * Import Data option type.
 *
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_import_data' ) ) {
  
  function ot_type_import_data() {
    
    echo '<form method="post" id="import-data-form">';
      
      /* form nonce */
      wp_nonce_field( 'import_data_form', 'import_data_nonce' );
        
      /* format setting outer wrapper */
      echo '<div class="format-setting type-textarea has-desc">';
        
        /* description */
        echo '<div class="description">';
          
          if ( OT_SHOW_SETTINGS_IMPORT ) echo '<p>' . __( 'Only after you\'ve imported the Settings should you try and update your Theme Options.', 'option-tree' ) . '</p>';
          
          echo '<p>' . __( 'To import your Theme Options copy and paste what appears to be a random string of alpha numeric characters into this textarea and press the "Import Theme Options" button.', 'option-tree' ) . '</p>';
          
          /* button */
          echo '<button class="option-tree-ui-button blue right hug-right">' . __( 'Import Theme Options', 'option-tree' ) . '</button>';
          
        echo '</div>';
        
        /* textarea */
        echo '<div class="format-setting-inner">';
          
          echo '<textarea rows="10" cols="40" name="import_data" id="import_data" class="textarea"></textarea>';

        echo '</div>';
        
      echo '</div>';
    
    echo '</form>';
    
  }
  
}

/**
 * Export Data option type.
 *
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_export_data' ) ) {
  
  function ot_type_export_data() {
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-textarea simple has-desc">';
      
      /* description */
      echo '<div class="description">';
        
        echo '<p>' . __( 'Export your Theme Options data by highlighting this text and doing a copy/paste into a blank .txt file. Then save the file for importing into another install of WordPress later. Alternatively, you could just paste it into the <code>OptionTree->Settings->Import</code> <strong>Theme Options</strong> textarea on another web site.', 'option-tree' ) . '</p>';
        
      echo '</div>';
      
      /* get theme options data */
      $data = get_option( 'option_tree' );
      $data = ! empty( $data ) ? ot_encode( serialize( $data ) ) : '';
        
      echo '<div class="format-setting-inner">';
        echo '<textarea rows="10" cols="40" name="export_data" id="export_data" class="textarea">' . $data . '</textarea>';
      echo '</div>';
      
    echo '</div>';
    
  }
  
}
