<?php
add_filter('nictiz_toolkit_get_elements', 'nictiz_toolkit_caption_register_elements');


function nictiz_toolkit_caption_register_elements($groups){
	$groups['captions'][] = array(
		'name' => esc_html__('Captions 1','nictiz-toolkit'),
		'code' => '[nictiz_toolkit_captions style="1"]Content[/nictiz_toolkit_captions]'
		);
	$groups['captions'][] = array(
		'name' => esc_html__('Captions 2','nictiz-toolkit'),
		'code' => '[nictiz_toolkit_captions style="2"]Content[/nictiz_toolkit_captions]'
		);
	return $groups;
}

add_shortcode( 'nictiz_toolkit_captions', 'nictiz_toolkit_caption_shortcode' );

function nictiz_toolkit_caption_shortcode( $atts, $content ) {
	
	extract( shortcode_atts( array('style' => 1), $atts ) );

	$style_id = isset($atts['style']) ? (int)$atts['style'] : 0 ; 
    
    
	$string = '';
	if(1 === (int) $style_id){
		$string .= '<h4 class="box-title">'.$content.'</h4>';
	} else {
		$string .= '<h3 class="widget-title">'.$content.'</h3>';
	}
	
	

	return apply_filters( 'nictiz_toolkit_shortcode_captions', $string, $atts, $content );
}
