<?php

add_action( 'widgets_init', array( 'Nictiz_Toolkit_Widget_Recent_Post', 'register_widget' ) );

class Nictiz_Toolkit_Widget_Recent_Post extends Kopa_Widget {

	public $kpb_group = 'post';

    public static function register_widget() {
        register_widget( 'Nictiz_Toolkit_Widget_Recent_Post' );
    }

	public function __construct() {
		$this->widget_cssclass    = 'k-post-sm-thumb';
		$this->widget_description = esc_html__( 'This widget displays the list of recent posts.', 'nictiz-toolkit' );
		$this->widget_id          = 'nictitate_toolkit_ii-recent-post';
		$this->widget_name        = esc_html__( '__Recent Posts', 'nictiz-toolkit' );

		$this->settings 		  = array(
            'title'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Title:', 'nictiz-toolkit' )
            ),
            'posts_per_page' => array(
                'type'    => 'number',
                'std'     => '3',
                'label'   => esc_html__( 'Number of posts:', 'nictiz-toolkit' ),
                'min'     => '1'
            ),
            'enable_date'  => array(
                'type'  => 'checkbox',
                'std'   => 1,
                'label' => esc_html__( 'Display post date?', 'nictiz-toolkit' )
            ),
            'enable_author'  => array(
                'type'  => 'checkbox',
                'std'   => 1,
                'label' => esc_html__( 'Display post author?', 'nictiz-toolkit' )
            )
        );

		parent::__construct();
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$instance = wp_parse_args( (array) $instance, $this->get_default_instance() );
		extract( $instance );
		
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );		
        $posts = nictiz_toolkit_build_query( $instance );
		echo wp_kses_post( $before_widget );
        if ( ! empty( $title ) ) : ?>
            <h3 class="widget-title"><?php echo esc_html( $title ); ?></h3>
        <?php endif; ?>
            <div class="wiget-content">
                <?php if ( $posts->have_posts() ) : ?>
                    <ul class="list-item list-unstyled">
                        <?php while ( $posts->have_posts() ): $posts->the_post(); ?>
                            <li class="item">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <div class="item-thumb">
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail( 'nictiz-w-recent-post' ); ?></a>
                                    </div>
                                <?php endif; ?>
                                <h4 class="item-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
                                <div class="item-metadata">
                                    <?php
                                        $post_author_name = get_the_author_meta( 'display_name' );
                                        $post_author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );
                                        if ( 1 === intval( $enable_author ) ) :
                                    ?>
                                        <span><?php esc_html_e( 'by ', 'nictiz-toolkit' ); ?><a href="<?php echo esc_url( $post_author_link ); ?>"><?php echo esc_html( $post_author_name ); ?></a></span>
                                    <?php endif; ?>
                                    <?php if ( 1 === intval( $enable_date ) ) : ?>
                                        <span><?php esc_html_e( 'on ', 'nictiz-toolkit' ); ?><?php echo esc_html( get_the_date( get_option('dat_format') ) ); ?></span>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endwhile; wp_reset_postdata();?>
                    </ul>
                <?php endif; ?>
            </div>
        <?php
		echo wp_kses_post( $after_widget );
	}
}