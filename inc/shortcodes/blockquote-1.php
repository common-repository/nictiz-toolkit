<?php

add_filter('nictiz_toolkit_get_elements', 'nictiz_toolkit_register_elements_blockquote');

function nictiz_toolkit_register_elements_blockquote($groups){
    $groups['blockquote'][] = array(
        'name' => esc_html__('Blockquote 1','nictiz-toolkit'),
        'code' => '[nictiz_toolkit_blockquote style="1" author=""]Blockquote Content[/nictiz_toolkit_blockquote]'
        );
    return $groups;
}

add_shortcode('nictiz_toolkit_blockquote', 'nictiz_toolkit_blockquote');

function nictiz_toolkit_blockquote($atts, $content = null) {
    
    extract( shortcode_atts( array('style'=> 1, 'author' => ''), $atts ) );
    $style_id = isset($atts['style']) ? (int)$atts['style'] : 0 ; 

    $tab_classes = apply_filters('nictiz_toolkit_shortcode_blockquote_classes', 'style-1', $style_id );

    $html = '';

    $inline_css = '';
    if(!empty($atts['background_image'])){
        $inline_css = 'style="background-image:url('.$atts['background_image'].'); background-image-repeat:no-repeat;"';
    }

    if (!empty($content)) {
        $html .= '<blockquote class="k-blockquote '.$tab_classes.'" '.$inline_css.'>';
        if(!empty($atts['background_image'])){
            $html .= '<span class="nictiz_toolkit_bg_custom"><span>';
        }
        $html .= '<p>'. $content . '</p>';
        if(isset($atts['author'])){
            $html .= ( 3 == (int)$style_id ) ? '<p class="text-right">' : '';
            $html .= '<small>'. $atts['author'] . '</small>';
            $html .= ( 3 == (int)$style_id ) ? '</p>' : '';
        }
        $html .= '</blockquote>';
    }

    return apply_filters('nictiz_toolkit_blockquote', force_balance_tags($html), $atts, $content);
}
