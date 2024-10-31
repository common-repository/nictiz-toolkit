<?php

add_filter( 'kpb_get_widgets_list', array( 'Nictiz_Toolkit_Widget_Staff_List', 'register_block' ) );

class Nictiz_Toolkit_Widget_Staff_List extends Kopa_Widget {

	public $kpb_group = 'staff';
	
	public static function register_block( $blocks ) {
        $blocks['Nictiz_Toolkit_Widget_Staff_List'] = new Nictiz_Toolkit_Widget_Staff_List();
        return $blocks;
    }

	public function __construct() {
		$this->widget_cssclass    = 'k-widget-user k-widget has-header has-icon-header';
		$this->widget_description = esc_html__( 'Display Staffs.', 'nictiz-toolkit' );
		$this->widget_id          = 'kopa-staff list';
		$this->widget_name        = esc_html__( '__Staff List', 'nictiz-toolkit' );

		$this->settings = array(			
			'title'  => array(
				'type'  => 'text',
				'std'   => '',
				'label' => esc_html__( 'Title', 'nictiz-toolkit' )
			),			
		);

		$this->settings['posts_per_page'] = array(
			'type'  => 'text',
			'std'   => 4,
			'label' => esc_html__( 'Number of skill', 'nictiz-toolkit' )	
		);	

		$this->settings['items_per_row'] = array(			
			'type'  => 'select',
			'std'   => '4',
			'label' => esc_html__( 'Items per row', 'nictiz-toolkit' ),
			'options' => array(
				'12' => '1',
				'6'  => '2',
				'4'  => '3',
				'3'  => '4',
				'2'  => '6',
				'1'  => '12'
			)	
		);	

		$cbo_tags_options = array( '' => esc_html__( '-- All --', 'nictiz-toolkit' ) );
		
		$tags = get_terms( 'staff_tag' );				
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
		
		$cbo_cats_options = array( '' => esc_html__( '-- All --', 'nictiz-toolkit' ) );
		
		$cats = get_terms( 'staff_category' );				
		if ( $cats && !is_wp_error( $cats ) ) {						
			foreach ( $cats as $cat ) {									
				$cbo_cats_options[ $cat->slug ] = "{$cat->name} ({$cat->count})";
			}
		}
		
		$this->settings['cats'] = array(
			'type'    => 'select',
			'label'   => esc_html__( 'Categories', 'nictiz-toolkit' ),
			'std'     => '',
			'options' => $cbo_cats_options
		);
		
		$this->settings['relation'] = array(
			'type'    => 'select',
			'label'   => esc_html__( 'Relation', 'nictiz-toolkit' ),
			'std'     => 'OR',
			'options' => array(
				'OR'  => esc_html__('Or', 'nictiz-toolkit'),
				'AND' => esc_html__('And', 'nictiz-toolkit')
				)
		);

		parent::__construct();
	}

	public function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		
		$query_args['post_type']      = 'staffs';
		$query_args['cat_name']       = 'staff_category';
		$query_args['tag_name']       = 'staff_tag';
		$query_args['categories']     = $instance['cats'];
		$query_args['relation']       = esc_attr($instance['relation']);
		$query_args['tags']           = $instance['tags'];
		$query_args['posts_per_page'] = (int) $instance['posts_per_page'];        

		$query         = nictiz_toolkit_build_query( $query_args );		
		$result_set    = $query ;		
		$items_per_row = isset( $instance['items_per_row'] ) ? $instance['items_per_row'] : 4 ;
		$col_class     = 'col-md-'.$items_per_row . ' col-sm-'.$items_per_row . ' col-xs-12';

		echo wp_kses_post( $before_widget );
		if ( $title ) {
			echo wp_kses_post( $before_title . $title . $after_title );
		}
		?>
		<div class="widget-content">
			<?php if ( $result_set->have_posts() ) : ?>
				<div class="row">
					<?php 
						while ( $result_set->have_posts() ) : $result_set->the_post();
						$staff_social                                = nictiz_toolkit_staff_social_link();
						$nictiz_toolkit_staff_social_link = array();
						foreach ( $staff_social as $key => $value ) {
							$url = get_post_meta( get_the_ID(), $key , true );
							if ( $url ) {
								$nictiz_toolkit_staff_social_link[ $key ] = array( 'name' => $value['name'], 'url' => $url, 'icon' => $value['icon'] );
							}
						}
						$position = get_post_meta( get_the_ID(), 'position', true );
	                	?>
	                	<div class="<?php echo esc_attr( $col_class ); ?>">
	                		<div class="item">
	                			<?php if ( has_post_thumbnail() ) : ?>
	                			<div class="item-thumb">
	                				<?php the_post_thumbnail( 'nictiz-staff-list', array( 'title' => get_the_title(), 'alt' => '' ) ); ?>
	                			</div>
	                			<?php endif; ?>
	                			<?php if ( ! empty( $nictiz_toolkit_staff_social_link ) ) : ?>
		                			<div class="item-social">
		                				<div>
		                					<?php foreach ( $nictiz_toolkit_staff_social_link as $key => $value ) {
		                						?>
		                						<a href="<?php echo esc_attr( $value['url'] ); ?>" class="<?php echo esc_attr( $value['icon'] ); ?>"></a>
		                						<?php
		                					} ?>
		                				</div>
		                			</div>
	                			<?php endif; ?>
	                			<h4 class="item-title"><?php the_title(); ?></h4>
	                			<?php if ( $position ) : ?>
	                				<h5 class="item-position"><?php echo esc_html( $position ); ?></h5>
	                			<?php endif; ?>
	                			<?php the_excerpt(); ?>
	                		</div>
	                	</div>
	                	<?php
	                endwhile;
					?>
				</div>
			<?php endif; ?>
		</div>
        <?php
		wp_reset_postdata();
		echo wp_kses_post( $after_widget );	
	}
}