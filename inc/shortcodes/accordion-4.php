<?php
add_filter('nictiz_toolkit_get_elements', 'nictiz_toolkit_register_elements_accordion_style4');


function nictiz_toolkit_register_elements_accordion_style4($groups){
	$groups['accordions'][] = array(
		'name' => esc_html__('Accordion 4','nictiz-toolkit'),
		'code' => '[accordions style="4" is_toggle="0"]<br/>[accordion title="Accordion title 1"]Accordion content 1[/accordion]<br/>[accordion title="Accordion title 2"]Accordion content 2[/accordion]<br/>[accordion title="Accordion title 3"]Accordion content 3[/accordion]<br/>[/accordions]'
		);
	return $groups;
}


add_filter('nictiz_toolkit_shortcode_accordions_classes', 'nictiz_toolkit_shortcode_accordions_style4',10 ,2 );

function nictiz_toolkit_shortcode_accordions_style4( $tab_classes, $style_id){
	
	if(4 === $style_id ){
		$tab_classes = 'style-4';
	}
	
	return $tab_classes;
}





