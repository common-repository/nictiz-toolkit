<?php
add_action( 'widgets_init', array( 'Nictiz_Toolkit_Widget_Contact_Info', 'register_widget' ) );

class Nictiz_Toolkit_Widget_Contact_Info extends Kopa_Widget {

    public $kpb_group = 'contact';

    public static function register_widget() {
        register_widget( 'Nictiz_Toolkit_Widget_Contact_Info' );
    }

    public function __construct() {
        $this->widget_cssclass    = 'nictitate_toolkit_ii_contact_info k-widget-info';
        $this->widget_description = esc_html__( 'Display your company contact information.', 'nictiz-toolkit' );
        $this->widget_id          = 'nictitate_toolkit_ii-contact-info';
        $this->widget_name        = esc_html__( '__Contact Information', 'nictiz-toolkit' );

        $this->settings 		  = array(
            'title'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Title:', 'nictiz-toolkit' )
            ),
            'phone'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Phone:', 'nictiz-toolkit' )
            ),
            'fax'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Fax:', 'nictiz-toolkit' )
            ),
            'email'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Email:', 'nictiz-toolkit' )
            ),
            'address'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Address:', 'nictiz-toolkit' )
            ),
            'enable_follow'  => array(
                'type'  => 'checkbox',
                'std'   => 1,
                'label' => esc_html__( 'Show social follow:', 'nictiz-toolkit' ),
                'desc'  => wp_kses_post('Setting in <code>Theme Options -> Social Share</code>', 'nictiz-toolkit')
            )
        );

        parent::__construct();
    }

    public function widget( $args, $instance ) {
        extract( $args );
        $instance = wp_parse_args( (array) $instance, $this->get_default_instance() );
        extract( $instance ); 
        echo wp_kses_post( $before_widget );
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        
        if ( $title ) {
            echo wp_kses_post( $before_title . $title .$after_title );
        }    
        ?>
            <div class="widget-content">
                <?php if ( ! empty( $phone ) || ! empty( $fax ) || ! empty( $email ) || ! empty( $address ) ) : ?>
                    <ul class="list-info list-unstyled">
                        <?php if ( ! empty( $phone ) ) : ?>
                            <li><i class="fa fa-phone"></i> <?php echo esc_html( $phone ); ?></li>
                        <?php endif; ?>
                        <?php if ( ! empty( $fax ) ) : ?>
                            <li><i class="fa fa-print"></i> <?php echo esc_html( $fax ); ?></li>
                        <?php endif; ?>
                        <?php if ( ! empty( $email ) ) : ?>
                            <li><i class="fa fa-envelope-o"></i> <?php echo esc_html( $email ); ?></li>
                        <?php endif; ?>
                        <?php if ( ! empty( $address ) ): ?>
                            <li><i class="fa fa-map-marker"></i> <?php echo esc_html( $address ); ?></li>
                        <?php endif; ?>
                    </ul>
                <?php
                endif;
                    if ( 1 === intval( $enable_follow ) ) {
                        get_template_part('template/header/parts/social-follow');
                    }
                ?>
            </div>
        <?php 
        echo wp_kses_post( $after_widget );        
    }
}