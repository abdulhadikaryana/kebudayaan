<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 * Please read them CAREFULLY.
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit:
 * @link http://www.deluxeblogtips.com/meta-box/
 */

/********************* META BOX DEFINITIONS ***********************/

/**
 * Prefix of meta keys (optional)
 * Use underscore (_) at the beginning to make keys hidden
 * Alt.: You also can make prefix empty to disable it
 */

// Better has an underscore as last sign
$prefix = 'eff_';

global $meta_boxes;

$meta_boxes = array();

// Comments for Page
$meta_boxes[] = array(
	'id' => 'comment_page',
	'title' => 'Page Options',
	'pages' => array( 'page' ),
	'context' => 'normal',
	'priority' => 'default',
	'fields' => array(
                array(
			'name'  => 'Enable Page Builder in page',
			'id'    => $prefix . 'page_builder',
			'desc'  => 'Select to remove page wrap',
			'type'  => 'checkbox',
                        'std'   => 0,
		),
		array(
			'name'  => 'Enable Comments in page',
			'id'    => $prefix . 'page_comments',
			'desc'  => '',
			'type'  => 'checkbox',
                        'std'   => 0,
		),
                array(
			'name'  => 'Enable Breadcrumb in page',
			'id'    => $prefix . 'page_breadcrumb',
			'desc'  => '',
			'type'  => 'checkbox',
                        'std'   => 1,
		),
            ),    
	);
// Sidebar Options
$meta_boxes[] = array(
	'id' => 'sidebar_options',
	'title' => 'Sidebar Options',
	'pages' => array( 'post', 'page' ),
	'context' => 'normal',
	'priority' => 'low',
	'fields' => array(
		// Sidbar Options
		array(
			'name'  => 'Sidebar Position',
			'id'    => $prefix . 'sidebar_option',
			'desc'  => '',
                        'class' => 'sidebar_layout',
			'type'  => 'radio',
			'options'  => array(
				'def' => 'Default',
                                'rights' => 'Right Sidebar',
				'fullw' => 'Full Width',
                                'lefts' => 'Left Sidebar',
			),
		),
                
	),
// Article Setup
$meta_boxes[] = array(
	'id' => 'article_settings',
	'title' => 'Article Setup',
	'pages' => array( 'post'),
	'context' => 'normal',
	'priority' => 'default',
	'fields' => array(
            // Article Type
                array(
			'name'  => 'Article Type',
			'id'    => $prefix . 'article_type',
			'desc'  => '',
			'type'  => 'Select',
			'options'  => array(
				'' => 'None',
				'featured' => 'Featured Image',
                                'slider' => 'Slider',
                                'video' => 'Video',
                                'audio' => 'Sound Cloud',
                                //'gmap' => 'Google Map',
			),
		),
                array(
			'name'  => 'Custom Slider',
			'id'    => $prefix . 'slider_option',
			'desc'  => '',
			'type'  => 'thickbox_image',
                        'class' => 'slider_type hide'
		),
                array(
			'name'  => 'Video Type',
			'id'    => $prefix . 'video_type',
			'type'  => 'select',
                        'std' => '',
                        'options'  => array(
				'youtube' => 'Youtube',
                                'vimo' => 'Vimeo',
                                'daily' => 'DailyMotion',
			),
                        'class' => 'video_type hide'
		),
                array(
			'name'  => 'Video ID',
			'id'    => $prefix . 'video_id',
			'desc'  => "exp: http://player.vimeo.com/video/<strong>36829547</strong>. ID = 36829547",
			'type'  => 'Text',
                        'size'  => '50',
                        'class' => 'video_type hide'
		),
                array(
			'name'  => 'Track link',
			'id'    => $prefix . 'audio_url',
			'desc'  => 'exp: https://soundcloud.com/marketplace-radio/did-barefoot-homeless-guy',
			'type'  => 'Text',
                        'size'  => '50',
                        'class' => 'audio_type hide'
		),
//                array(
//			'name'  => 'Google Map url',
//			'id'    => $prefix . 'gm_url',
//			'desc'  => 'exp: http://maps.google.com/?ll=LATITUDE,LONGITUDE&z=ZOOM',
//			'type'  => 'Text',
//                        'size'  => '50',
//                        'class' => 'gm_type hide'
//		),
	),
    ),
// Genral Article Option
$meta_boxes[] = array(
	'id' => 'genral_settings',
	'title' => 'Genral Article Option',
	'pages' => array( 'post'),
	'context' => 'normal',
	'priority' => 'default',
        
        // Genral Article Option
	'fields' => array(
		
		array(
			'name'  => 'Show Post Meta',
			'id'    => $prefix . 'pmeta',
			'type'  => 'checkbox',
			'std'  => 1,
		),
                array(
			'name'  => 'Show Author Bio Box',
			'id'    => $prefix . 'pauthor',
			'desc'  => '',
			'type'  => 'checkbox',
			'std'  => 1,
		),
                array(
			'name'  => 'Show Share Buttons',
			'id'    => $prefix . 'pshare',
			'desc'  => '',
			'type'  => 'checkbox',
			'std'  => 1,
		),
                array(
			'name'  => 'Show Related Posts',
			'id'    => $prefix . 'prelated',
			'desc'  => '',
			'type'  => 'checkbox',
			'std'  => 1,
		),
                array(
			'name'  => 'Enable Comments in Post',
			'id'    => $prefix . 'page_comments',
			'desc'  => '',
			'type'  => 'checkbox',
                        'std'  => 1,
		),
           ),     
	),

// Article Banners Settings
$meta_boxes[] = array(
	'id' => 'banners_settings',
	'title' => 'Article Banners Settings',
	'pages' => array( 'post'),
	'context' => 'normal',
	'priority' => 'default',
	'fields' => array(
            // Above Banner
                array(
			'name'  => 'Custom Above Banner',
			'id'    => $prefix . 'cus_abanner',
			'desc'  => '',
			'type'  => 'wysiwyg',
                        'options' => array(
				'textarea_rows' => 4,
				'teeny'         => true,
			),
		),
            // Below Banner
                array(
			'name'  => 'Custom Below Banner',
			'id'    => $prefix . 'cus_bbanner',
			'desc'  => '',
			'type'  => 'wysiwyg',
                        'options' => array(
				'textarea_rows' => 4,
				'teeny'         => true,
			),
		),
           ),     
	),
);

