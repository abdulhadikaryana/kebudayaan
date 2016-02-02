<?php
/**
 * GeneratePress Customizer
 *
 * @package Generate
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
add_action( 'customize_register', 'generate_customize_register' );
function generate_customize_register( $wp_customize ) {

	$defaults = generate_get_defaults();

	// Load custom controls
	require_once GENERATE_DIR . '/inc/controls.php';
	
	// $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	// $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	// $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	
	// Change title tagline title to Setup
	$wp_customize->get_section('title_tagline')->title = __( 'Header', 'generate' );
	$wp_customize->get_control('blogdescription')->priority = 3;
	$wp_customize->get_control('blogname')->priority = 1;
	$wp_customize->get_section('static_front_page')->title = __( 'Front Page', 'generate' );
	$wp_customize->get_section('static_front_page')->priority = 10;
	$wp_customize->remove_section('background_image');
	$wp_customize->remove_section('colors');
	//$wp_customize->remove_section('static_front_page');
	$wp_customize->remove_section('nav');
	
	// Remove title
	$wp_customize->add_setting('generate_title');
	
	$wp_customize->add_control(
		'generate_title',
		array(
			'type' => 'checkbox',
			'label' => __('Hide site title','generate'),
			'section' => 'title_tagline',
			'priority' => 2
		)
	);
	
	$wp_customize->add_setting('generate_tagline');
	
	$wp_customize->add_control(
		'generate_tagline',
		array(
			'type' => 'checkbox',
			'label' => __('Hide site tagline','generate'),
			'section' => 'title_tagline',
			'priority' => 4
		)
	);
	
	$wp_customize->add_setting( 'generate_logo' );
 
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'generate_logo',
			array(
				'label' => __('Logo','generate'),
				'section' => 'title_tagline',
				'settings' => 'generate_logo'
			)
		)
	);
	
	$wp_customize->add_section(
		// ID
		'body_section',
		// Arguments array
		array(
			'title' => __( 'Base Colors', 'generate' ),
			'capability' => 'edit_theme_options',
			'priority' => 40
		)
	);
	
		// Add color settings
	$body_colors = array();
	$body_colors[] = array(
		'slug'=>'background_color', 
		'default' => $defaults['background_color'],
		'label' => __('Background Color', 'generate')
	);
	$body_colors[] = array(
		'slug'=>'text_color', 
		'default' => $defaults['text_color'],
		'label' => __('Text Color', 'generate')
	);
	$body_colors[] = array(
		'slug'=>'link_color', 
		'default' => $defaults['link_color'],
		'label' => __('Link Color', 'generate')
	);
	$body_colors[] = array(
		'slug'=>'link_color_hover', 
		'default' => $defaults['link_color_hover'],
		'label' => __('Link Color Hover', 'generate')
	);
	$body_colors[] = array(
		'slug'=>'link_color_visited', 
		'default' => $defaults['link_color_visited'],
		'label' => __('Link Color Visited', 'generate')
	);

	foreach( $body_colors as $color ) {
		// SETTINGS
		$wp_customize->add_setting(
			'generate_settings[' . $color['slug'] . ']', array(
				'default' => $color['default'],
				'type' => 'option', 
				'capability' => 
				'edit_theme_options'
			)
		);
		// CONTROLS
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$color['slug'], 
				array('label' => $color['label'], 
				'section' => 'body_section',
				'settings' => 'generate_settings[' . $color['slug'] . ']')
			)
		);
	}
	
	// Add Layout section
	$wp_customize->add_section(
		// ID
		'layout_section',
		// Arguments array
		array(
			'title' => __( 'Layout', 'generate' ),
			'capability' => 'edit_theme_options',
			'description' => __( 'Allows you to edit your theme\'s layout.', 'generate' ),
			'priority' => 30
		)
	);
	
	// Container width
	$wp_customize->add_setting( 
		'generate_settings[container_width]', 
		array(
			'default' => $defaults['container_width'],
			'type' => 'option'
		)
	);
		
	$wp_customize->add_control( 
		new Generate_Customize_Width_Slider_Control( 
			$wp_customize, 
			'generate_settings[container_width]', 
			array(
				'label' => __('Container Width','generate'),
				'section' => 'layout_section',
				'settings' => 'generate_settings[container_width]',
				'priority' => 0
			)
		)
	);
	
	// Add Header Layout setting
	$wp_customize->add_setting(
		// ID
		'generate_settings[header_layout_setting]',
		// Arguments array
		array(
			'default' => $defaults['header_layout_setting'],
			'type' => 'option'
		)
	);
	
	// Add Header Layout control
	$wp_customize->add_control(
		// ID
		'header_layout_control',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Header Layout', 'generate' ),
			'section' => 'layout_section',
			'choices' => array(
				'fluid-header' => __( 'Fluid / Full Width', 'generate' ),
				'contained-header' => __( 'Contained', 'generate' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_settings[header_layout_setting]',
			'priority' => 5
		)
	);
	
	$wp_customize->add_setting( 
		'generate_settings[center_header]', 
		array(
			'default' => $defaults['center_header'],
			'type' => 'option'
		)
	);
	
	$wp_customize->add_control(
		'generate_settings[center_header]',
		array(
			'type' => 'checkbox',
			'label' => __('Center header','generate'),
			'section' => 'layout_section',
			'priority' => 10
		)
	);
	
	// Add navigation setting
	$wp_customize->add_setting(
		// ID
		'generate_settings[nav_layout_setting]',
		// Arguments array
		array(
			'default' => $defaults['nav_layout_setting'],
			'type' => 'option'
		)
	);
	
	// Add navigation control
	$wp_customize->add_control(
		// ID
		'nav_layout_control',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Navigation Layout', 'generate' ),
			'section' => 'layout_section',
			'choices' => array(
				'fluid-nav' => __( 'Fluid / Full Width', 'generate' ),
				'contained-nav' => __( 'Contained', 'generate' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_settings[nav_layout_setting]',
			'priority' => 15
		)
	);
	
	// Add navigation setting
	$wp_customize->add_setting(
		// ID
		'generate_settings[nav_position_setting]',
		// Arguments array
		array(
			'default' => $defaults['nav_position_setting'],
			'type' => 'option'
		)
	);
	
	// Add navigation control
	$wp_customize->add_control(
		// ID
		'nav_position_control',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Navigation Position', 'generate' ),
			'section' => 'layout_section',
			'choices' => array(
				'nav-below-header' => __( 'Below Header', 'generate' ),
				'nav-above-header' => __( 'Above Header', 'generate' ),
				'nav-float-right' => __( 'Float Right', 'generate' ),
				'nav-left-sidebar' => __( 'Left Sidebar', 'generate' ),
				'nav-right-sidebar' => __( 'Right Sidebar', 'generate' ),
				'' => __( 'No Navigation', 'generate' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_settings[nav_position_setting]',
			'priority' => 20
		)
	);
	
	$wp_customize->add_setting( 
		'generate_settings[center_nav]', 
		array(
			'default' => $defaults['center_nav'],
			'type' => 'option'
		)
	);
	
	$wp_customize->add_control(
		'generate_settings[center_nav]',
		array(
			'type' => 'checkbox',
			'label' => __('Center navigation','generate'),
			'section' => 'layout_section',
			'priority' => 22
		)
	);
	
	// Add content setting
	$wp_customize->add_setting(
		// ID
		'generate_settings[content_layout_setting]',
		// Arguments array
		array(
			'default' => $defaults['content_layout_setting'],
			'type' => 'option'
		)
	);
	
	// Add content control
	$wp_customize->add_control(
		// ID
		'content_layout_control',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Content Layout', 'generate' ),
			'section' => 'layout_section',
			'choices' => array(
				'separate-containers' => __( 'Separate Containers', 'generate' ),
				'one-container' => __( 'One Container', 'generate' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_settings[content_layout_setting]',
			'priority' => 25
		)
	);
	
	// Add Layout setting
	$wp_customize->add_setting(
		// ID
		'generate_settings[layout_setting]',
		// Arguments array
		array(
			'default' => $defaults['layout_setting'],
			'type' => 'option'
		)
	);
	
	// Add Layout control
	$wp_customize->add_control(
		// ID
		'layout_control',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Sidebar Layout', 'generate' ),
			'section' => 'layout_section',
			'choices' => array(
				'left-sidebar' => __( 'Sidebar / Content', 'generate' ),
				'right-sidebar' => __( 'Content / Sidebar', 'generate' ),
				'no-sidebar' => __( 'Content (no sidebars)', 'generate' ),
				'both-sidebars' => __( 'Sidebar / Content / Sidebar', 'generate' ),
				'both-left' => __( 'Sidebar / Sidebar / Content', 'generate' ),
				'both-right' => __( 'Content / Sidebar / Sidebar', 'generate' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_settings[layout_setting]',
			'priority' => 30
		)
	);
	
	// Add Layout setting
	$wp_customize->add_setting(
		// ID
		'generate_settings[blog_layout_setting]',
		// Arguments array
		array(
			'default' => $defaults['blog_layout_setting'],
			'type' => 'option'
		)
	);
	
	// Add Layout control
	$wp_customize->add_control(
		// ID
		'blog_layout_control',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Blog Sidebar Layout', 'generate' ),
			'section' => 'layout_section',
			'choices' => array(
				'left-sidebar' => __( 'Sidebar / Content', 'generate' ),
				'right-sidebar' => __( 'Content / Sidebar', 'generate' ),
				'no-sidebar' => __( 'Content (no sidebars)', 'generate' ),
				'both-sidebars' => __( 'Sidebar / Content / Sidebar', 'generate' ),
				'both-left' => __( 'Sidebar / Sidebar / Content', 'generate' ),
				'both-right' => __( 'Content / Sidebar / Sidebar', 'generate' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_settings[blog_layout_setting]',
			'priority' => 35
		)
	);
	
	// Add footer setting
	$wp_customize->add_setting(
		// ID
		'generate_settings[footer_layout_setting]',
		// Arguments array
		array(
			'default' => $defaults['footer_layout_setting'],
			'type' => 'option'
		)
	);
	
	// Add content control
	$wp_customize->add_control(
		// ID
		'footer_layout_control',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Footer Layout', 'generate' ),
			'section' => 'layout_section',
			'choices' => array(
				'fluid-footer' => __( 'Fluid / Full Width', 'generate' ),
				'contained-footer' => __( 'Contained', 'generate' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_settings[footer_layout_setting]',
			'priority' => 40
		)
	);
	
	// Add footer widget setting
	$wp_customize->add_setting(
		// ID
		'generate_settings[footer_widget_setting]',
		// Arguments array
		array(
			'default' => $defaults['footer_widget_setting'],
			'type' => 'option'
		)
	);
	
	// Add footer widget control
	$wp_customize->add_control(
		// ID
		'footer_widget_control',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Footer Widgets', 'generate' ),
			'section' => 'layout_section',
			'choices' => array(
				'0' => '0',
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4'
			),
			// This last one must match setting ID from above
			'settings' => 'generate_settings[footer_widget_setting]',
			'priority' => 45
		)
	);
}


/**
 * Heading area
 *
 * Since 0.1
 **/
if ( class_exists( 'WP_Customize_Control' ) ) {
    # Adds textarea support to the theme customizer
    class GenerateLabelControl extends WP_Customize_Control {
        public $type = 'label';
        public function __construct( $manager, $id, $args = array() ) {
            $this->statuses = array( '' => __( 'Default', 'generate' ) );
            parent::__construct( $manager, $id, $args );
        }
 
        public function render_content() {
            echo '<span class="generate_customize_label">' . esc_html( $this->label ) . '</span>';
        }
    }
 
}

function generate_customize_preview_css() {
	?>
	<style>
		#customize-control-blogname,
		#customize-control-blogdescription {
			margin-bottom: 0;
		}
		
	</style>
	<?php
}
add_action('customize_controls_print_styles', 'generate_customize_preview_css');