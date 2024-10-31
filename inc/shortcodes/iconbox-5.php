<?php
add_filter('nictiz_toolkit_get_elements', 'nictiz_toolkit_register_elements_iconbox_style5');

function nictiz_toolkit_register_elements_iconbox_style5($groups){
    $groups['iconbox'][] = array(
        'name' => esc_html__('Icon box 5','nictiz-toolkit'),
        'code' => '[nictiz_toolkit_iconbox style="5" position="right" icon="fa fa-picture-o" title=""]Content[/nictiz_toolkit_iconbox]'
        );
    return $groups;
}

add_filter('nictiz_toolkit_shortcode_iconbox_classes', 'nictiz_toolkit_shortcode_iconbox_style5',10 ,2 );

function nictiz_toolkit_shortcode_iconbox_style5( $tab_classes, $style_id){
    
    if(5 === (int)$style_id ){
        $tab_classes = 'style-5';
    }
    
    return $tab_classes;
}


add_action('nictiz_toolkit_iconbox_shortcode', 'nictiz_toolkit_display_iconbox_style5', 10, 3);
function nictiz_toolkit_display_iconbox_style5($atts, $style_id, $content){
    extract( shortcode_atts( array('style'=> 5, 'icon' => ''), $atts ) );
    if(5 === (int)$style_id){
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
