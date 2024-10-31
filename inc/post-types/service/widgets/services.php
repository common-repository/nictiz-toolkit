<?php

add_action( 'kpb_get_widgets_list', array( 'Nictiz_Toolkit_Widget_Services', 'register_block' ) );
	
class Nictiz_Toolkit_Widget_Services extends Kopa_Widget {

	public $kpb_group = 'service';
	
	public static function register_block( $blocks ) {
       	$blocks['Nictiz_Toolkit_Widget_Services'] = new Nictiz_Toolkit_Widget_Services();
        return $blocks;
    }
    
	public function __construct() {
		$cat_arr    = array();
		$tag_arr    = array();
		$categories = get_terms( 'service_category' );
		$tags       = get_terms( 'service_tag' );
		if ( $categories && !is_wp_error( $categories ) ) {
	        foreach ( $categories as $category ) {
	        	$cat_arr[ $category->term_id ] = $category->name.'('.$category->count.')';
	        }
	    }
        if ( $tags && !is_wp_error( $tags ) ) {
	        foreach ( $tags as $tag ) {
	        	$tag_arr[ $tag->term_id ] = $tag->name.'('.$tag->count.')';
	        }
	    }
		$this->widget_cssclass    = 'k-widget-portfolio-icon has-header has-icon-header';
		$this->widget_description = esc_html__( 'This widget displays the list of services.', 'nictiz-toolkit' );
		$this->widget_id          = 'nictitate-toolkit-ii-widget-services';
		$this->widget_name        = esc_html__( '__Services', 'nictiz-toolkit' );
		$this->settings 		  = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => '',
				'label' => esc_html__( 'Title:', 'nictiz-toolkit' )
			),
			'categories' => array(
				'type'    => 'multiselect',
				'std'     => '',
				'label'   => esc_html__( 'Categories:', 'nictiz-toolkit' ),
				'options' => $cat_arr,
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
				'options' => $tag_arr,
				'size'    => '5'
			),
			'orderby' => array(
				'type'  => 'select',
				'std'   => 'date',
				'label' => esc_html__( 'Orderby:', 'nictiz-toolkit' ),
				'options' => array(
					'date' => esc_html__( 'Date', 'nictiz-toolkit' ),
					'rand' => esc_html__( 'Random', 'nictiz-toolkit' )
				)
			),
			'posts_per_page'  => array(
				'type'  => 'text',
				'std'   => 4,
				'label' => esc_html__( 'Number of items', 'nictiz-toolkit' )
			)
		);

		parent::__construct();
	}

	public function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
		
		$query = array(
			'post_type'           => 'services',
			'posts_per_page'      => $instance['posts_per_page'],
			'orderby'             => $instance['orderby'],
			'ignore_sticky_posts' => true
		);

		if ( $instance['categories'] ) {		
			if ( $instance['categories'][0] == '' )
				unset( $instance['categories'][0] );

			if ( $instance['categories'] ) {
				$query['tax_query'][] = array(
					'taxonomy' => 'service_category',
					'field'    => 'id',
					'terms'    => $instance['categories']
				);
			}
		}

		if ( $instance['tags'] ) {
			if ( $instance['tags'][0] == '' )
				unset( $instance['tags'][0] );

			if ( $instance['tags'] ) {
				$query['tax_query'][] = array(
					'taxonomy' => 'service_tag',
					'field'    => 'id',
					'terms'    => $instance['tags']
				);
			}
		}

		if ( isset( $query['tax_query'] ) && count( $query['tax_query'] ) === 2 ) {
			$query['tax_query']['relation'] = $instance['relation'];
		}
		$result_set = new WP_Query( $query );
		echo wp_kses_post( $before_widget );
		$index = 1;
		?>
			<?php if ( $title ) 
				echo wp_kses_post( $before_title . $title .$after_title );
			?>
			<?php if ( $result_set->have_posts() ) : ?>
				<div class="widget-content">
					<div class="row">
						<?php 
							while( $result_set->have_posts() ) : $result_set->the_post();
							$icon = get_post_meta( get_the_id(), 'icon_class', true );
						?>
							<div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="icon-box style-2 ">
                                    <i class="icon fa <?php echo esc_attr( $icon ); if ( $index % 2 == 0 ) echo ' active'; ?>"></i>
                                    <h3><?php the_title(); ?></h3>
                                    <div class="divider"></div>
                                    <?php the_excerpt(); ?>
                                    <a href="<?php the_permalink(); ?>" class="read-more "><?php esc_html_e( 'more info', 'nictiz-toolkit' ); ?></a>
                                </div>
                            </div>
						<?php $index++; endwhile; ?>
					</div>
				</div>
			<?php endif; ?>
		<?php
		wp_reset_postdata();
		echo wp_kses_post( $after_widget );
	}
}