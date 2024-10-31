<?php

add_action( 'widgets_init', array( 'Nictiz_Toolkit_Widget_About_Site', 'register_widget' ) );

class Nictiz_Toolkit_Widget_About_Site extends Kopa_Widget {

    public $kpb_group = 'other';

    public static function register_widget() {
        register_widget( 'Nictiz_Toolkit_Widget_About_Site');
    }

    public function __construct() {
        $this->widget_cssclass    = ' widget_text';
        $this->widget_description = esc_html__( 'Show about the site.', 'nictiz-toolkit' );
        $this->widget_id          = 'nictitate_toolkit_ii-about-site';
        $this->widget_name        = esc_html__( '__About Site', 'nictiz-toolkit' );

        $this->settings 		  = array(
        	'title'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Title:', 'nictiz-toolkit' )
            ),
            'des_site'  => array(
                'type'  => 'textarea',
                'std'   => '',
                'label' => esc_html__( 'Description the site:', 'nictiz-toolkit' )
            )
        );

        parent::__construct();
    }

    public function widget( $args, $instance ) {
        ob_start();
        $instance = wp_parse_args( (array) $instance, $this->get_default_instance() );
        extract( $instance );
        extract( $args );
        echo $before_widget;
        if ( ! empty($title) ): ?>
        	<h2 class="widget-title"><?php echo esc_attr( $title ); ?></h2>
       	<?php endif; ?>

       	<div class="textwidget">
           	<?php if( ! empty( $des_site ) ) : ?>
              	<?php echo esc_html( $des_site ); ?>
           	<?php endif; ?>
            <?php
            $nictiz_toolkit_socials = nictiz_get_socials();
            $social_links = array();
            foreach ( $nictiz_toolkit_socials as $social ) {
                $social_links[$social['id']] = get_theme_mod( 'social_share_'.$social['id'] );
            }
            $rss_link = array();
            $temp     = each( $social_links );
            $rss_link[ $temp['key'] ] = $temp['value'];
            $social_links = array_diff( $social_links, $rss_link );
            if ( ( array_filter($social_links) ) || ( 'HIDE' != $rss_link['rss'] ) ) :  ?>
                <div class="list-social-2">
                    <?php if ( 'HIDE' != $rss_link['rss'] ) :  ?>
                        <?php if ( '' != $rss_link['rss'] ) :  ?>
                            <a class="fa fa-rss" href="<?php echo esc_url( $rss_link['rss'] ); ?>" target="__blank"></a>
                        <?php else : ?>
                            <a class="fa fa-rss" href="<?php bloginfo( 'rss2_url' ); ?>" target="__blank"></a>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php
                    if( array_filter($social_links) ):
                        foreach( $social_links as $key => $social_link ): ?>
                            <a class="fa fa-<?php echo esc_attr($key); ?>" href="<?php echo esc_url( $social_link ); ?>" target="__blank"></a>     
                    <?php
                        endforeach; 
                    endif; ?>
                </div>  
            <?php endif; ?> 
       	</div>
        <?php echo $after_widget;
        $content = ob_get_clean();
        echo $content;
    }
}