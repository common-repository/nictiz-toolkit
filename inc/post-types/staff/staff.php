<?php

if ( ! class_exists( 'Nictiz_Toolkit_Staff' ) ) {

	class Nictiz_Toolkit_Staff {

		public function __construct() {				
			add_action( 'init', array( $this, 'init' ), 0 );			
			add_action( 'admin_init', array( $this, 'register_metabox' ) );			
			add_filter( 'manage_staffs_posts_columns', array( $this, 'manage_colums' ) );
		}

		public function require_widgets() {
			require_once NICTIZ_TOOLKIT_PATH . 'inc/post-types/staff/widgets/staff-list.php';
		}

		public function init() {

			#POSTTYPE
			$labels = array(
				'name'               => esc_html__( 'Staffs', 'nictiz-toolkit' ),
				'singular_name'      => esc_html__( 'Staff', 'nictiz-toolkit' ),
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
				'menu_name'          => esc_html__( 'Staffs', 'nictiz-toolkit' )
		    );

		    $args = array(
				'menu_icon'            => 'dashicons-groups',
				'labels'               => $labels,
				'public'               => false,
				'publicly_queryable'   => true,
				'show_ui'              => true,
				'show_in_menu'         => true,
				'query_var'            => true,
				'rewrite'              => array( 'slug' => 'staffs' ),
				'capability_type'      => 'post',
				'has_archive'          => true,
				'hierarchical'         => false,
				'exclude_from_search'  => true,
				'menu_position'        => 100,
				'supports'             => array( 'title', 'thumbnail', 'editor', 'excerpt' ),
				'can_export'           => true,
				'register_meta_box_cb' => ''
		    );

		    register_post_type( 'staffs', $args );

		    $taxonomy_category_args = array(
				'public'       => true,
				'hierarchical' => true,
				'labels'       => array(
					'name'                       => esc_html__( 'Staff Categories', 'nictiz-toolkit' ),
					'singular_name'              => esc_html__( 'Category', 'nictiz-toolkit' ),
					'search_items'               => esc_html__( 'Search Category', 'nictiz-toolkit' ),
					'popular_items'              => esc_html__( 'Popular Staffs', 'nictiz-toolkit' ),
					'all_items'                  => esc_html__( 'All Staffs', 'nictiz-toolkit' ),
					'parent_item'                => null,
					'parent_item_colon'          => null,
					'edit_item'                  => esc_html__( 'Edit Staff', 'nictiz-toolkit' ),
					'update_item'                => esc_html__( 'Update Staff', 'nictiz-toolkit' ),
					'add_new_item'               => esc_html__( 'Add New Staff', 'nictiz-toolkit' ),
					'new_item_name'              => esc_html__( 'New Staff Name', 'nictiz-toolkit' ),
					'separate_items_with_commas' => esc_html__( 'Separate categories with commas', 'nictiz-toolkit' ),
					'add_or_remove_items'        => esc_html__( 'Add or remove category', 'nictiz-toolkit' ),
					'choose_from_most_used'      => esc_html__( 'Choose from the most used categories', 'nictiz-toolkit' ),
					'menu_name'                  => esc_html__( 'Staff Categories', 'nictiz-toolkit' )
		        ),
				'show_ui'               => true,
				'show_admin_column'     => true,
				'update_count_callback' => '',
				'query_var'             => true,
				'show_in_nav_menus'     => false,
				'show_tagcloud'         => true,
				'rewrite'               => array( 'slug' => 'staff_category' )
		    );

		    register_taxonomy( 'staff_category', 'staffs', $taxonomy_category_args );

		    #TAXONOMY TAG
		    $taxonomy_tag_args = array(
				'public'       => true,
				'hierarchical' => false,
				'labels'       => array(
					'name'                       => esc_html__( 'Staff Tags', 'nictiz-toolkit' ),
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
					'menu_name'                  => esc_html__( 'Staff Tags', 'nictiz-toolkit' )
		        ),
				'show_ui'               => true,
				'show_admin_column'     => true,
				'update_count_callback' => '',
				'query_var'             => true,
				'show_in_nav_menus'     => false,
				'show_tagcloud'         => true,
				'rewrite'               => array( 'slug' => 'staff_tag' )
		    );

		    register_taxonomy( 'staff_tag', 'staffs', $taxonomy_tag_args );

		    flush_rewrite_rules( false );    
		}

		public function register_metabox() {

			$staff_social = nictiz_toolkit_staff_social_link();

			$staff_metabox_fields = array(
					array(
						'title'   => esc_html__( 'Position:', 'nictiz-toolkit' ),
						'type'    => 'text',
						'default' => '',
						'id'      => 'position'			
					),
					array(
						'title'   => esc_html__( 'Email:', 'nictiz-toolkit' ),
						'type'    => 'email',
						'default' => '',
						'id'      => 'email'				
					)
				);
			foreach ( $staff_social as $key=> $value ) {
				
				$staff_metabox_fields[] = array(
					'title'   => $value['name'],
					'type'    => 'url',
					'default' => '',
					'id'      => $key
				);
			}

			$args = array(
				'id'          => 'nictiz-toolkit-staff-edit',
			    'title'       => esc_html__( 'Staff Social Meta Box', 'nictiz-toolkit' ),
			    'desc'        => '',
			    'pages'       => array( 'staffs' ),
			    'context'     => 'normal',
			    'priority'    => 'high',
			    'fields'      => $staff_metabox_fields
			);			
			
			kopa_register_metabox( $args );
		}

		public function manage_colums( $columns ) {			
			$columns = array(
				'cb'                      => esc_html__( '<input type="checkbox" />', 'nictiz-toolkit' ),
				'title'                   => esc_html__( 'Title', 'nictiz-toolkit' ),
				'taxonomy-staff_category' => esc_html__( 'Staff Categories', 'nictiz-toolkit' ),
				'taxonomy-staff_tag'      => esc_html__( 'Staff Tags', 'nictiz-toolkit' ),
				'date'                    => esc_html__( 'Date', 'nictiz-toolkit' )
			);

			return $columns;	
		}

		

	}

	$Nictiz_Toolkit_Staff = new Nictiz_Toolkit_Staff();
	$Nictiz_Toolkit_Staff->require_widgets();	

	function nictiz_toolkit_staff_social_link(){

		$social_link = apply_filters( 'nictitate_nictiz_toolkit_staff_social_link', array(
			'facebook' => array( 'name' => esc_html__( 'Facebook', 'nictiz-toolkit' ), 'icon' => 'fa fa-facebook' ), 
			'twitter'  => array( 'name' => esc_html__( 'Twitter', 'nictiz-toolkit' ), 'icon' => 'fa fa-twitter' ), 
			'gplus'    => array( 'name' => esc_html__( 'Google Plus', 'nictiz-toolkit' ), 'icon' => 'fa fa-google-plus' )
			)
		);

		return $social_link;
	}
}