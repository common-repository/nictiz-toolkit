<?php
add_filter('nictiz_toolkit_get_elements', 'nictiz_toolkit_register_elements_tabs_style3');


function nictiz_toolkit_register_elements_tabs_style3($groups){
	$groups['tabs'][] = array(
		'name' => esc_html__('Tab 3','nictiz-toolkit'),
		'code' => '[tabs style="3"]<br/>[tab title="Tab title 1" title_icon="fa fa-home"]Tab Content 1[/tab]<br/>[tab title="Tab title 2" title_icon="fa fa-home"]Tab Content 2[/tab]<br/>[tab title="Tab title 3" title_icon="fa fa-home"]Tab Content 3[/tab]<br/>[/tabs]'
		);
	return $groups;
}

add_filter('nictiz_toolkit_shortcode_tabs_classes', 'nictiz_toolkit_shortcode_tabs_style3',10 ,2 );

function nictiz_toolkit_shortcode_tabs_style3( $tab_classes, $style_id){
	
	if(3 === $style_id ){
		$tab_classes = 'style-3';
	}
	
	return $tab_classes;
}
