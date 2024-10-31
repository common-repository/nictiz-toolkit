<?php

add_filter('nictiz_toolkit_get_elements', 'nictiz_toolkit_register_elements_iconbox');



function nictiz_toolkit_register_elements_iconbox($groups){
    $groups['iconbox'][] = array(
        'name' => esc_html__('Icon box 1','nictiz-toolkit'),
        'code' => '[nictiz_toolkit_iconbox style="1" icon="fa fa-picture-o" title=""]Content[/nictiz_toolkit_iconbox]'
        );
    return $groups;
}

add_shortcode('nictiz_toolkit_iconbox', 'nictiz_toolkit_iconbox');

function nictiz_toolkit_iconbox($atts, $content = null) {
    
    extract( shortcode_atts( array('style'=> 1, 'icon' => ''), $atts ) );
    $style_id = isset($atts['style']) ? (int)$atts['style'] : 0 ; 
    

    $tab_classes = apply_filters('nictiz_toolkit_shortcode_iconbox_classes', 'style-1', $style_id );

    $icon_position = '';
    if(isset($atts['position'])){
        $icon_position = ' icon-box-'.$atts['position'];
    }

    ob_start();

    
        ?>
        <div class="icon-box <?php echo esc_attr($tab_classes . $icon_position); ?>">
            <?php 
            if(1 === (int)$style_id){
             ?>
            <div class="clearfix">
                <?php if($atts['icon']){
                    ?>
                    <i class="icon <?php echo esc_attr($atts['icon']); ?>"></i>
                    <?php
                } ?>
                <?php if($atts['title']){
                    ?>
                    <h3><?php echo wp_kses_post($atts['title']); ?></h3>
                    <?php
                } ?>
            </div>
            <p><?php echo do_shortcode($content); ?></p>
            <?php 
            }else{
                do_action('nictiz_toolkit_iconbox_shortcode', $atts, $style_id, $content);
            }
             ?>
        </div>
        <?php
    
    
    $html = ob_get_contents();
    ob_end_clean();

    return apply_filters('nictiz_toolkit_iconbox', force_balance_tags($html), $atts, $content);
}