$rev_icon =  get_stylesheet_directory_uri() . '/lib/tinymce/images/rev_icon.png';
$rt_images =  get_stylesheet_directory_uri() . '/lib/metaboxes/img/eff';

$meta_boxes[] = array(
	'id' => 'review',
	'title' => __('Review Settings', 'theme'),
	'pages' => array('post'),
	'priority' => 'default',
	'fields' => array(
		array(
			'name' => __('Enable Review', 'theme'),
			'id' => $prefix . 'enable_review',
			'type' => 'checkbox',
			'std' => false,
		),

		array(
			'name' => __('Review Position', 'theme'),
			'id' => $prefix . 'review_position',
			'type' => 'radio',
			'std' => 'bottom',
			'class' => 'review_position',
			'desc' => __('If you select <strong>Custom</strong> you can add the review manually by <img style="background:#fff; border:1px solid #e0e0e0; vertical-align:middle;" src="'. $rev_icon .'"> button in the editor', 'theme'),
			'options' => array (
				'top' => '<img class="radio_img" src="'. $rt_images . '/top.png">',
				'bottom' =>'<img class="radio_img" src="'. $rt_images . '/bottom.png">',
				'custom' => '<img class="radio_img" src="'. $rt_images . '/custom.png">'
			)
		),
		
		array(
			'name' => __('Review Style', 'theme'),
			'id' => $prefix . 'review_style',
			'type' => 'radio',
			'std' => 'stars',
			'options' => array (
				'stars' => '<img class="radio_img" src="'. $rt_images . '/stars.png">',
				'percent' =>'<img class="radio_img" src="'. $rt_images . '/percent.png">',
				'points' => '<img class="radio_img" src="'. $rt_images . '/point.png">'
			)
		),

		array(
			'name' => __('Review header', 'theme'),
			'id' => $prefix . 'review_head',
			'type' => 'text',
			'desc' => __('reviw box header leave blank to disable it', 'theme')
		),

		array(
			'name' => __('Review Footer', 'theme'),
			'id' => $prefix . 'review_foot',
			'type' => 'textarea',
			'class' => 'small_textearea',
			'desc' => __('reviw box footer leave blank to disable it', 'theme')
		),

		array(
			'name' => __('Review Summary', 'theme'),
			'id' => $prefix . 'review_summary',
			'type' => 'textarea',
			'class' => 'small_textearea',
			'std' => 'Summary: '
		),

		// score Title
		array(
			'name' => __('Score Title', 'theme'),
			'id' => $prefix . 'rt_score_title',
			'type' => 'text',
			'desc' => __('the text under the score eg: Awesome, Great, Must Buy', 'theme'),
			'std' => 0,
		),

	)
);

