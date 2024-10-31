<?php
add_filter('nictiz_toolkit_get_elements', 'nictiz_toolkit_register_elements_dropcaps_style2');


function nictiz_toolkit_register_elements_dropcaps_style2($groups){
	$groups['dropcaps'][] = array(
		'name' => esc_html__('Dropcaps 2','nictiz-toolkit'),
		'code' => '[dropcaps style="2"]A[/dropcaps]'
		);
	return $groups;
}
add_filter('nictiz_toolkit_shortcode_dropcaps_classes', 'nictiz_toolkit_shortcode_dropcaps_style2',10 ,2 );

function nictiz_toolkit_shortcode_dropcaps_style2( $tab_classes, $style_id){
    
    if(2 === $style_id ){
        $tab_classes = 'style-2';
    }
    
    return $tab_classes;
}