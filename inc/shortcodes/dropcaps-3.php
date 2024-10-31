<?php
add_filter('nictiz_toolkit_get_elements', 'nictiz_toolkit_register_elements_dropcaps_style3');


function nictiz_toolkit_register_elements_dropcaps_style3($groups){
	$groups['dropcaps'][] = array(
		'name' => esc_html__('Dropcaps 3','nictiz-toolkit'),
		'code' => '[dropcaps style="3"]A[/dropcaps]'
		);
	return $groups;
}
add_filter('nictiz_toolkit_shortcode_dropcaps_classes', 'nictiz_toolkit_shortcode_dropcaps_style3',10 ,2 );

function nictiz_toolkit_shortcode_dropcaps_style3( $tab_classes, $style_id){
    
    if(3 === $style_id ){
        $tab_classes = 'style-3';
    }
    
    return $tab_classes;
}