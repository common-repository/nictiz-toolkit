<?php
add_filter('nictiz_toolkit_get_elements', 'nictiz_toolkit_register_elements_tabs_style2');


function nictiz_toolkit_register_elements_tabs_style2($groups){
	$groups['tabs'][] = array(
		'name' => esc_html__('Tab 2','nictiz-toolkit'),
		'code' => '[tabs style="2"]<br/>[tab title="Tab title 1"]Tab Content 1[/tab]<br/>[tab title="Tab title 2"]Tab Content 2[/tab]<br/>[tab title="Tab title 3"]Tab Content 3[/tab]<br/>[/tabs]'
		);
	return $groups;
}

add_filter('nictiz_toolkit_shortcode_tabs_classes', 'nictiz_toolkit_shortcode_tabs_style2',10 ,2 );

function nictiz_toolkit_shortcode_tabs_style2( $tab_classes, $style_id){
	
	if(2 === $style_id ){
		$tab_classes = 'style-2';
	}
	
	return $tab_classes;
}