<?php

if ( !class_exists( 'Nictiz_Toolkit_Slides' ) ) {
	
	class Nictiz_Toolkit_Slides {

		public function __construct() {				
			add_action( 'init', array( $this, 'init' ), 0 );			
			add_action( 'admin_init', array( $this, 'register_metabox' ) );			
			add_filter( 'manage_slide_posts_columns', array( $this, 'manage_colums' ) );			
			add_action( 'manage_slide_posts_custom_column' , array( $this, 'manage_colum' ) );
		}

		public function init() {

			$labels = array(
				'name'               => esc_html__( 'Slides', 'nictiz-toolkit' ),
				'singular_name'      => esc_html__( 'Slide', 'nictiz-toolkit' ),
				'menu_name'          => esc_html__( 'Slides', 'nictiz-toolkit' ),
				'name_admin_bar'     => esc_html__( 'Slide', 'nictiz-toolkit' ),
				'add_new'            => esc_html__( 'Add New', 'nictiz-toolkit' ),
				'add_new_item'       => esc_html__( 'Add New Slide', 'nictiz-toolkit' ),
				'new_item'           => esc_html__( 'New Slide', 'nictiz-toolkit' ),
				'edit_item'          => esc_html__( 'Edit Slide', 'nictiz-toolkit' ),
				'view_item'          => esc_html__( 'View Slide', 'nictiz-toolkit' ),
				'all_items'          => esc_html__( 'All Slides', 'nictiz-toolkit' ),
				'search_items'       => esc_html__( 'Search Slides', 'nictiz-toolkit' ),
				'parent_item_colon'  => esc_html__( 'Parent Slides:', 'nictiz-toolkit' ),
				'not_found'          => esc_html__( 'No slides found.', 'nictiz-toolkit' ),
				'not_found_in_trash' => esc_html__( 'No slides found in Trash.', 'nictiz-toolkit' )
			);

			$args = array(
				'menu_icon'          => 'dashicons-slides',
				'public'             => true,	      
				'labels'             => $labels,
				'supports'           => array( 'title', 'thumbnail', 'editor' ),
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'show_in_nav_menus'  => false,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => 'slide' ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => 100
		    );

		    register_post_type( 'slide', $args );

		    $labels = array(
				'name'              => esc_html__( 'Slide Tags', 'nictiz-toolkit' ),
				'singular_name'     => esc_html__( 'Tag', 'nictiz-toolkit' ),
				'search_items'      => esc_html__( 'Search Tags', 'nictiz-toolkit' ),
				'all_items'         => esc_html__( 'All Tags', 'nictiz-toolkit' ),
				'parent_item'       => esc_html__( 'Parent Tag', 'nictiz-toolkit' ),
				'parent_item_colon' => esc_html__( 'Parent Tag:', 'nictiz-toolkit' ),
				'edit_item'         => esc_html__( 'Edit Tag', 'nictiz-toolkit' ),
				'update_item'       => esc_html__( 'Update Tag', 'nictiz-toolkit' ),
				'add_new_item'      => esc_html__( 'Add New Tag', 'nictiz-toolkit' ),
				'new_item_name'     => esc_html__( 'New Tag Name', 'nictiz-toolkit' ),
				'menu_name'         => esc_html__( 'Tag', 'nictiz-toolkit' )
			);

			$args = array(
				'hierarchical'      => false,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_in_nav_menus' => false,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'slide-tag' )
			);

			register_taxonomy( 'slide-tag', array( 'slide' ), $args );
		}

		public function register_metabox() {

			$args = array(
				'id'          => 'nictiz-toolkit-slide-custom-metabox',
			    'title'       => esc_html__( 'Slide Extra', 'nictiz-toolkit' ),
			    'desc'        => '',
			    'pages'       => array( 'slide' ),
			    'context'     => 'normal',
			    'priority'    => 'high',
			    'fields'      => array(
			    	array(
						'title'   => esc_html__( 'Button Text', 'nictiz-toolkit' ),
						'type'    => 'text',
						'default' => '',
						'id'      => 'slider_button_text'
					),
					array(
						'title'   => esc_html__( 'Button URL', 'nictiz-toolkit' ),
						'type'    => 'url',
						'default' => '',
						'id'      => 'slider_button_url'
					),

			    )
			);			
			
			kopa_register_metabox( $args );
		}

		public function manage_colums( $columns ) {			
			$columns = array(
				'cb'                              => esc_html__( '<input type="checkbox" />', 'nictiz-toolkit' ),
				'nictiz-toolkit-thumb' => esc_html__( 'Slide', 'nictiz-toolkit' ),
				'title'                           => esc_html__( 'Title', 'nictiz-toolkit' ),
				'taxonomy-slide-tag'              => esc_html__( 'Tags', 'nictiz-toolkit' )
				
			);

			return $columns;	
		}

		public function manage_colum( $column ) {
			global $post;
			switch ( $column ) {
				case 'nictiz-toolkit-thumb':
					if ( has_post_thumbnail( $post->ID ) ) {
						printf('<img src="%s" width="40px" height="40px">', divine_post_bfi_thumb($post->ID, '', 40, 40, true));
					}					
					break;
								
			}
		}

		public function require_widgets() {
			require_once NICTIZ_TOOLKIT_PATH . 'inc/post-types/slides/widgets/slider-carousel.php';
			require_once NICTIZ_TOOLKIT_PATH . 'inc/post-types/slides/widgets/slider-carousel-full.php';
		}
	}

	$Nictiz_Toolkit_Slides = new Nictiz_Toolkit_Slides();
	$Nictiz_Toolkit_Slides->require_widgets();
}