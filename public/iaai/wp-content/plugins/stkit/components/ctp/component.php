<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	1 - PROJECTS

		1.1 - Register JS & CSS
		1.2 - Include projects

*/

/*===============================================

	P R O J E C T S
	Custom posts

===============================================*/

	/*-------------------------------------------
		1.1 - Register JS & CSS
	-------------------------------------------*/

	function st_projects_register() {

		wp_enqueue_style( 'st-projects-css', get_template_directory_uri() . '/assets/css/ctp.css', false, null, 'all' );
		wp_enqueue_script( 'st-projects-js', get_template_directory_uri() . '/assets/js/jquery.ctp.js', array('jquery'), null, true );

	}
	
	add_action( 'wp_enqueue_scripts', 'st_projects_register' );



	/*-------------------------------------------
		1.2 - Include projects
	-------------------------------------------*/

	include ( plugin_dir_path( __FILE__ ) . '/functions/projects.php' );


?>