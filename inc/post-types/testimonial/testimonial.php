<?php

if ( ! class_exists( 'Nictiz_Toolkit_Testimonial' ) ) {

	class Nictiz_Toolkit_Testimonial {

		public function __construct() {				
			add_action( 'init', array( $this, 'init' ), 0 );			
			add_action( 'admin_init', array( $this, 'register_metabox' ) );			
			add_filter( 'manage_testimonials_posts_columns', array( $this, 'manage_colums' ) );
		}

		public function require_widgets() {
			require_once 'widgets/testimonials-slider.php';
			require_once 'widgets/testimonials-slider-bg.php';
		}

		public function init() {

			#POSTTYPE
			$labels = array(
				'name'               => esc_html__( 'Testimonials', 'nictiz-toolkit' ),
				'singular_name'      => esc_html__( 'Testimonial', 'nictiz-toolkit' ),
				'add_new'            => esc_html__( 'Add New', 'nictiz-toolkit' ),
				'add_new_item'       => esc_html__( 'Add New Item', 'nictiz-toolkit' ),
				'edit_item'          => esc_html__( 'Edit Item', 'nictiz-toolkit' ),
				'new_item'           => esc_html__( 'New Item', 'nictiz-toolkit' ),
				'all_items'          => esc_html__( 'All Items', 'nictiz-toolkit' ),
				'view_item'          => esc_html__( 'View Item', 'nictiz-toolkit' ),
				'search_items'       => esc_html__( 'Search Items', 'nictiz-toolkit' ),
				'not_found'          => esc_html__( 'No items found', 'nictiz-toolkit' ),
				'not_found_in_trash' => esc_html__( 'No items found in Trash', 'nictiz-toolkit' ),
				'parent_item_colon'  => '',
				'menu_name'          => esc_html__( 'Testimonials', 'nictiz-toolkit' )
		    );

		    $args = array(
				'menu_icon'            => 'dashicons-format-status',
				'labels'               => $labels,
				'public'               => false,
				'publicly_queryable'   => true,
				'show_ui'              => true,
				'show_in_menu'         => true,
				'query_var'            => true,
				'rewrite'              => array( 'slug' => 'testimonials' ),
				'capability_type'      => 'post',
				'has_archive'          => true,
				'hierarchical'         => false,
				'exclude_from_search'  => true,
				'menu_position'        => 100,
				'supports'             => array( 'title', 'thumbnail', 'editor', 'excerpt' ),
				'can_export'           => true,
				'register_meta_box_cb' => ''
		    );

		    register_post_type( 'testimonials', $args );

		    #TAXONOMY CATEGORY
		    $taxonomy_category_args = array(
				'public'       => true,
				'hierarchical' => true,
				'labels'       => array(
					'name'                       => esc_html__( 'Testimonial Categories', 'nictiz-toolkit' ),
					'singular_name'              => esc_html__( 'Category', 'nictiz-toolkit' ),
					'search_items'               => esc_html__( 'Search Category', 'nictiz-toolkit' ),
					'popular_items'              => esc_html__( 'Popular Testimonials', 'nictiz-toolkit' ),
					'all_items'                  => esc_html__( 'All Testimonials', 'nictiz-toolkit' ),
					'parent_item'                => null,
					'parent_item_colon'          => null,
					'edit_item'                  => esc_html__( 'Edit Testimonial', 'nictiz-toolkit' ),
					'update_item'                => esc_html__( 'Update Testimonial', 'nictiz-toolkit' ),
					'add_new_item'               => esc_html__( 'Add New Testimonial', 'nictiz-toolkit' ),
					'new_item_name'              => esc_html__( 'New Testimonial Name', 'nictiz-toolkit' ),
					'separate_items_with_commas' => esc_html__( 'Separate categories with commas', 'nictiz-toolkit' ),
					'add_or_remove_items'        => esc_html__( 'Add or remove category', 'nictiz-toolkit' ),
					'choose_from_most_used'      => esc_html__( 'Choose from the most used categories', 'nictiz-toolkit' ),
					'menu_name'                  => esc_html__( 'Testimonial Categories', 'nictiz-toolkit' )
		        ),
				'show_ui'               => true,
				'show_admin_column'     => true,
				'update_count_callback' => '',
				'query_var'             => true,
				'show_in_nav_menus'     => false,
				'show_tagcloud'         => true,
				'rewrite'               => array( 'slug' => 'testimonial_category' )
		    );

		    register_taxonomy( 'testimonial_category', 'testimonials', $taxonomy_category_args );

		    #TAXONOMY TAG
		    $taxonomy_tag_args = array(
				'public'       => true,
				'hierarchical' => false,
				'labels'       => array(
					'name'                       => esc_html__( 'Testimonial Tags', 'nictiz-toolkit' ),
					'singular_name'              => esc_html__( 'Tag', 'nictiz-toolkit' ),
					'search_items'               => esc_html__( 'Search Tag', 'nictiz-toolkit' ),
					'popular_items'              => esc_html__( 'Popular Tags', 'nictiz-toolkit' ),
					'all_items'                  => esc_html__( 'All Tags', 'nictiz-toolkit' ),
					'parent_item'                => null,
					'parent_item_colon'          => null,
					'edit_item'                  => esc_html__( 'Edit Tag', 'nictiz-toolkit' ),
					'update_item'                => esc_html__( 'Update Tag', 'nictiz-toolkit' ),
					'add_new_item'               => esc_html__( 'Add New Tag', 'nictiz-toolkit' ),
					'new_item_name'              => esc_html__( 'New Tag Name', 'nictiz-toolkit' ),
					'separate_items_with_commas' => esc_html__( 'Separate tags with commas', 'nictiz-toolkit' ),
					'add_or_remove_items'        => esc_html__( 'Add or remove tag', 'nictiz-toolkit' ),
					'choose_from_most_used'      => esc_html__( 'Choose from the most used tags', 'nictiz-toolkit' ),
					'menu_name'                  => esc_html__( 'Testimonial Tags', 'nictiz-toolkit' )
		        ),
				'show_ui'               => true,
				'show_admin_column'     => true,
				'update_count_callback' => '',
				'query_var'             => true,
				'show_in_nav_menus'     => false,
				'show_tagcloud'         => true,
				'rewrite'               => array( 'slug' => 'testimonial_tag' )
		    );

		    register_taxonomy( 'testimonial_tag', 'testimonials', $taxonomy_tag_args );

		    flush_rewrite_rules( false );   
		}

		public function register_metabox() {

			$args = array(
				'id'          => 'nictiz-toolkit-testimonial-edit',
			    'title'       => esc_html__( 'Meta box', 'nictiz-toolkit' ),
			    'desc'        => '',
			    'pages'       => array( 'testimonials' ),
			    'context'     => 'normal',
			    'priority'    => 'high',
			    'fields'      => array(
			    	array(
						'title'   => esc_html__( 'Author URL:', 'nictiz-toolkit' ),
						'type'    => 'url',
						'default' => '',
						'id'      => 'author_url',					
					),
			    )
			);			
			
			kopa_register_metabox( $args );
		}

		public function manage_colums( $columns ) {			
			$columns = array(
				'cb'                            => esc_html__(' <input type="checkbox" />', 'nictiz-toolkit' ),
				'title'                         => esc_html__(' Title', 'nictiz-toolkit' ),
				'taxonomy-testimonial_category' => esc_html__(' Services Categories', 'nictiz-toolkit' ),
				'taxonomy-testimonial_tag'      => esc_html__(' Services Tags', 'nictiz-toolkit' ),
				'date'                          => esc_html__(' Date', 'nictiz-toolkit' )
			);

			return $columns;	
		}

	}

	$Nictiz_Toolkit_Testimonial = new Nictiz_Toolkit_Testimonial();
	$Nictiz_Toolkit_Testimonial->require_widgets();	
}