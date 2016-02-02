<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	1 - PROJECTS

		1.1 - Post
		1.2 - Category
		1.3 - Tag
		1.4 - Format

	2 - COLUMNS

*/

/*===============================================

 	P R O J E C T S
	Custom Type Posts

===============================================*/

	function st_project_register() {

		global
			$st_Options,
			$st_Settings;


		/*-------------------------------------------
			1.1 - Post
		-------------------------------------------*/

		$st_post = !empty( $st_Settings['ctp_post'] ) ? $st_Settings['ctp_post'] : $st_Options['ctp']['post'];
		$st_category = !empty( $st_Settings['ctp_category'] ) ? $st_Settings['ctp_category'] : $st_Options['ctp']['category'];
		$st_tag = !empty( $st_Settings['ctp_tag'] ) ? $st_Settings['ctp_tag'] : $st_Options['ctp']['tag'];

		$slug_post = !empty( $st_Settings['slug_post'] ) ? $st_Settings['slug_post'] : 'project';
		$slug_category = !empty( $st_Settings['slug_category'] ) ? $st_Settings['slug_category'] : 'projects';
		$slug_tag = !empty( $st_Settings['slug_tag'] ) ? $st_Settings['slug_tag'] : 'tagged';

		$args = array(
				$labels = array(
					'name'					=> __( 'Projects', 'stkit' ),
					'singular_name'			=> __( 'Project', 'stkit' ),
					'add_new'				=> __( 'Add New', 'stkit' ),
					'add_new_item'			=> __( 'Add New Project', 'stkit' ),
					'edit_item'				=> __( 'Edit Project', 'stkit' ),
					'new_item'				=> __( 'New Project', 'stkit' ),
					'view_item'				=> __( 'View Project', 'stkit' ),
					'search_items'			=> __( 'Search Project', 'stkit' ),
					'not_found'				=> __( 'No projects found', 'stkit' ),
					'not_found_in_trash'	=> __( 'No projects found in Trash', 'stkit' ), 
					'parent_item_colon'		=> ''
				),
				'labels'				=> $labels,
				'description'			=>	__( 'A group of posts which can be used as portfolio.', 'stkit' ),
				'public'				=> true,
				'publicly_queryable'	=> true,
				'show_ui'				=> true,
				'capability_type'		=> 'post',
				'menu_position'			=> 5,
				'hierarchical'			=> false,
				'rewrite'				=> array( 'slug' => $slug_post, 'with_front' => true ),
				'query_var'				=> true,
				'has_archive'			=> true,
				'supports'				=> array( 'title', 'editor', 'thumbnail', 'comments', 'author', 'page-attributes', 'excerpt' )
			);
	
		register_post_type( $st_post , $args );
	
	
		/*-------------------------------------------
			1.2 - Category
		-------------------------------------------*/

		register_taxonomy( $st_category,
			array(
				$st_post
				),
			array(
				'hierarchical'		=> true,
				'label'				=> __( 'Categories', 'stkit' ),
				'singular_label'	=> __( 'Category', 'stkit' ),
				'query_var'			=> true,
				'show_ui'			=> true,
				'rewrite'			=> array( 'slug' => $slug_category )
				)
		);
	
	
		/*-------------------------------------------
			1.3 - Tag
		-------------------------------------------*/

		register_taxonomy( $st_tag,
			array(
				$st_post
				),
			array(
				'hierarchical'		=> false,
				'label'				=> __( 'Tags', 'stkit' ),
				'singular_label'	=> __( 'Tag', 'stkit' ),
				'show_tagcloud'		=> true,
				'query_var'			=> true,
				'show_ui'			=> true,
				'rewrite'			=> array( 'slug' => $slug_tag )
				)
		);


		/*-------------------------------------------
			1.4 - Format
		-------------------------------------------*/

		if ( !empty( $st_Options['ctp']['ctp-formats']['enabled'] ) ) {

			$st_format = $st_Options['ctp']['ctp-formats']['formats']['tag'];
			$slug_format = $st_Options['ctp']['ctp-formats']['formats']['slug'];
	
			register_taxonomy( $st_format,
				array(
					$st_post
					),
				array(
					'hierarchical'		=> true,
					'label'				=> __( 'Formats', 'stkit' ),
					'singular_label'	=> __( 'Format', 'stkit' ),
					'show_in_nav_menus'	=> true,
					'query_var'			=> true,
					'show_ui'			=> false,
					'rewrite'			=> array( 'slug' => $slug_format )
					)
			);


			/*--- Predefined Terms -----------------------------*/

			$st_['terms'] = array(
				'gallery'	=> __( 'Gallery', 'stkit' ),
				'audio'		=> __( 'Audio', 'stkit' ),
				'video'		=> __( 'Video', 'stkit' )
			);

			foreach ( $st_['terms'] as $slug => $term ) {

				wp_insert_term( $term, $st_format,
					array(
						'slug'		=> $slug,
						'parent'	=> 0
					)
				);

			}


		}


	}
	
	add_action( 'init', 'st_project_register' );



/*===============================================

 	C O L U M N S
	Custom order of columns

===============================================*/


	function prod_edit_columns( $columns ){

		global
			$st_Options,
			$st_Settings;

			$st_category = !empty( $st_Settings['ctp_category'] ) ? $st_Settings['ctp_category'] : $st_Options['ctp']['category'];

			$columns = array(
				'cb'			=> '<input type="checkbox" />',
				'title'			=> __( 'Title', 'stkit' ),
				'thumb'			=> __( 'Thumbnail', 'stkit' ),
				$st_category	=> __( 'Category', 'stkit' ),
				'author'		=> __( 'Author', 'stkit' ),
				'comments'		=> '<img src="images/comment-grey-bubble.png" />'
			);

		return $columns;

	}
	
	add_filter( 'manage_edit-st_project_columns', 'prod_edit_columns' );
	
	
	function prod_custom_columns($column){
	
		global
			$post,
			$st_Options,
			$st_Settings;

			$st_category = !empty( $st_Settings['ctp_category'] ) ? $st_Settings['ctp_category'] : $st_Options['ctp']['category'];

			switch ($column) {
		
				case 'thumb' :
		
					if ( has_post_thumbnail() )
						echo '<a href="' . get_edit_post_link( $post->ID ) . '">' . get_the_post_thumbnail( $post->ID, 'project-thumb' ) . '</a>';
		
				break;
		
				case $st_category :
		
						echo get_the_term_list( $post->ID, $st_category, '', ', ','' );
		
				break;
		
			}
	
	}
	
	add_action( 'manage_posts_custom_column', 'prod_custom_columns' );


?>