<?php

add_filter( 'kpb_get_widgets_list', array( 'Nictiz_Toolkit_Widget_Slider_Carousel', 'register_block' ) );

class Nictiz_Toolkit_Widget_Slider_Carousel extends Kopa_Widget {

	public $kpb_group = 'slider';
	
	public static function register_block( $blocks ) {
        $blocks['Nictiz_Toolkit_Widget_Slider_Carousel'] = new Nictiz_Toolkit_Widget_Slider_Carousel();
        return $blocks;
    }

	public function __construct() {
		$this->widget_cssclass    = 'k-widget-post-single-carousel-2';
		$this->widget_description = esc_html__( 'Display simple carousel slider.', 'nictiz-toolkit' );
		$this->widget_id          = 'kopa-slider';
		$this->widget_name        = esc_html__( '__Carousel Slider', 'nictiz-toolkit' );

		$this->settings = array(			
			'title'  => array(
				'type'  => 'text',
				'std'   => '',
				'label' => esc_html__( 'Title', 'nictiz-toolkit' )
			)	
		);

		$this->settings['description'] = array(			
				'type'  => 'textarea',
				'std'   => '',
				'label' => esc_html__( 'Description', 'nictiz-toolkit' )		
		);	
		$this->settings['posts_per_page'] = array(
				'type'  => 'text',
				'std'   => 4,
				'label' => esc_html__( 'Number of slide', 'nictiz-toolkit' )	
		);	

		$cbo_tags_options = array( '' => esc_html__( '-- All --', 'nictiz-toolkit' ) );
		
		$tags = get_terms( 'slide-tag' );				
		if ( $tags && !is_wp_error( $tags ) ) {						
			foreach ( $tags as $tag ) {									
				$cbo_tags_options[ $tag->slug ] = "{$tag->name} ({$tag->count})";
			}
		}
		
		$this->settings['tags'] = array(
			'type'    => 'select',
			'label'   => esc_html__( 'Tags', 'nictiz-toolkit' ),
			'std'     => '',
			'options' => $cbo_tags_options
		);

		parent::__construct();
	}

	public function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$description = $instance['description'];

		$query = array(
			'post_type'      => array( 'slide' ),
			'posts_per_page' => (int) $instance['posts_per_page'],
			'post_status'    => array( 'publish' )
		);

		if ( ! empty( $tags ) ) {
			$query['tax_query'] = array(
				array(
					'taxonomy' => 'slide-tag',
					'field'    => 'slug',
					'terms'    => $tags
				)
			);
		}

		$result_set = new WP_Query( $query );
		echo wp_kses_post( $before_widget );
		if ( $title ) {
			echo wp_kses_post( $before_title . $title . $after_title );
		}
		?>
		<div class="widget-content">
			<div class="row">
				<?php if ( $result_set->have_posts() ) : ?>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="owl-carousel single-carousel">
						<?php
		                    while ( $result_set->have_posts() ) : $result_set->the_post();
		                        if ( has_post_thumbnail() ) :
		                            ?>
		                            <div class="item">
		                            	<?php the_post_thumbnail( 'nictiz-slider-carousel', array('title' => get_the_title(), 'alt' => '') ); ?>
		                            </div>
		                            <?php
		                        endif;
		                    endwhile;
	                    ?>
					</div>
				</div>
				<?php 
				endif;
				if ( isset( $description ) ):
				?>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<?php echo do_shortcode( $description ); ?>
					</div>
				<?php 
				endif;
				?>
			</div>
		</div>
        <?php
		wp_reset_postdata();
		echo wp_kses_post( $after_widget );	
	}
}