<?php
add_action( 'kpb_get_widgets_list', array( 'Nictiz_Toolkit_Widget_Tagline_Button', 'register_block' ) );

class Nictiz_Toolkit_Widget_Tagline_Button extends Kopa_Widget {

    public $kpb_group = 'other';

    public static function register_block( $blocks ) {
        $blocks['Nictiz_Toolkit_Widget_Tagline_Button'] = new Nictiz_Toolkit_Widget_Tagline_Button();
        return $blocks;
    }

    public function __construct() {
        $this->widget_cssclass    = 'k-widget-text bg-img';
        $this->widget_description = esc_html__( 'Show tagline and button', 'nictiz-toolkit' );
        $this->widget_id          = 'nictitate_toolkit_ii-tagline';
        $this->widget_name        = esc_html__( '__Tagline', 'nictiz-toolkit' );

        $this->settings 		  = array(
        	'title'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Title:', 'nictiz-toolkit' )
            ),
            'button_text'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Button Text:', 'nictiz-toolkit' )
            ),
            'button_url'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Button URL:', 'nictiz-toolkit' )
            )
        );

        parent::__construct();
    }

    public function widget( $args, $instance ) {
        extract( $instance );
        extract( $args );
        echo wp_kses_post( $before_widget );
        if ( ! empty( $title ) )
            echo wp_kses_post( $before_title.$title.$after_title );
        if ( $button_url && $button_text) {
            echo '<div class="widget-content col-md-6 col-xs-12 col-md-offset-3">';
            echo '<a href="'.wp_kses_post( $button_url ).'" class="read-more read-more-border">'.wp_kses_post( $button_text ).'</a>';
            echo '</div>';
        }

        echo wp_kses_post( $after_widget );
    }
}