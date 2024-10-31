<?php

add_filter('nictiz_toolkit_get_elements', 'nictiz_toolkit_register_elements_blockquote_style3');

function nictiz_toolkit_register_elements_blockquote_style3($groups){
    $groups['blockquote'][] = array(
        'name' => esc_html__('Blockquote 3','nictiz-toolkit'),
        'code' => '[nictiz_toolkit_blockquote style="3" author=""]Blockquote Content[/nictiz_toolkit_blockquote]'
        );
    return $groups;
}

add_filter('nictiz_toolkit_shortcode_blockquote_classes', 'nictiz_toolkit_shortcode_blockquote_style3',10 ,2 );

function nictiz_toolkit_shortcode_blockquote_style3( $tab_classes, $style_id){
    
    if(3 === (int)$style_id ){
        $tab_classes = 'style-3';
    }
    
    return $tab_classes;
}

