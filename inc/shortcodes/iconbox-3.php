<?php
add_filter('nictiz_toolkit_get_elements', 'nictiz_toolkit_register_elements_iconbox_style3');

function nictiz_toolkit_register_elements_iconbox_style3($groups){
    $groups['iconbox'][] = array(
        'name' => esc_html__('Icon box 3','nictiz-toolkit'),
        'code' => '[nictiz_toolkit_iconbox style="3" icon="fa fa-picture-o" title=""]Content[/nictiz_toolkit_iconbox]'
        );
    return $groups;
}

add_filter('nictiz_toolkit_shortcode_iconbox_classes', 'nictiz_toolkit_shortcode_iconbox_style3',10 ,2 );

function nictiz_toolkit_shortcode_iconbox_style3( $tab_classes, $style_id){
    
    if(3 === $style_id ){
        $tab_classes = 'style-3';
    }
    
    return $tab_classes;
}


add_action('nictiz_toolkit_iconbox_shortcode', 'nictiz_toolkit_display_iconbox_style3', 10, 3);
function nictiz_toolkit_display_iconbox_style3($atts, $style_id, $content){
    extract( shortcode_atts( array('style'=> 3, 'icon' => ''), $atts ) );
    if(3 === (int)$style_id){
        if($atts['icon']){
            ?>
            <i class="icon <?php echo esc_attr($atts['icon']); ?>"></i>
            <?php
        }
        if($atts['title']){
            ?>
            <h3><?php echo wp_kses_post($atts['title']); ?></h3>
            <?php
        } 
        echo '<p>'.do_shortcode($content).'</p>';
    }
}
