<?php
add_filter('nictiz_toolkit_get_elements', 'nictiz_toolkit_register_elements_button');


function nictiz_toolkit_register_elements_button($groups){
    $groups['button'][] = array(
        'name' => esc_html__('Button','nictiz-toolkit'),
        'code' => '[button style="1" href="#" target="_blank" ]Button[/button]'
        );
    return $groups;
}

add_shortcode('button', 'nictiz_toolkit_shortcode_button');

function nictiz_toolkit_shortcode_button($atts, $content = null){
    extract(shortcode_atts(array(
        'style' => 1,
        'href' => '',
        'target' => '_blank',
        
        ), $atts));
    
    
    $classes = apply_filters('nictiz_toolkit_button_classes',array('read-more'));
    switch((int)$atts['style']){
        case 1:
            $classes[] = 'read-more-border read-more-arrow';
            break;
        case 2:
            $classes[] = '';
            break;
        case 3:
            $classes[] = 'read-more-border';
            break;
        default:
            $classes[] = 'read-more-border read-more-arrow';
            break;
    }
    
    ob_start();
    ?>
    <a href="<?php echo esc_attr($atts['href']); ?>" class="<?php echo esc_attr(implode(' ', $classes)); ?>" target="<?php echo esc_attr($atts['target']); ?>"><?php echo esc_html($content); ?></a>
    <?php
    $string = ob_get_contents();
    ob_end_clean();
    
    return apply_filters( 'nictiz_toolkit_buttons', $string, $atts, $content );
}