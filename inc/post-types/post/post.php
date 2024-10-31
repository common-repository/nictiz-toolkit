<?php

if ( ! class_exists( 'Nictiz_Toolkit_Post' ) ) {

	class Nictiz_Toolkit_Post {

		public function __construct(){				
			add_image_size( 'nictitate_posts-list-3-col-big', 556, 367, true );
			add_image_size( 'nictitate_posts-list-3-col-small', 264, 209, true );
			add_image_size( 'nictitate_posts-list-carousel', 279, 207, true );
		}

		public function require_widgets() {
			require_once 'widgets/posts-list-3-col.php';
			require_once 'widgets/posts-list-carousel.php';
			require_once 'widgets/recent-posts.php';
		}

	}

	$Nictiz_Toolkit_Post = new Nictiz_Toolkit_Post();
	$Nictiz_Toolkit_Post->require_widgets();
}

function nictiz_toolkit_get_post_widget_args() {
	
	$all_cats = get_categories();
	$categories = array( '' => esc_html__( '-- none --', 'nictiz-toolkit' ) );
	foreach ( $all_cats as $cat ) {
		$categories[ $cat->slug ] = $cat->name;
	}

	$all_tags = get_tags();
	$tags = array( '' => esc_html__( '-- none --', 'nictiz-toolkit' ) );
	foreach( $all_tags as $tag ) {
		$tags[ $tag->slug ] = $tag->name;
	}

	return array(
		'title'  => array(
			'type'  => 'text',
			'std'   => '',
			'label' => esc_html__( 'Title:', 'nictiz-toolkit' )
		),
		'categories' => array(
			'type'    => 'multiselect',
			'std'     => '',
			'label'   => esc_html__( 'Categories:', 'nictiz-toolkit' ),
			'options' => $categories,
			'size'    => '5'
		),
		'relation'    => array(
			'type'    => 'select',
			'label'   => esc_html__( 'Relation:', 'nictiz-toolkit' ),
			'std'     => 'OR',
			'options' => array(
				'AND' => esc_html__( 'AND', 'nictiz-toolkit' ),
				'OR'  => esc_html__( 'OR', 'nictiz-toolkit' )
			)
		),
		'tags' => array(
			'type'    => 'multiselect',
			'std'     => '',
			'label'   => esc_html__( 'Tags:', 'nictiz-toolkit' ),
			'options' => $tags,
			'size'    => '5'
		),
		'order' => array(
			'type'  => 'select',
			'std'   => 'DESC',
			'label' => esc_html__( 'Order:', 'nictiz-toolkit' ),
			'options' => array(
				'ASC'  => esc_html__( 'ASC', 'nictiz-toolkit' ),
				'DESC' => esc_html__( 'DESC', 'nictiz-toolkit' )
			)
		),
		'orderby' => array(
			'type'  => 'select',
			'std'   => 'date',
			'label' => esc_html__( 'Orderby:', 'nictiz-toolkit' ),
			'options' => array(
				'date'          => esc_html__( 'Date', 'nictiz-toolkit' ),
				'rand'          => esc_html__( 'Random', 'nictiz-toolkit' ),
				'comment_count' => esc_html__( 'Number of comments', 'nictiz-toolkit' )
			)
		),
		'number' => array(
			'type'    => 'number',
			'std'     => '5',
			'label'   => esc_html__( 'Number of posts:', 'nictiz-toolkit' ),
			'min'     => '1',
		)
	);
}

function nictiz_toolkit_get_post_widget_query( $instance ) {
	$query = array(
		'post_type'           => 'post',
		'posts_per_page'      => $instance['number'],
		'order'               => $instance['order'] == 'ASC' ? 'ASC' : 'DESC',
		'orderby'             => $instance['orderby'],
		'ignore_sticky_posts' => true
	);

	if ( $instance['categories'] ) {		
		if ( $instance['categories'][0] == '' )
			unset( $instance['categories'][0] );

		if ( $instance['categories'] ) {
			$query['tax_query'][] = array(
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => $instance['categories']
			);
		}
	}

	if ( $instance['tags'] ) {
		if ( $instance['tags'][0] == '' )
			unset( $instance['tags'][0] );

		if ( $instance['tags'] ) {
			$query['tax_query'][] = array(
				'taxonomy' => 'post_tag',
				'field'    => 'slug',
				'terms'    => $instance['tags']
			);
		}
	}

	if ( isset( $query['tax_query'] ) && count( $query['tax_query'] ) === 2 ) {
		$query['tax_query']['relation'] = $instance['relation'];
	}

	return apply_filters( 'nictiz_toolkit_get_post_widget_query', $query );
}