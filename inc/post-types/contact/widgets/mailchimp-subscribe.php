<?php
require_once NICTIZ_TOOLKIT_PATH . 'inc/post-types/contact/widgets/mailchimp-api/inc/mailchimp.php';

add_action( 'widgets_init', array( 'Nictiz_Toolkit_Widget_Mailchimp_Subscribe', 'register_widget' ) );
class Nictiz_Toolkit_Widget_Mailchimp_Subscribe extends Kopa_Widget {

    public $kpb_group = 'contact';

    public static function register_widget() {
        register_widget( 'Nictiz_Toolkit_Widget_Mailchimp_Subscribe' );
    }

    public function __construct() {
        $this->widget_cssclass    = 'nictitate_toolkit_ii_mailchimp_subscribe k-widget-newsletter';
        $this->widget_description = esc_html__( 'Display mailchimp newsletter subscription form.', 'nictiz-toolkit' );
        $this->widget_id          = 'nictitate_toolkit_ii-mailchimp-subscribe';
        $this->widget_name        = esc_html__( '__Mailchimp Subscribe', 'nictiz-toolkit' );

        $this->settings 		  = array(
            'title'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Title:', 'nictiz-toolkit' )
            ),
            'placeholder'  => array(
                'type'  => 'text',
                'std'   => esc_html__('Enter your email', 'nictiz-toolkit'),
                'label' => esc_html__( 'Placeholder text:', 'nictiz-toolkit' )
            ),
            'submit_btn_text'  => array(
                'type'  => 'text',
                'std'   => esc_html__('Subscribe', 'nictiz-toolkit'),
                'label' => esc_html__( 'Submit button text:', 'nictiz-toolkit' )
            ),
            'description'  => array(
                'type'  => 'textarea',
                'std'   => '',
                'label' => esc_html__( 'Description:', 'nictiz-toolkit' )
            ),
            'list_id'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'List ID:', 'nictiz-toolkit' ),
                'desc' => wp_kses_post('Get your List Id by go to <a href="//us8.admin.mailchimp.com/lists/" target="_blank">link</a>. Then choose List name and default.', '')
            ),
            'api_key'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Your API Key:', 'nictiz-toolkit' ),
                'desc' => wp_kses_post('Get an API Key by going to <a href="//us8.admin.mailchimp.com/account/api/" target="_blank">link</a>.', 'nictiz-toolkit')
            )
        );

        parent::__construct();
    }

    public function widget( $args, $instance ) {
        ob_start();
        $instance = wp_parse_args( (array) $instance, $this->get_default_instance() );
        extract( $instance );
        extract( $args );

        #Encrypt data
        $list_id_e = nictitate_toolkit_encrypt_decrypt( 'encrypt', $list_id );
        $api_key_e = nictitate_toolkit_encrypt_decrypt( 'encrypt', $api_key );
        $nonce     = nictitate_toolkit_encrypt_decrypt( 'encrypt', wp_create_nonce( 'nictitate_toolkit_mailchimp' ));

        echo wp_kses_post( $before_widget );
            if ( ! empty( $title ) ) : ?>
                <h3 class="widget-title"><?php echo esc_html( $title ); ?></h3>
            <?php endif; ?>

            <form class="mailchimp-form" action="#" method="post" data-nonce="<?php echo esc_attr( $nonce ); ?>" data-list-id="<?php echo esc_attr( $list_id_e ); ?>" data-api-key="<?php echo esc_attr( $api_key_e ); ?>">
                <input type="text" placeholder="<?php echo esc_attr( $placeholder ); ?>" class="form-control" name="email">
                <input type="submit" value="<?php echo esc_attr( $submit_btn_text ); ?>">
                <span class="response"></span>
            </form>
            <?php if ( ! empty( $instance['description'] ) ) : ?>
                <p class="form-info"><i class="fa fa-info-circle"></i> <?php echo wp_kses_post( $instance['description'] ); ?></p>
            <?php endif; ?>
        <?php echo wp_kses_post ( $after_widget );
    }
}