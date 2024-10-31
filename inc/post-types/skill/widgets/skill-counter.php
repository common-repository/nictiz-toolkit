<?php

add_filter( 'kpb_get_widgets_list', array( 'Nictiz_Toolkit_Widget_Skill_Counter', 'register_block' ) );

class Nictiz_Toolkit_Widget_Skill_Counter extends Kopa_Widget {

	public $kpb_group = 'skill';
	
	public static function register_block( $blocks ) {
        $blocks['Nictiz_Toolkit_Widget_Skill_Counter'] = new Nictiz_Toolkit_Widget_Skill_Counter();
        return $blocks;
    }

	public function __construct() {
		$this->widget_cssclass    = 'k-widget-number';
		$this->widget_description = esc_html__( 'Display skill progress.', 'nictiz-toolkit' );
		$this->widget_id          = 'kopa-skill-counter';
		$this->widget_name        = esc_html__( '__Skill Counter', 'nictiz-toolkit' );

		$this->settings = array(			
			'title'  => array(
				'type'  => 'text',
				'std'   => '',
				'label' => esc_html__( 'Title', 'nictiz-toolkit' )
			)	
		);

		$this->settings = array(			
			'posts_per_page'  => array(
				'type'  => 'text',
				'std'   => 4,
				'label' => esc_html__( 'Number of skill', 'nictiz-toolkit' )
			)
		);	

		$cbo_tags_options = array( '' => esc_html__( '-- All --', 'nictiz-toolkit' ) );
		
		$tags = get_terms( 'skill-tag' );				
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
		$title       = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$description = $instance['description'];

		$query = array(
			'post_type'      => array( 'skill' ),
			'posts_per_page' => (int) $instance['posts_per_page'],
			'post_status'    => array( 'publish' )
		);

		if ( ! empty( $tags ) ) {
			$query['tax_query'] = array(
				array(
					'taxonomy' => 'skill-tag',
					'field'    => 'slug',
					'terms'    => $tags
				),
			);
		}

		$result_set = new WP_Query( $query );
		
		echo wp_kses_post( $before_widget );
		if ( $title ) {
			echo wp_kses_post( $before_title . $title .$after_title );
		}
		?>
			<?php if ( $result_set->have_posts() ) : ?>
				<ul class="list-item list-unstyled">
					<?php 
						while ( $result_set->have_posts() ) : $result_set->the_post();
		                	$skill_progress = get_post_meta( get_the_ID(), 'nictitate-toolkit-skill-progress', true );
		                	$skill_progress = isset( $skill_progress ) ? $skill_progress : 0 ;
		                	$rand = rand();
		                	?>
		                	<li class="item">
		                		<span class="item-number" id="item-number-<?php echo esc_attr( $rand ); ?>" data-number="<?php echo esc_attr( $skill_progress ); ?>">0</span>
		                		<span class="item-text"><?php the_title(); ?></span>
		                	</li>
		                	<?php
		                endwhile;
					?>
				</ul>
			<?php endif; ?>
        <?php
		wp_reset_postdata();
		echo wp_kses_post( $after_widget );
	}
}