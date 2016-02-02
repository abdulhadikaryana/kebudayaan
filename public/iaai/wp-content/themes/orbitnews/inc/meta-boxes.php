<?php 
// Register metaboxes on admin init
add_action( 'admin_init', 'custom_meta_boxes' );

function custom_meta_boxes() {
	$meta_boxes = array(	
		// Oembed Audio Box
		array(
			'id'        => 'orn_audio_format',
			'title'     => 'Audio Post',
			'desc'      => 'Select Audio Source',
			'pages'     => array( 'post' ),
			'context'   => 'normal',
			'priority'  => 'high',
			'fields'    => array(
				array(
					'id'          => 'orn_audio_source',
					'label'       => '',
					'desc'        => '',
					'std'         => 'soundcloud',
					'type'        => 'radio',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'class'       => '',
					'choices'     => array(
					  array(
						'value'       => 'soundcloud',
						'label'       => 'Sound Cloud',
						'src'         => ''
					  ),
					  array(
						'value'       => 'selfhosted',
						'label'       => 'Self Hosted',
						'src'         => ''
					  )
					)
				),
				array(
					'id'          => 'orn_sound_cloud',
					'label'       => 'URL to Soundcloud Audio',
					'desc'        => '',
					'std'         => '',
					'type'        => 'text',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'class'       => '',
					'settings'    => '',
					'condition'   => 'orn_audio_source:is(soundcloud)'
				),
				array(
					'id'          => 'orn_self_hosted_mp3',
					'label'       => 'URL to Mp3 file',
					'desc'        => '',
					'std'         => '',
					'type'        => 'text',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'class'       => '',
					'settings'    => '',
					'condition'   => 'orn_audio_source:is(selfhosted)'
				),
				array(
					'id'          => 'orn_self_hosted_m4a',
					'label'       => 'URL to M4A file',
					'desc'        => '',
					'std'         => '',
					'type'        => 'text',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'class'       => '',
					'settings'    => '',
					'condition'   => 'orn_audio_source:is(selfhosted)'
				),
				array(
					'id'          => 'orn_self_hosted_oga',
					'label'       => 'URL to OGA file',
					'desc'        => '',
					'std'         => '',
					'type'        => 'text',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'class'       => '',
					'settings'    => '',
					'condition'   => 'orn_audio_source:is(selfhosted)'
				)
			)
		),
		// Oembed Video Box
		array(
			'id'        => 'orn_video_link',
			'title'     => 'Video Post',
			'desc'      => 'Enter Video Link ( oEmbed supported ).',
			'pages'     => array( 'post' ),
			'context'   => 'normal',
			'priority'  => 'high',
			'fields'    => array(
				array(
					'id'          => 'orn_oembed_videos',
					'label'       => '',
					'desc'        => '',
					'std'         => '',
					'type'        => 'text',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'class'       => '',
					'settings'    => ''
				)
			)
		),
		// Galery Box
		array(
			'id'        => 'orn_metabox_gallery',
			'title'     => 'Gallery Post',
			'desc'      => 'Create Gallery',
			'pages'     => array( 'post' ),
			'context'   => 'normal',
			'priority'  => 'high',
			'fields'    => array(
				array(
					'id'          => 'orn_image_gallery',
					'label'       => '',
					'desc'        => '',
					'std'         => '',
					'type'        => 'gallery',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'class'       => '',
				)
			)
		),
		// Sidebar layout for post and pages
		array(
			'id'        => 'orn_metabox_sidebar',
			'title'     => 'Post/Page Layout',
			'desc'      => 'Layout settings for this post/page. Sidebars can be created in the Theme Options > Sidebars and configured in the Apperance > Widgets.',
			'pages'     => array( 'post','page' ),
			'context'   => 'normal',
			'priority'  => 'high',
			'fields'    => array(
				array(
					'id'          => 'orn_sidebar_layout',
					'label'       => 'Sidebar Layout',
					'desc'        => '',
					'std'         => 'right',
					'type'        => 'radio_image',
					'class'       => '',
					'choices'     => array(
					  array(
						'value'   => 'left',
						'label'   => 'Left Sidebar',
						'src'     => OT_URL . '/assets/images/layout/left-sidebar.png'
					  ),
					  array(
						'value'   => 'no-sidebar',
						'label'   => 'No Sidebar - Full Width',
						'src'     => OT_URL . '/assets/images/layout/full-width.png'
					  ),
					  array(
						'value'   => 'right',
						'label'   => 'Right Sidebar',
						'src'     => OT_URL . '/assets/images/layout/right-sidebar.png'
					  )
					),
				  ),
				  array(
					'id'          => 'orn_post_page_sidebar',
					'label'       => 'Select Sidebar',
					'desc'        => 'Select a custom sidebar for this post/page.',
					'std'         => 'default-sidebar',
					'type'        => 'sidebar-select',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'class'       => ''
				  ),
			)
		),
		// Post Settings 
		array(
			'id'        => 'orn_post_settings',
			'title'     => 'Post Settings',
			'desc'      => '',
			'pages'     => array( 'post' ),
			'context'   => 'normal',
			'priority'  => 'high',
			'fields'    => array(
				  array(
					'id'          => 'orn_post_navigation_meta',
					'label'       => 'Post Navigation Show/Hide',
					'desc'        => 'You can override theme options to show/hide navigation for this post',
					'std'         => '',
					'choices'     => array(
					  array (
						'label'       => 'Default (Theme Options)',
						'value'       => 'default'
					  ),
					  array (
						'label'       => 'Show',
						'value'       => 'show'
					  ),
					  array (
						'label'       => 'Hide',
						'value'       => 'hide'
					  )
					),
					'type'        => 'select',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'class'       => '',
					'settings'    => ''
				
				  ),
				  array(
					'id'          => 'orn_post_featured_meta',
					'label'       => 'Featured Image Show/Hide',
					'desc'        => 'You can override theme options to show/hide Featured image for this post',
					'std'         => '',
					'choices'     => array(
					  array (
						'label'       => 'Default (Theme options)',
						'value'       => 'default'
					  ),
					  array (
						'label'       => 'Show',
						'value'       => 'show'
					  ),
					  array (
						'label'       => 'Hide',
						'value'       => 'hide'
					  )
					),
					'type'        => 'select',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'class'       => '',
					'settings'    => ''
					
				  ), 
				  array(
					'id'          => 'orn_post_tags_meta',
					'label'       => 'Post Tags Show/Hide',
					'desc'        => 'You can override theme options to show/hide tags for this post',
					'std'         => '',
					'choices'     => array(
					  array (
						'label'       => 'Default (Theme options)',
						'value'       => 'default'
					  ),
					  array (
						'label'       => 'Show',
						'value'       => 'show'
					  ),
					  array (
						'label'       => 'Hide',
						'value'       => 'hide'
					  )
					),
					'type'        => 'select',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'class'       => '',
					'settings'    => ''
				  
				  ) // End Post Settings orn_post_tags_meta 
				  
			) // End Post Settings fields array
			
		) // End Post Settings 
		
	); // End $meta_boxes
	
	
	foreach( $meta_boxes as $meta_box ) {
		// Register each metabox from array
		ot_register_meta_box ( $meta_box ); 
	
	} // end foreach		
}

