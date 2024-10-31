<?php

if ( ! class_exists( 'Nictiz_Toolkit_Skill' ) ) {

	class Nictiz_Toolkit_Skill {

		public function __construct() {				
			add_action( 'init', array( $this, 'init' ), 0 );			
			add_action( 'admin_init', array( $this, 'register_metabox' ) );			
			add_filter( 'manage_slide_posts_columns', array( $this, 'manage_colums' ) );			
			add_action( 'manage_slide_posts_custom_column' , array( $this, 'manage_colum' ) );
		}

		public function init() {

			$labels = array(
				'name'               => esc_html__( 'Skills', 'nictiz-toolkit' ),
				'singular_name'      => esc_html__( 'Skill', 'nictiz-toolkit' ),
				'menu_name'          => esc_html__( 'Skills', 'nictiz-toolkit' ),
				'name_admin_bar'     => esc_html__( 'Skill', 'nictiz-toolkit' ),
				'add_new'            => esc_html__( 'Add New', 'nictiz-toolkit' ),
				'add_new_item'       => esc_html__( 'Add New Skill', 'nictiz-toolkit' ),
				'new_item'           => esc_html__( 'New Skill', 'nictiz-toolkit' ),
				'edit_item'          => esc_html__( 'Edit Skill', 'nictiz-toolkit' ),
				'view_item'          => esc_html__( 'View Skill', 'nictiz-toolkit' ),
				'all_items'          => esc_html__( 'All Skills', 'nictiz-toolkit' ),
				'search_items'       => esc_html__( 'Search Skills', 'nictiz-toolkit' ),
				'parent_item_colon'  => esc_html__( 'Parent Skills:', 'nictiz-toolkit' ),
				'not_found'          => esc_html__( 'No Skills found.', 'nictiz-toolkit' ),
				'not_found_in_trash' => esc_html__( 'No Skills found in Trash.', 'nictiz-toolkit' )
			);

			$args = array(
				'menu_icon'          => 'dashicons-star-empty',
				'public'             => true,
				'labels'             => $labels,
				'supports'           => array( 'title' ),
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'show_in_nav_menus'  => false,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => 'skill' ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => 107
			);

			register_post_type( 'skill', $args );

			$labels = array(
				'name'              => esc_html__( 'Skill Tags', 'nictiz-toolkit' ),
				'singular_name'     => esc_html__( 'Tag', 'nictiz-toolkit' ),
				'search_items'      => esc_html__( 'Search Tags', 'nictiz-toolkit' ),
				'all_items'         => esc_html__( 'All Tags', 'nictiz-toolkit' ),
				'parent_item'       => esc_html__( 'Parent Tag', 'nictiz-toolkit' ),
				'parent_item_colon' => esc_html__( 'Parent Tag:', 'nictiz-toolkit' ),
				'edit_item'         => esc_html__( 'Edit Tag', 'nictiz-toolkit' ),
				'update_item'       => esc_html__( 'Update Tag', 'nictiz-toolkit' ),
				'add_new_item'      => esc_html__( 'Add New Tag', 'nictiz-toolkit' ),
				'new_item_name'     => esc_html__( 'New Tag Name', 'nictiz-toolkit' ),
				'menu_name'         => esc_html__( 'Tags', 'nictiz-toolkit' )
			);

			$args = array(
				'hierarchical'      => false,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_in_nav_menus' => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'skill-tag' )
			);

			register_taxonomy( 'skill-tag', array( 'skill' ), $args );
		}

		public function register_metabox() {
			$nictiz_toolkit_skill_fields = array(
				array(
					'title'   => esc_html__( 'Progress', 'nictiz-toolkit' ),
					'type'    => 'text',
					'id'      => 'nictitate-toolkit-skill-progress'
				),
			);
			$nictiz_toolkit_skill_fields = apply_filters( 'nictiz_toolkit_skill_fields', $nictiz_toolkit_skill_fields );

			$args = array(
				'id'          => 'nictiz-toolkit-skill-metabox',
				'title'       => esc_html__( 'Other info', 'nictiz-toolkit' ),
				'desc'        => '',
				'pages'       => array( 'skill' ),
				'context'     => 'normal',
				'priority'    => 'low',
				'fields'      => $nictiz_toolkit_skill_fields
			);

			kopa_register_metabox( $args );
		}

		public function manage_colums( $columns ) {			
			$columns = array(
				'cb'                                 => esc_html__( '<input type="checkbox" />', 'nictiz-toolkit' ),
				'title'                              => esc_html__( 'Title', 'nictiz-toolkit' ),
				'nictiz-toolkit-progress' => esc_html__( 'Progress', 'nictiz-toolkit' ),
				'taxonomy-skill-tag'                 => esc_html__( 'Tags', 'nictiz-toolkit' )
			);

			return $columns;	
		}

		public function manage_colum( $column ) {
			global $post;
			switch ( $column ) {
				case 'nictiz-toolkit-progress':
					echo get_post_meta( $post->ID, 'nictitate-toolkit-skill-progress', true );
					break;
			}
		}

		public function require_widgets() {
			require_once NICTIZ_TOOLKIT_PATH . 'inc/post-types/skill/widgets/skill-counter.php';
		}
	}

	$Nictiz_Toolkit_Skill = new Nictiz_Toolkit_Skill();
	$Nictiz_Toolkit_Skill->require_widgets();
}