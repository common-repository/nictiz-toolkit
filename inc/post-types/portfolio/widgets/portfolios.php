<?php

add_action( 'kpb_get_widgets_list', array( 'Nictiz_Toolkit_Widget_Portfolios', 'register_block' ) );
	
class Nictiz_Toolkit_Widget_Portfolios extends Kopa_Widget {

	public $kpb_group = 'portfolio';
	
	public static function register_block( $blocks ) {
       	$blocks['Nictiz_Toolkit_Widget_Portfolios'] = new Nictiz_Toolkit_Widget_Portfolios();
        return $blocks;
    }
    
	public function __construct() {
		$cat_arr    = array();
		$tag_arr    = array();
		$categories = get_terms( 'portfolio_project' );
		$tags       = get_terms( 'portfolio_tag' );
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
		$this->widget_cssclass    = 'k-widget-portfolio';
		$this->widget_description = esc_html__( 'This widget displays portfolio items.', 'nictiz-toolkit' );
		$this->widget_id          = 'nictitate-toolkit-ii-widget-portfolios';
		$this->widget_name        = esc_html__( '__Portfolios', 'nictiz-toolkit' );
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
					'OR'  => esc_html__( 'OR', 'nictiz-toolkit' ),
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
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		
		$query = array(
			'post_type'           => 'portfolio',
			'posts_per_page'      => $instance['posts_per_page'],
			'orderby'             => $instance['orderby'],
			'ignore_sticky_posts' => true
		);

		if ( $instance['categories'] ) {		
			if ( $instance['categories'][0] == '' )
				unset( $instance['categories'][0] );

			if ( $instance['categories'] ) {
				$query['tax_query'][] = array(
					'taxonomy' => 'portfolio_project',
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
					'taxonomy' => 'portfolio_tag',
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
        			<ul class="hover_div da-thumbs">
						<?php while ( $result_set->have_posts() ) : $result_set->the_post(); ?>
							<?php if ( $index == 1 || $index == 4 ) : ?>
								<li class="item item-lg">
									<a href="<?php the_permalink(); ?>">
										<?php 
											if ( has_post_thumbnail() ) {
												the_post_thumbnail( 'nictitate_portfolio-big' ); 
											} else {
												echo '<img src="http://placehold.it/568x381">';
											}
										?>
										<div>
	                                        <div class="inner">
	                                        	<?php 
	                                        		$terms = get_the_terms( get_the_ID(), 'portfolio_project' ); 
													if ( $terms ) {
														echo '<h4 class="item-title">';
					                                    foreach ( $terms as $term ) {
					                                        echo wp_kses_post( $term->name );
					                                    }
					                                    echo '</h4>';
					                                }
												?>
												<p><?php the_title(); ?></p>
	                                        </div>
										</div>
									</a>
								</li>
							<?php else : ?>
								<li class="item item-sm">
									<a href="<?php the_permalink(); ?>">
										<?php 
											if ( has_post_thumbnail() ) {
												the_post_thumbnail( 'nictitate_portfolio-small' ); 
											} else {
												echo '<img src="http://placehold.it/279x185" alt="">';
											}
										?>
										<div>
											<div class="inner">
												<?php 
	                                        		$terms = get_the_terms( get_the_ID(), 'portfolio_project' ); 
													if ( $terms ) {
														echo '<h4 class="item-title">';
					                                    foreach ( $terms as $term ) {
					                                        echo wp_kses_post( $term->name );
					                                    }
					                                    echo '</h4>';
					                                }
												?>
	                                            <p><?php the_title(); ?></p>
	                                        </div>
										</div>
									</a>
								</li>
							<?php 
								endif; 
								if ( $index == 6 ) {
									$index = 0;
								}
								$index++; 
							?>
						<?php endwhile; ?>
					</ul>
					<div class="text-center">
						<a href="<?php echo get_post_type_archive_link( 'portfolio' ); ?>" class="read-more read-more-border"><?php esc_html_e( 'view all portfolio', 'nictiz-toolkit' ); ?></a>
					</div>
				</div>
			<?php endif; ?>
		<?php
		wp_reset_postdata();
		echo wp_kses_post( $after_widget );
	}
}