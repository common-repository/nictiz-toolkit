<?php
require_once NICTIZ_TOOLKIT_PATH . 'inc/post-types/contact/widgets/mailchimp-api/inc/mailchimp.php';

add_action( 'widgets_init', array( 'Nictiz_Toolkit_Widget_Subscribe', 'register_widget' ) );
class Nictiz_Toolkit_Widget_Subscribe extends Kopa_Widget {

	public $kpb_group = 'contact';

	public static function register_widget() {
		register_widget( 'Nictiz_Toolkit_Widget_Subscribe' );
	}

	public function __construct() {
		$this->widget_cssclass    = 'k-widget-newsletter-2 has-header has-background ';
		$this->widget_description = esc_html__( 'Display mailchimp newsletter subscription form.', 'nictiz-toolkit' );
		$this->widget_id          = 'nictitate-toolkit-ii-widget-subscrible';
		$this->widget_name        = esc_html__( '__Mailchimp Subscribe 2', 'nictiz-toolkit' );
		
		$this->settings           = array(			
			'title'  => array(
				'type'  => 'text',
				'std'   => '',
				'label' => esc_html__( 'Title:', 'nictiz-toolkit')
			),
			'desc'  => array(
				'type'  => 'textarea',
				'std'   => '',
				'label' => esc_html__( 'Description:', 'nictiz-toolkit')
			),
            'placeholder'  => array(
                'type'  => 'text',
                'std'   => esc_html__('Enter your email', 'nictiz-toolkit'),
                'label' => esc_html__( 'Placeholder text:', 'nictiz-toolkit' )
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
		extract( $args );
		$instance = wp_parse_args( (array) $instance, $this->get_default_instance() );
		extract( $instance );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

        #Encrypt data
		$list_id_e = nictitate_toolkit_encrypt_decrypt( 'encrypt', $list_id );
		$api_key_e = nictitate_toolkit_encrypt_decrypt( 'encrypt', $api_key );
		$nonce     = nictitate_toolkit_encrypt_decrypt( 'encrypt', wp_create_nonce( 'nictitate_toolkit_mailchimp' ) );

		echo wp_kses_post( $before_widget );
		if ( $title )
			echo wp_kses_post( $before_title . $title .$after_title );
		?>
			<div class="row">
	            <div class="col-md-8 col-md-offset-2">
	                <?php if ( $desc ) {
	                		echo '<p class="widget-des-2">'.wp_kses_post( $desc ).'</p>';
	                	}
	                ?>
	            </div>
	            <div class="col-md-6 col-md-offset-3">
                    <form class="mailchimp-form" action="#" method="post" data-nonce="<?php echo esc_attr( $nonce ); ?>" data-list-id="<?php echo esc_attr( $list_id_e ); ?>" data-api-key="<?php echo esc_attr( $api_key_e ); ?>">
                        <input type="text" placeholder="<?php echo esc_attr( $placeholder ); ?>" class="form-control" name="email">
                            <button type="submit" class="fa fa-envelope-o"></button>
                            <span class="response"></span>
                    </form>
	            </div>
	        </div>
		<?php
		echo  wp_kses_post( $after_widget );
	}
}