<?php

add_action( 'kpb_get_widgets_list', array( 'Nictiz_Toolkit_Widget_Posts_List_3_Col', 'register_block' ) );
	
class Nictiz_Toolkit_Widget_Posts_List_3_Col extends Kopa_Widget {

	public $kpb_group = 'post';
	
	public static function register_block( $blocks ) { 
       	$blocks['Nictiz_Toolkit_Widget_Posts_List_3_Col'] = new Nictiz_Toolkit_Widget_Posts_List_3_Col();
        return $blocks;
    }
    
	public function __construct() {
		$this->widget_cssclass    = 'k-widget-post-two-size-thumb';
		$this->widget_description = esc_html__( 'This widget displays the list of posts in 3 columns. The first post has large-thumbnail image.', 'nictiz-toolkit' );
		$this->widget_id          = 'nictitate-toolkit-ii-widget-posts-list-3-col';
		$this->widget_name        = esc_html__( '__Posts List 3 Cols', 'nictiz-toolkit' );
		$this->settings 		  = nictiz_toolkit_get_post_widget_args();
		$this->settings['excerpt_length_big_thumb'] = array(
			'type'  => 'number',
			'std'   => 20,
			'label' => esc_html__( 'Excerpt length post big thumb:', 'nictiz-toolkit' ),
			'desc'  => ''
		);
		$this->settings['excerpt_length'] = array(
			'type'  => 'number',
			'std'   => 20,
			'label' => esc_html__( 'Excerpt length:', 'nictiz-toolkit' ),
			'desc'  => ''
		);
		$this->settings['button_text'] = array(
			'type'  => 'text',
			'std'   => esc_html__('view all post', 'nictiz-toolkit'),
			'label' => esc_html__( 'Button Text:', 'nictiz-toolkit' ),
			'desc'  => ''
		);
		$this->settings['button_url'] = array(
			'type'  => 'text',
			'std'   => '',
			'label' => esc_html__( 'Button URL:', 'nictiz-toolkit' ),
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
		$index     = 1;
		$index_2   = 1;
		$real_post = count( $result_set->posts );
		?>
			<?php if ( $title ) 
				echo wp_kses_post( $before_title . $title .$after_title );
			?>
			<?php if ( $result_set->have_posts() ) : ?>
				<div class="widget-content">
        			<div class="row">
						<?php while ( $result_set->have_posts() ) : $result_set->the_post(); ?>
							<?php if ( $index == 1 ) : ?>
								<div class="col-md-6 col-sm-4 col-xs-12">
									<div class="item item-lg ">
										<div class="item-thumb">
											<a href="<?php the_permalink(); ?>">
												<?php if ( has_post_thumbnail() ) {
														echo get_the_post_thumbnail( get_the_id(), 'nictitate_posts-list-3-col-big' );
													} else {
														echo '<img src="http://placehold.it/556x367">';
													}
												?>
											</a>
											<div class="item-metadata k-item-metadata">
												<span class="item-metadata-time">
													<span class="item-metadata-time-day"><?php echo get_the_date( 'd' ); ?></span>
													<span class="item-metadata-time-mon"><?php echo get_the_date( 'M' ); ?></span>
												</span>
												<span class="item-metadata-comments">
													<span class="item-metadata-comments-count"><?php echo get_comments_number( get_the_id() ); ?></span>
													<span class="item-metadata-comments-title"><?php esc_html_e( 'Com', 'nictiz-toolkit' ); ?></span>
												</span>
											</div>
										</div>
										<h4 class="item-title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h4>
										<?php 
											$GLOBALS['nictiz_excerpt_length'] = (int) $excerpt_length_big_thumb;
											add_filter( 'excerpt_length', 'nictiz_set_excerpt_length' );
											the_excerpt(); 
											remove_filter( 'excerpt_length', 'nictiz_set_excerpt_length' );
										?>
									</div>
								</div>
							<?php else: ?>
								<div class="col-md-3 col-sm-4 col-xs-12">
									<div class="item item-sm  ">
										<div class="item-thumb">
											<a href="<?php the_permalink(); ?>">
												<?php if ( has_post_thumbnail() ) {
														echo get_the_post_thumbnail( get_the_id(), 'nictitate_posts-list-3-col-small' );
													} else {
														echo '<img src="http://placehold.it/264x209">';
													}
												?>
											</a>
											<div class="item-metadata k-item-metadata">
												<span class="item-metadata-time">
													<span class="item-metadata-time-day"><?php echo get_the_date( 'd' ); ?></span>
													<span class="item-metadata-time-mon"><?php echo get_the_date( 'M' ); ?></span>
												</span>
												<span class="item-metadata-comments">
													<span class="item-metadata-comments-count"><?php echo get_comments_number( get_the_id() ); ?></span>
													<span class="item-metadata-comments-title"><?php esc_html_e( 'Com', 'nictiz-toolkit' ); ?></span>
												</span>
											</div>
										</div>
										<h4 class="item-title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h4>
										<?php 
											$GLOBALS['nictiz_excerpt_length'] = (int) $excerpt_length;
											add_filter( 'excerpt_length', 'nictiz_set_excerpt_length' );
											the_excerpt(); 
											remove_filter( 'excerpt_length', 'nictiz_set_excerpt_length' );
										?>
									</div>
								</div>
							<?php endif; 
							if ( $index == 3 ) {
								$index = 0;
								if ( $index_2 != $real_post ) { 
									echo '</div><div class="row">';
								}
							}
							$index++; $index_2++; ?>
						<?php endwhile; ?>
					</div>
					<?php 
						if ( $button_url && $button_text ) {
							echo 	'<p class="text-center">
        							    <a href="'.esc_url( $button_url ).'" class="read-more read-more-border">'.wp_kses_post( $button_text ).'</a>
                                    </p>';
						}
					?>
				</div>
			<?php endif; ?>
		<?php
		wp_reset_postdata();
		echo wp_kses_post( $after_widget );
	}
}