$meta_boxes[] = array(
	'id' => 'review_cr',
	'title' => __('Review Criterias', 'theme'),
	'pages' => array('post'),
	'priority' => 'default',
	'fields' => array(

		//CR 1
		array(
			'name' => '<span class="rt_desc">Criteria 1:</span> Name',
			'id' => $prefix . 'rt_cr1_desc',
			'type' => 'text',
		),

		array(
			'name' => '<span class="rt_desc">Criteria 1:</span> Rate',
			'id' => $prefix . 'rt_cr1_rate',
			'type' => 'range',
			'min' => 0,
			'max' => 100,
			'step' => 1,
			'std' => '',
			'suffix' => '%',
			'class' => 'divider',
			'desc' => __('stars = <em class="cr1_stars_rt_prev">--</em> - points = <em class="cr1_points_rt_prev">--</em>', 'theme')
		),

		//CR 2
		array(
			'name' => '<span class="rt_desc">Criteria 2:</span> Name',
			'id' => $prefix . 'rt_cr2_desc',
			'type' => 'text',
		),

		array(
			'name' => '<span class="rt_desc">Criteria 2:</span> Rate',
			'id' => $prefix . 'rt_cr2_rate',
			'type' => 'range',
			'min' => 0,
			'max' => 100,
			'step' => 1,
			'std' => '',
			'suffix' => '%',
			'class' => 'divider',
			'desc' => __('stars = <em class="cr2_stars_rt_prev">--</em> - points = <em class="cr2_points_rt_prev">--</em>', 'theme')
		),

		//CR 3
		array(
			'name' => '<span class="rt_desc">Criteria 3:</span> Name',
			'id' => $prefix . 'rt_cr3_desc',
			'type' => 'text',
		),

		array(
			'name' => '<span class="rt_desc">Criteria 3:</span> Rate',
			'id' => $prefix . 'rt_cr3_rate',
			'type' => 'range',
			'min' => 0,
			'max' => 100,
			'step' => 1,
			'std' => '',
			'suffix' => '%',
			'class' => 'divider',
			'desc' => __('stars = <em class="cr3_stars_rt_prev">--</em> - points = <em class="cr3_points_rt_prev">--</em>', 'theme')
		),

		//CR 4
		array(
			'name' => '<span class="rt_desc">Criteria 4:</span> Name',
			'id' => $prefix . 'rt_cr4_desc',
			'type' => 'text',
		),

		array(
			'name' => '<span class="rt_desc">Criteria 4:</span> Rate',
			'id' => $prefix . 'rt_cr4_rate',
			'type' => 'range',
			'min' => 0,
			'max' => 100,
			'step' => 1,
			'std' => '',
			'suffix' => '%',
			'class' => 'divider',
			'desc' => __('stars = <em class="cr4_stars_rt_prev">--</em> - points = <em class="cr4_points_rt_prev">--</em>', 'theme')
		),

		//CR 5
		array(
			'name' => '<span class="rt_desc">Criteria 5:</span> Name',
			'id' => $prefix . 'rt_cr5_desc',
			'type' => 'text',
		),

		array(
			'name' => '<span class="rt_desc">Criteria 5:</span> Rate',
			'id' => $prefix . 'rt_cr5_rate',
			'type' => 'range',
			'min' => 0,
			'max' => 100,
			'step' => 1,
			'std' => '',
			'suffix' => '%',
			'class' => 'divider',
			'desc' => __('stars = <em class="cr5_stars_rt_prev">--</em> - points = <em class="cr5_points_rt_prev">--</em>', 'theme')
		),

		//CR 6
		array(
			'name' => '<span class="rt_desc">Criteria 6:</span> Name',
			'id' => $prefix . 'rt_cr6_desc',
			'type' => 'text',
		),

		array(
			'name' => '<span class="rt_desc">Criteria 6:</span> Rate',
			'id' => $prefix . 'rt_cr6_rate',
			'type' => 'range',
			'min' => 0,
			'max' => 100,
			'step' => 1,
			'std' => '',
			'suffix' => '%',
			'class' => 'divider',
			'desc' => __('stars = <em class="cr6_stars_rt_prev">--</em> - points = <em class="cr6_points_rt_prev">--</em>', 'theme')
		),

		//CR 7
		array(
			'name' => '<span class="rt_desc">Criteria 7:</span> Name',
			'id' => $prefix . 'rt_cr7_desc',
			'type' => 'text',
		),

		array(
			'name' => '<span class="rt_desc">Criteria 7:</span> Rate',
			'id' => $prefix . 'rt_cr7_rate',
			'type' => 'range',
			'min' => 0,
			'max' => 100,
			'step' => 1,
			'std' => '',
			'suffix' => '%',
			'class' => 'divider',
			'desc' => __('stars = <em class="cr7_stars_rt_prev">--</em> - points = <em class="cr7_points_rt_prev">--</em>', 'theme')
		),

		//CR 8
		array(
			'name' => '<span class="rt_desc">Criteria 8:</span> Name',
			'id' => $prefix . 'rt_cr8_desc',
			'type' => 'text',
		),

		array(
			'name' => '<span class="rt_desc">Criteria 8:</span> Rate',
			'id' => $prefix . 'rt_cr8_rate',
			'type' => 'range',
			'min' => 0,
			'max' => 100,
			'step' => 1,
			'std' => '',
			'suffix' => '%',
			'class' => 'divider',
			'desc' => __('stars = <em class="cr8_stars_rt_prev">--</em> - points = <em class="cr8_points_rt_prev">--</em>', 'theme')
		),

		//CR 9
		array(
			'name' => '<span class="rt_desc">Criteria 9:</span> Name',
			'id' => $prefix . 'rt_cr9_desc',
			'type' => 'text',
		),

		array(
			'name' => '<span class="rt_desc">Criteria 9:</span> Rate',
			'id' => $prefix . 'rt_cr9_rate',
			'type' => 'range',
			'min' => 0,
			'max' => 100,
			'step' => 1,
			'std' => '',
			'suffix' => '%',
			'class' => 'divider',
			'desc' => __('stars = <em class="cr9_stars_rt_prev">--</em> - points = <em class="cr9_points_rt_prev">--</em>', 'theme')
		),

		//CR 10
		array(
			'name' => '<span class="rt_desc">Criteria 10:</span> Name',
			'id' => $prefix . 'rt_cr10_desc',
			'type' => 'text',
		),

		array(
			'name' => '<span class="rt_desc">Criteria 10:</span> Rate',
			'id' => $prefix . 'rt_cr10_rate',
			'type' => 'range',
			'min' => 0,
			'max' => 100,
			'step' => 1,
			'std' => '',
			'suffix' => '%',
			'class' => 'divider',
			'desc' => __('stars = <em class="cr10_stars_rt_prev">--</em> - points = <em class="cr10_points_rt_prev">--</em>', 'theme')
		),


		//final score
		array(
			'name' => '<span class="rt_fs_desc">Score %</span>',
			'id' => $prefix . 'rt_final_score',
			'type' => 'text',
			'std' => 0,
			'class' => 'rt_final_score'
		),

		//final score
		array(
			'name' => '<span class="rt_fs_desc">Score *</span>',
			'id' => $prefix . 'rt_final_score_stars',
			'type' => 'text',
			'std' => 0,
			'class' => 'rt_final_score_stars'
		),

		array(
			'name' => '<span class="rt_fs_desc">Score 8/10</span>',
			'id' => $prefix . 'rt_final_score_po',
			'type' => 'text',
			'std' => 0,
			'class' => 'rt_final_score_po'
		),
		
	)
);
        

/********************* META BOX REGISTERING ***********************/

/**
 * Register meta boxes
 *
 * @return void
 */
function eff_register_meta_boxes()
{
	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( !class_exists( 'RW_Meta_Box' ) )
		return;

	global $meta_boxes;
	foreach ( $meta_boxes as $meta_box )
	{
		new RW_Meta_Box( $meta_box );
	}
}
// Hook to 'admin_init' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_action( 'admin_init', 'eff_register_meta_boxes' );