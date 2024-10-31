<?php

add_action( 'kpb_get_widgets_list', array( 'Nictiz_Toolkit_Widget_Portfolio_Single', 'register_block' ) );
	
class Nictiz_Toolkit_Widget_Portfolio_Single extends Kopa_Widget {

	public $kpb_group = 'portfolio';
	
	public static function register_block( $blocks ) {
       	$blocks['Nictiz_Toolkit_Widget_Portfolio_Single'] = new Nictiz_Toolkit_Widget_Portfolio_Single();
        return $blocks;
    }
    
	public function __construct() {
		$posts = get_posts(array(
			'posts_per_page'   => -1,
			'post_type'        => 'portfolio'
		));
		wp_reset_query();
		$cbo_options = array();
		if ( $posts ) {			
			foreach ( $posts as $post ) {						
				$cbo_options[ $post->post_name ] = $post->post_title;
			}
		}
		$this->widget_cssclass    = 'k-widget-portfolio-single-img';
		$this->widget_description = esc_html__( 'This widget displays a single portfolio post.', 'nictiz-toolkit' );
		$this->widget_id          = 'nictitate-toolkit-ii-widget-portfolio-single';
		$this->widget_name        = esc_html__( '__Single Portfolio', 'nictiz-toolkit' );
		$this->settings 		  = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => '',
				'label' => esc_html__( 'Title:', 'nictiz-toolkit' )
			),
			'post_name' => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Select a post', 'nictiz-toolkit' ),
				'std'     => '',
				'options' => $cbo_options
			),
			'excerpt_length'  => array(
				'type'  => 'text',
				'std'   => 20,
				'label' => esc_html__( 'Number of excerpt length', 'nictiz-toolkit' )
			)
		);

		parent::__construct();
	}

	public function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		$result_set = new WP_Query(array(
			'posts_per_page' => 1,
			'post_type'      => 'portfolio',
			'name'           => $post_name
		));	
		echo wp_kses_post( $before_widget );
		?>
			<?php if ( $title ) 
				echo wp_kses_post( $before_title . $title .$after_title );
			?>
			<?php if ( $result_set->have_posts() ): while( $result_set->have_posts() ) : $result_set->the_post(); ?>
				<div class="row item">
                    <div class="col-md-6 col-sm-6 col-xs-12 item-content">
                        <h4 class="item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        <?php 
							$GLOBALS['nictiz_excerpt_length'] = (int) $excerpt_length;
							add_filter( 'excerpt_length', 'nictiz_set_excerpt_length' );
							the_excerpt(); 
							remove_filter( 'excerpt_length', 'nictiz_set_excerpt_length' );
						?>
                        <a href="<?php the_permalink(); ?>" class="read-more read-more-border"><?php esc_html_e( 'view more', 'nictiz-toolkit' ); ?></a>
                    </div>
                    <div class="item-thumb">
                    	<a href="<?php the_permalink(); ?>">
                    		<?php 
                    			if ( has_post_thumbnail() ) {
                    				the_post_thumbnail( 'nictitate_portfolio-single' );
                    			} else {
                    				echo '<img src="http://placehold.it/683x366">';
                    			}
                    		?>
                    	</a>
                    </div>
                </div>
			<?php endwhile; endif; ?>
		<?php
		wp_reset_postdata();
		echo wp_kses_post( $after_widget );
	}
}