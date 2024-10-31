<?php

add_action( 'kpb_get_widgets_list', array( 'Nictiz_Toolkit_Widget_Portfolios_Circle', 'register_block' ) );
	
class Nictiz_Toolkit_Widget_Portfolios_Circle extends Kopa_Widget {

	public $kpb_group = 'portfolio';
	
	public static function register_block( $blocks ) {
       	$blocks['Nictiz_Toolkit_Widget_Portfolios_Circle'] = new Nictiz_Toolkit_Widget_Portfolios_Circle();
        return $blocks;
    }
    
	public function __construct() {
		$cat_arr    = array();
		$tag_arr    = array();
		$categories = get_terms( 'portfolio_project' );
		$tags       = get_terms( 'portfolio_tag' );
		if ( $categories && ! is_wp_error( $categories ) ) {
	        foreach ( $categories as $category ) {
	        	$cat_arr[ $category->term_id ] = $category->name.'('.$category->count.')';
	        }
	    }
        if ( $tags && ! is_wp_error( $tags ) ) {
	        foreach ( $tags as $tag ) {
	        	$tag_arr[ $tag->term_id ] = $tag->name.'('.$tag->count.')';
	        }
	    }
		$this->widget_cssclass    = 'k-widget-portfolio-circle-img has-header has-icon-header';
		$this->widget_description = esc_html__( 'This widget displays portfolios items with circle images.', 'nictiz-toolkit' );
		$this->widget_id          = 'nictitate-toolkit-ii-widget-portfolios-circle';
		$this->widget_name        = esc_html__( '__Portfolios Circle', 'nictiz-toolkit' );
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
					'terms'    => $instance['categories'],
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
					'terms'    => $instance['tags'],
				);
			}
		}

		if ( isset( $query['tax_query'] ) && count( $query['tax_query'] ) === 2 ) {
			$query['tax_query']['relation'] = $instance['relation'];
		}
		
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
				<div class="widget-content clearfix">
					<?php while( $result_set->have_posts() ) : $result_set->the_post(); ?>
						<?php if ( $index == 1 ) : ?>
	                        <div class="item item-size-1 ">
	                            <div class="item-thumb">
	                                <a href="<?php the_permalink(); ?>">
	                                	<?php 
	                                		$custom_thumb_url = get_post_meta( get_the_id(), 'portfolio_custom_thumbnail', true );
		                                	if ( has_post_thumbnail() || $custom_thumb_url ) {
		                                		if ( $custom_thumb_url ) {
		                                			echo '<img src="'.esc_url( $custom_thumb_url ).'" alt="">';
		                                		} else {
			                                		the_post_thumbnail( 'nictitate_portfolio-circle-1' ); 
			                                	}
		                                	} else {
		                                		echo '<img src="http://placehold.it/146x146" alt="">';
		                                	}
		                                ?>
	                                </a>
	                            </div>
	                            <h4 class="item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
	                        </div>
	                    <?php elseif ( $index == 2 ) : ?>
	                        <div class="item item-size-2 ">
	                            <div class="item-thumb">
	                                <a href="<?php the_permalink(); ?>">
	                                	<?php 
	                                		$custom_thumb_url = get_post_meta( get_the_id(), 'portfolio_custom_thumbnail', true );
		                                	if ( has_post_thumbnail() || $custom_thumb_url ) {
		                                		if ( $custom_thumb_url ) {
		                                			echo '<img src="'.esc_url( $custom_thumb_url ).'" alt="">';
		                                		} else {
			                                		the_post_thumbnail( 'nictitate_portfolio-circle-2' ); 
			                                	}
		                                	} else {
		                                		echo '<img src="http://placehold.it/220x220">';
		                                	}
		                                ?>
	                                </a>
	                            </div>
	                            <h4 class="item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
	                        </div>
	                    <?php elseif ( $index == 3 ) : ?>
	                        <div class="item item-size-3 ">
	                            <div class="item-thumb">
	                                <a href="<?php the_permalink(); ?>">
	                                	<?php
		                                	$custom_thumb_url = get_post_meta( get_the_id(), 'portfolio_custom_thumbnail', true );
		                                	if ( has_post_thumbnail() || $custom_thumb_url ) {
		                                		if ( $custom_thumb_url ) {
		                                			echo '<img src="'.esc_url( $custom_thumb_url ).'" alt="">';
		                                		} else {
			                                		the_post_thumbnail( 'nictitate_portfolio-circle-3' ); 
			                                	}
		                                	} else {
		                                		echo '<img src="http://placehold.it/134x134">';
		                                	}
		                                ?>
	                                </a>
	                            </div>
	                            <h4 class="item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
	                        </div>
	                    <?php elseif ( $index == 4 ) : ?>
	                        <div class="item item-size-4 ">
	                            <div class="item-thumb">
	                                <a href="<?php the_permalink(); ?>">
		                                <?php 
		                                	$custom_thumb_url = get_post_meta( get_the_id(), 'portfolio_custom_thumbnail', true );
		                                	if ( has_post_thumbnail() || $custom_thumb_url ) {
		                                		if ( $custom_thumb_url ) {
		                                			echo '<img src="'.esc_url( $custom_thumb_url ).'" alt="">';
		                                		} else {
			                                		the_post_thumbnail( 'nictitate_portfolio-circle-4' ); 
			                                	}
		                                	} else {
		                                		echo '<img src="http://placehold.it/273x273">';
		                                	}
		                                ?>
	                                </a>
	                            </div>
	                            <h4 class="item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
	                        </div>
	                        <?php 
	                        	if ( $index_2 != $real_post ) { 
									echo '</div><div class="widget-content clearfix">';
								}
							?>
	                    <?php $index = 0; endif; $index++; $index_2++; ?>
					<?php endwhile; ?>
				</div>
			<?php endif; ?>
		<?php
		wp_reset_postdata();
		echo wp_kses_post( $after_widget );
	}
}