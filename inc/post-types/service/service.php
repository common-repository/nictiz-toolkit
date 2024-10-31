<?php

if( ! class_exists( 'Nictiz_Toolkit_Service' ) ) {

	class Nictiz_Toolkit_Service {

		public function __construct() {				
			add_action( 'init', array( $this, 'init' ), 0 );			
			add_action( 'admin_init', array( $this, 'register_metabox' ) );			
			add_filter( 'manage_services_posts_columns', array( $this, 'manage_colums' ) );
		}		

		public function require_widgets() {
			require_once 'widgets/services.php';
			require_once 'widgets/services-as-tab.php';
		}

		public function init(){

			#POSTTYPE
			$labels = array(
				'name'               => esc_html__( 'Services', 'nictiz-toolkit' ),
				'singular_name'      => esc_html__( 'Service', 'nictiz-toolkit' ),
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
				'menu_name'          => esc_html__( 'Services', 'nictiz-toolkit' )
		    );

		    $args = array(
				'menu_icon'            => 'dashicons-awards',
				'labels'               => $labels,
				'public'               => false,
				'publicly_queryable'   => true,
				'show_ui'              => true,
				'show_in_menu'         => true,
				'query_var'            => true,
				'rewrite'              => array( 'slug' => 'services' ),
				'capability_type'      => 'post',
				'has_archive'          => true,
				'hierarchical'         => false,
				'exclude_from_search'  => true,
				'menu_position'        => 100,
				'supports'             => array( 'title', 'thumbnail', 'excerpt', 'editor' ),
				'can_export'           => true,
				'register_meta_box_cb' => ''
		    );

		    register_post_type( 'services', $args );

		    #TAXONOMY CATEGORY
		    $taxonomy_category_args = array(
				'public'       => true,
				'hierarchical' => true,
				'labels'       => array(
					'name'                       => esc_html__( 'Service Categories', 'taxonomy general name', 'nictiz-toolkit' ),
					'singular_name'              => esc_html__( 'Category', 'taxonomy singular name', 'nictiz-toolkit' ),
					'search_items'               => esc_html__( 'Search Category', 'nictiz-toolkit' ),
					'popular_items'              => esc_html__( 'Popular Services', 'nictiz-toolkit' ),
					'all_items'                  => esc_html__( 'All Services', 'nictiz-toolkit' ),
					'parent_item'                => null,
					'parent_item_colon'          => null,
					'edit_item'                  => esc_html__( 'Edit Service', 'nictiz-toolkit' ),
					'update_item'                => esc_html__( 'Update Service', 'nictiz-toolkit' ),
					'add_new_item'               => esc_html__( 'Add New Service', 'nictiz-toolkit' ),
					'new_item_name'              => esc_html__( 'New Service Name', 'nictiz-toolkit' ),
					'separate_items_with_commas' => esc_html__( 'Separate categories with commas', 'nictiz-toolkit' ),
					'add_or_remove_items'        => esc_html__( 'Add or remove category', 'nictiz-toolkit' ),
					'choose_from_most_used'      => esc_html__( 'Choose from the most used categories', 'nictiz-toolkit' ),
					'menu_name'                  => esc_html__( 'Service Categories', 'nictiz-toolkit' )
		        ),
				'show_ui'               => true,
				'show_admin_column'     => true,
				'update_count_callback' => '',
				'query_var'             => true,
				'show_in_nav_menus'     => false,
				'show_tagcloud'         => true,
				'rewrite'               => array( 'slug' => 'service_category' )
		    );

		    register_taxonomy( 'service_category', 'services', $taxonomy_category_args );

		    #TAXONOMY TAG
		    $taxonomy_tag_args = array(
				'public'       => true,
				'hierarchical' => false,
				'labels'       => array(
					'name'                       => esc_html__( 'Service Tags', 'nictiz-toolkit' ),
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
					'menu_name'                  => esc_html__( 'Service Tags', 'nictiz-toolkit' )
		        ),
				'show_ui'               => true,
				'show_admin_column'     => true,
				'update_count_callback' => '',
				'query_var'             => true,
				'show_in_nav_menus'     => false,
				'show_tagcloud'         => true,
				'rewrite'               => array( 'slug' => 'service_tag' )
		    );

		    register_taxonomy( 'service_tag', 'services', $taxonomy_tag_args );

		    flush_rewrite_rules( false );
		}

		public function register_metabox() {

            for ( $i = 1; $i <= 100; $i++ ) {
	        	$percent[] = $i.' %';
            }

            $pages_arr = array( '0' => esc_html__( '&mdash; Select &mdash;', 'nictiz-toolkit' ) );
            $pages = get_pages();

            foreach ( $pages as $page ) {
            	$pages_arr[ $page->ID ] = $page->post_title;
            }

			$args = array(
				'id'          => 'nictiz-toolkit-service-edit',
			    'title'       => esc_html__( 'Meta box', 'nictiz-toolkit' ),
			    'desc'        => '',
			    'pages'       => array( 'services' ),
			    'context'     => 'normal',
			    'priority'    => 'high',
			    'fields'      => array(
			    	array(
						'title'   => esc_html__( 'Choose icon:', 'nictiz-toolkit' ),
						'type'    => 'icon_picker',
						'default' => 'fa fa-car',
						'id'      => 'icon_class'				
					),
			    	array(
						'title'   => esc_html__( 'Link to external page:', 'nictiz-toolkit' ),
						'type'    => 'url',
						'default' => '',
						'desc'    => esc_html__( 'Leave it blank if you want to use static page option below.', 'nictiz-toolkit' ),
						'id'      => 'service_external_page'					
					),
					array(
						'title'   => esc_html__( 'Link to static page:', 'nictiz-toolkit' ),
						'type'    => 'select',
						'default' => '',
						'options' => $pages_arr,
						'id'      => 'service_static_page'			
					),
					array(
						'title'   => esc_html__( 'Service Expertise:', 'nictiz-toolkit' ),
						'type'    => 'select',
						'default' => '',
						'options' => $percent,
						'id'      => 'service_percentage'			
					),
			    )
			);			
			
			kopa_register_metabox( $args );
		}

		public function manage_colums( $columns ) {			
			$columns = array(
				'cb'                        => esc_html__( '<input type="checkbox" />', 'nictiz-toolkit' ),
				'title'                     => esc_html__( 'Title', 'nictiz-toolkit' ),
				'taxonomy-service_category' => esc_html__( 'Services Categories', 'nictiz-toolkit' ),
				'taxonomy-service_tag'      => esc_html__( 'Services Tags', 'nictiz-toolkit' ),
				'date'                      => esc_html__( 'Date', 'nictiz-toolkit' )
			);

			return $columns;	
		}

	}

	$Nictiz_Toolkit_Service = new Nictiz_Toolkit_Service();
	$Nictiz_Toolkit_Service->require_widgets();	
}