<?php
add_filter('nictiz_toolkit_get_elements', 'nictiz_toolkit_register_elements_dropcaps');


function nictiz_toolkit_register_elements_dropcaps($groups){
	$groups['dropcaps'][] = array(
		'name' => esc_html__('Dropcaps 1','nictiz-toolkit'),
		'code' => '[dropcaps style="1"]A[/dropcaps]'
		);
	return $groups;
}

add_shortcode( 'dropcaps', 'nictiz_toolkit_shortcode_dropcap' );

function nictiz_toolkit_shortcode_dropcap( $atts, $content ) {
	
	extract( shortcode_atts( array('style' => 1), $atts ) );

	$style_id = isset($atts['style']) ? (int)$atts['style'] : 1 ; 
    
    $tab_classes = apply_filters('nictiz_toolkit_shortcode_dropcaps_classes', '', $style_id );

	$split = str_split( $content );
	$first = $split[0];
	$span  = '<span class="k-dropcap ' . $tab_classes . '">' . strtoupper( $first ) . '</span>';
	$c     = substr( $content, 1 );

	if ( $first === '[' || $first === '<' ) {
		$span = NULL;
		$c = $content;
	}
	
	$string = '<p>' . $span . do_shortcode( trim( $c ) ) . '</p>';

	return apply_filters( 'nictiz_toolkit_shortcode_dropcap', $string, $atts, $content );
}
