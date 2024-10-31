<?php

add_filter('nictiz_toolkit_get_elements', 'nictiz_toolkit_register_elements_progressbar');


function nictiz_toolkit_register_elements_progressbar($groups){
    $groups['progressbar'][] = array(
        'name' => esc_html__('Progress Bar','nictiz-toolkit'),
        'code' => '[nictiz_toolkit_progress percent=""]Content[/nictiz_toolkit_progress]'
        );
    return $groups;
}

add_shortcode('nictiz_toolkit_progress', 'nictiz_toolkit_progress');

function nictiz_toolkit_progress($atts, $content = null) {
    
    extract( shortcode_atts( array(), $atts ) );
    
    $html = '';

    if (!empty($content)) {
        if( $atts['percent'] > 100){
            $atts['percent'] = 100;
        }else{
            $atts['percent'] = $atts['percent'];
        }
        $html .= '<div class="k-progress ">';
        
        $html .= '<h4 class="progress-title">'. $content . '</h4>';
        if(isset($atts['percent'])){
            $html .= '<div class="progress">';
            $html .= '<div class="progress-bar" role="progressbar" aria-valuenow="'.$atts['percent'].'" aria-valuemin="0" aria-valuemax="100" style="width: 0%"><span><i id="progress-number-'.rand().'" data-number="'.$atts['percent'].'">0</i>%</span></div>';
            $html .= '</div>';
        }
        $html .= '</div>';
    }

    return apply_filters('nictiz_toolkit_progress', force_balance_tags($html), $atts, $content);
}
