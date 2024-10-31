<?php

add_action( 'kpb_get_widgets_list', array( 'Nictiz_Toolkit_Widget_Posts_List_Carousel', 'register_block' ) );
	
class Nictiz_Toolkit_Widget_Posts_List_Carousel extends Kopa_Widget {

	public $kpb_group = 'post';
	
	public static function register_block( $blocks ) {
       	$blocks['Nictiz_Toolkit_Widget_Posts_List_Carousel'] = new Nictiz_Toolkit_Widget_Posts_List_Carousel();
        return $blocks;
    }
    
	public function __construct() {
		$this->widget_cssclass    = 'k-widget-post-carousel has-header has-icon-header has-background';
		$this->widget_description = esc_html__( 'This widget displays posts in Carousel slider.', 'nictiz-toolkit' );
		$this->widget_id          = 'nictitate-toolkit-ii-widget-posts-list-carousel';
		$this->widget_name        = esc_html__( '__Posts List Carousel', 'nictiz-toolkit' );
		$this->settings 		  = nictiz_toolkit_get_post_widget_args();
		$this->settings['excerpt_length'] = array(
			'type'  => 'number',
			'std'   => 20,
			'label' => esc_html__( 'Excerpt length:', 'nictiz-toolkit' ),
			'desc'  => ''
		);

		parent::__construct();
	}

	public function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );
		$title      = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		$query      = nictiz_toolkit_get_post_widget_query( $instance );
		$result_set = new WP_Query( $query );
		echo wp_kses_post( $before_widget );
		$index      = 2;
		?>
			<?php if ( $title ) 
				echo wp_kses_post( $before_title . $title .$after_title );
			?>
			<?php if ( $result_set->have_posts() ) : ?>
				<div class="widget-content">
                        <div class="owl-carousel">
						<?php while ( $result_set->have_posts() ) : $result_set->the_post(); ?>
							<?php if ( $index % 2 == 0 ) : ?>
								<div class="item item-right ">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12 item-thumb">
                                            <a href="<?php the_permalink(); ?>">
												<?php if ( has_post_thumbnail() ) {
														echo get_the_post_thumbnail( get_the_id(), 'nictitate_posts-list-carousel' );
													} else {
														echo '<img src="http://placehold.it/279x207">';
													}
												?>
											</a>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12 item-content">
                                            <div class="item-time">
                                                <span class="item-time-day"><?php echo get_the_date( 'd' ); ?></span>
                                                <span class="item-time-mon-year"><?php echo get_the_date( 'M Y' ); ?></span>
                                            </div>
                                            <h4 class="item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                            <?php
												$GLOBALS['nictiz_excerpt_length'] = (int) $excerpt_length;
												add_filter( 'excerpt_length', 'nictiz_set_excerpt_length' );
												the_excerpt();
												remove_filter( 'excerpt_length', 'nictiz_set_excerpt_length' );
											?>
                                        </div>
                                    </div>
                                </div>
							<?php else: ?>
								<div class="item item-left ">
                                    <div class="row">
                                        <div class="item-thumb col-md-6 col-sm-6 col-xs-12">
                                            <a href="<?php the_permalink(); ?>">
												<?php if ( has_post_thumbnail() ) {
														echo get_the_post_thumbnail( get_the_id(), 'nictitate_posts-list-carousel' );
													} else {
														echo '<img src="http://placehold.it/279x207">';
													}
												?>
											</a>
                                        </div>
                                        <div class="item-content col-md-6 col-sm-6 col-xs-12">
                                            <div class="item-time">
                                                <span class="item-time-day"><?php echo get_the_date( 'd' ); ?></span>
                                                <span class="item-time-mon-year"><?php echo get_the_date( 'M Y' ); ?></span>
                                            </div>
                                            <h4 class="item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                            <?php 
												$GLOBALS['nictiz_excerpt_length'] = (int) $excerpt_length;
												add_filter( 'excerpt_length', 'nictiz_set_excerpt_length' );
												the_excerpt(); 
												remove_filter( 'excerpt_length', 'nictiz_set_excerpt_length' );
											?>
                                        </div>
                                    </div>
                                </div>
							<?php endif; $index++; ?>
						<?php endwhile; ?>
					</div>
				</div>
			<?php endif; ?>
		<?php
		wp_reset_postdata();
		echo wp_kses_post( $after_widget );
	}
}