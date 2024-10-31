<?php
add_filter( 'kpb_get_widgets_list', array( 'Nictiz_Toolkit_Widget_Google_Map', 'register_block' ) );
add_filter( 'nictitate_get_map_class_name', array('Nictiz_Toolkit_Widget_Google_Map', 'set_map_class_name') );

class Nictiz_Toolkit_Widget_Google_Map extends Kopa_Widget {

    public $kpb_group = 'contact';

    public static function register_block( $blocks ) {
        $blocks['Nictiz_Toolkit_Widget_Google_Map'] = new Nictiz_Toolkit_Widget_Google_Map();
        return $blocks;
    }

    public static function set_map_class_name( $class_names ) {
        array_push( $class_names, 'Nictiz_Toolkit_Widget_Google_Map' );
        return $class_names;
    }

	public function __construct() {
		$this->widget_cssclass    = 'k-widget-map k-widget has-header has-icon-header';
		$this->widget_description = esc_html__( 'Display your google map.', 'nictiz-toolkit' );
		$this->widget_id          = 'nictitate-toolkit-google-map';
		$this->widget_name        = esc_html__( '__Google Map', 'nictiz-toolkit' );
		$this->settings 		  = array(
			'title'  => array(         
				'type'  => 'text',
				'std'   => '',
				'label' => esc_html__( 'Title', 'nictiz-toolkit' )
			),            
            'latitude'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__('Latitude', 'nictiz-toolkit')
            ),
			'longtitude'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__('Longtitude', 'nictiz-toolkit')
            ),
            'location'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__('Location', 'nictiz-toolkit')
            ),		            
            'height'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__('Height', 'nictiz-toolkit')
            )
		);	

		parent::__construct();
	}

	public function widget( $args, $instance ) {
		ob_start();
		extract( $args );
        $instance = wp_parse_args( (array) $instance, $this->get_default_instance() );
        extract( $instance );
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
		echo wp_kses_post( $before_widget );

		if ( $title )
			echo wp_kses_post ( $before_title . $title .$after_title );	
        
        if ( ! empty( $latitude ) && ! empty( $longtitude ) ):   
            $style = ( $height ) ? "height: {$height};" : '';
            $map_id = 'kopa-map-' . wp_generate_password( 4, false, false );
            ?> 
            <div class="widget-content">           
                <div id="<?php echo esc_attr( $map_id ); ?>" 
                    style="<?php echo esc_attr( $style ); ?>"
                    class="k-map"                    
                    data-latitude="<?php echo esc_attr( $latitude ); ?>" 
                    data-longtitude="<?php echo esc_attr( $longtitude ); ?>"
                    data-location="<?php echo esc_attr( $location ); ?>"></div>
            </div>            
            <?php             
        endif;            
		echo wp_kses_post( $after_widget );	
	}
}