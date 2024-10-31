<?php

if ( ! class_exists( 'Nictiz_Toolkit_Client' ) ) {

	class Nictiz_Toolkit_Client {

		public function __construct() {				
			add_action( 'init', array( $this, 'init' ), 0 );			
			add_action( 'admin_init', array( $this, 'register_metabox' ) );
			add_filter( 'manage_clients_posts_columns', array( $this, 'manage_colums' ) );
		}

		public function require_widgets() {
			require_once 'widgets/clients.php';
		}

		public function init() {

			#POSTTYPE
			$labels = array(
				'name'               => esc_html__( 'Clients', 'nictiz-toolkit' ),
				'singular_name'      => esc_html__( 'Client', 'nictiz-toolkit' ),
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
				'menu_name'          => esc_html__( 'Clients', 'nictiz-toolkit' )
		    );

		    $args = array(
				'menu_icon'            => 'dashicons-networking',
				'labels'               => $labels,
				'public'               => false,
				'publicly_queryable'   => true,
				'show_ui'              => true,
				'show_in_menu'         => true,
				'query_var'            => true,
				'rewrite'              => array( 'slug' => 'clients' ),
				'capability_type'      => 'post',
				'has_archive'          => true,
				'hierarchical'         => false,
				'exclude_from_search'  => true,
				'menu_position'        => 100,
				'supports'             => array( 'title', 'thumbnail' ),
				'can_export'           => true,
				'register_meta_box_cb' => ''
		    );

		    register_post_type( 'clients', $args );

		    $taxonomy_category_args = array(
				'public'       => true,
				'hierarchical' => true,
				'labels'       => array(
					'name'                       => esc_html__( 'Client Categories', 'taxonomy general name', 'nictiz-toolkit' ),
					'singular_name'              => esc_html__( 'Category', 'taxonomy singular name', 'nictiz-toolkit' ),
					'search_items'               => esc_html__( 'Search Category', 'nictiz-toolkit' ),
					'popular_items'              => esc_html__( 'Popular Clients', 'nictiz-toolkit' ),
					'all_items'                  => esc_html__( 'All Clients', 'nictiz-toolkit' ),
					'parent_item'                => null,
					'parent_item_colon'          => null,
					'edit_item'                  => esc_html__( 'Edit Client', 'nictiz-toolkit' ),
					'update_item'                => esc_html__( 'Update Client', 'nictiz-toolkit' ),
					'add_new_item'               => esc_html__( 'Add New Client', 'nictiz-toolkit' ),
					'new_item_name'              => esc_html__( 'New Client Name', 'nictiz-toolkit' ),
					'separate_items_with_commas' => esc_html__( 'Separate categories with commas', 'nictiz-toolkit' ),
					'add_or_remove_items'        => esc_html__( 'Add or remove category', 'nictiz-toolkit' ),
					'choose_from_most_used'      => esc_html__( 'Choose from the most used categories', 'nictiz-toolkit' ),
					'menu_name'                  => esc_html__( 'Client Categories', 'nictiz-toolkit' )
		        ),
				'show_ui'               => true,
				'show_admin_column'     => true,
				'update_count_callback' => '',
				'query_var'             => true,
				'show_in_nav_menus'     => false,
				'show_tagcloud'         => true,
				'rewrite'               => array( 'slug' => 'client_category' )
		    );

		    register_taxonomy( 'client_category', 'clients', $taxonomy_category_args );

		    #TAXONOMY TAG
		    $taxonomy_tag_args = array(
				'public'       => true,
				'hierarchical' => false,
				'labels'       => array(
					'name'                       => esc_html__( 'Client Tags', 'taxonomy general name', 'nictiz-toolkit' ),
					'singular_name'              => esc_html__( 'Tag', 'taxonomy singular name', 'nictiz-toolkit' ),
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
					'menu_name'                  => esc_html__( 'Client Tags', 'nictiz-toolkit' )
		        ),
				'show_ui'               => true,
				'show_admin_column'     => true,
				'update_count_callback' => '',
				'query_var'             => true,
				'show_in_nav_menus'     => false,
				'show_tagcloud'         => true,
				'rewrite'               => array( 'slug' => 'client_tag' )
		    );

		    register_taxonomy( 'client_tag', 'clients', $taxonomy_tag_args );

		    flush_rewrite_rules( false );   
		}

		public function register_metabox() {

			$args = array(
				'id'          => 'nictiz-toolkit-client-edit',
			    'title'       => esc_html__( 'Meta box', 'nictiz-toolkit' ),
			    'desc'        => '',
			    'pages'       => array( 'clients' ),
			    'context'     => 'normal',
			    'priority'    => 'high',
			    'fields'      => array(
			    	array(
						'title'   => esc_html__( 'Client URL:', 'nictiz-toolkit' ),
						'type'    => 'url',
						'default' => '',
						'id'      => 'client_url'
					)
			    )
			);			
			
			kopa_register_metabox( $args );
		}

		public function manage_colums( $columns ) {			
			$columns = array(
				'cb'                       => esc_html__( '<input type="checkbox" />', 'nictiz-toolkit' ),
				'title'                    => esc_html__( 'Title', 'nictiz-toolkit' ),
				'taxonomy-client_category' => esc_html__( 'Client Categories', 'nictiz-toolkit' ),
				'taxonomy-client_tag'      => esc_html__( 'Client Tags', 'nictiz-toolkit' ),
				'date'                     => esc_html__( 'Date', 'nictiz-toolkit' )
			);

			return $columns;	
		}

	}

	$Nictiz_Toolkit_Client = new Nictiz_Toolkit_Client();
	$Nictiz_Toolkit_Client->require_widgets();
	
}