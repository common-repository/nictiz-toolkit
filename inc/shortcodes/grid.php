<?php
add_filter('nictiz_toolkit_get_elements', 'nictiz_toolkit_register_elements_grid');

function nictiz_toolkit_register_elements_grid($groups){
    
    $groups['grid'][] = array(
        'name' => esc_html__('Grid 100%','nictiz-toolkit'),
        'code' => '[nictiz_toolkit_grid_row]<br/>[nictiz_toolkit_grid_col col=12]TEXT[/nictiz_toolkit_grid_col]<br/>[/nictiz_toolkit_grid_row]<br/>'
        );
    $groups['grid'][] = array(
        'name' => esc_html__('Grid 50% x2','nictiz-toolkit'),
        'code' => '[nictiz_toolkit_grid_row]<br/>[nictiz_toolkit_grid_col col=6]TEXT[/nictiz_toolkit_grid_col]<br/>[nictiz_toolkit_grid_col col=6]TEXT[/nictiz_toolkit_grid_col]<br/>[/nictiz_toolkit_grid_row]<br/>'
        );
    $groups['grid'][] = array(
        'name' => esc_html__('Grid 33% x3','nictiz-toolkit'),
        'code' => '[nictiz_toolkit_grid_row]<br/>[nictiz_toolkit_grid_col col=4]TEXT[/nictiz_toolkit_grid_col]<br/>[nictiz_toolkit_grid_col col=4]TEXT[/nictiz_toolkit_grid_col]<br/>[nictiz_toolkit_grid_col col=4]TEXT[/nictiz_toolkit_grid_col]<br/>[/nictiz_toolkit_grid_row]<br/>'
        );
    $groups['grid'][] = array(
        'name' => esc_html__('Grid 33% - 66%','nictiz-toolkit'),
        'code' => '[nictiz_toolkit_grid_row]<br/>[nictiz_toolkit_grid_col col=4]TEXT[/nictiz_toolkit_grid_col]<br/>[nictiz_toolkit_grid_col col=8]TEXT[/nictiz_toolkit_grid_col]<br/>[/nictiz_toolkit_grid_row]<br/>'
        );
    $groups['grid'][] = array(
        'name' => esc_html__('Grid 25% - 50% - 25%','nictiz-toolkit'),
        'code' => '[nictiz_toolkit_grid_row]<br/>[nictiz_toolkit_grid_col col=3]TEXT[/nictiz_toolkit_grid_col]<br/>[nictiz_toolkit_grid_col col=6]TEXT[/nictiz_toolkit_grid_col]<br/>[nictiz_toolkit_grid_col col=3]TEXT[/nictiz_toolkit_grid_col]<br/>[/nictiz_toolkit_grid_row]<br/>'
        );
    $groups['grid'][] = array(
        'name' => esc_html__('Grid 25% x4','nictiz-toolkit'),
        'code' => '[nictiz_toolkit_grid_row]<br/>[nictiz_toolkit_grid_col col=3]TEXT[/nictiz_toolkit_grid_col]<br/>[nictiz_toolkit_grid_col col=3]TEXT[/nictiz_toolkit_grid_col]<br/>[nictiz_toolkit_grid_col col=3]TEXT[/nictiz_toolkit_grid_col]<br/>[nictiz_toolkit_grid_col col=3]TEXT[/nictiz_toolkit_grid_col]<br/>[/nictiz_toolkit_grid_row]<br/>'
        );
    $groups['grid'][] = array(
        'name' => esc_html__('Grid 25% - 75%','nictiz-toolkit'),
        'code' => '[nictiz_toolkit_grid_row]<br/>[nictiz_toolkit_grid_col col=3]TEXT[/nictiz_toolkit_grid_col]<br/>[nictiz_toolkit_grid_col col=9]TEXT[/nictiz_toolkit_grid_col]<br/>[/nictiz_toolkit_grid_row]<br/>'
        );
    $groups['grid'][] = array(
        'name' => esc_html__('Grid 16.6% - 66.6% - 16.6%','nictiz-toolkit'),
        'code' => '[nictiz_toolkit_grid_row]<br/>[nictiz_toolkit_grid_col col=2]TEXT[/nictiz_toolkit_grid_col]<br/>[nictiz_toolkit_grid_col col=8]TEXT[/nictiz_toolkit_grid_col]<br/>[nictiz_toolkit_grid_col col=2]TEXT[/nictiz_toolkit_grid_col]<br/>[/nictiz_toolkit_grid_row]<br/>'
        );
    $groups['grid'][] = array(
        'name' => esc_html__('Grid 16.6% - 16.6% - 16.6% - 50%','nictiz-toolkit'),
        'code' => '[nictiz_toolkit_grid_row]<br/>[nictiz_toolkit_grid_col col=2]TEXT[/nictiz_toolkit_grid_col]<br/>[nictiz_toolkit_grid_col col=2]TEXT[/nictiz_toolkit_grid_col]<br/>[nictiz_toolkit_grid_col col=2]TEXT[/nictiz_toolkit_grid_col]<br/>[nictiz_toolkit_grid_col col=6]TEXT[/nictiz_toolkit_grid_col]<br/>[/nictiz_toolkit_grid_row]<br/>'
        );
    $groups['grid'][] = array(
        'name' => esc_html__('Grid 16.6% x6','nictiz-toolkit'),
        'code' => '[nictiz_toolkit_grid_row]<br/>[nictiz_toolkit_grid_col col=2]TEXT[/nictiz_toolkit_grid_col]<br/>[nictiz_toolkit_grid_col col=2]TEXT[/nictiz_toolkit_grid_col]<br/>[nictiz_toolkit_grid_col col=2]TEXT[/nictiz_toolkit_grid_col]<br/>[nictiz_toolkit_grid_col col=2]TEXT[/nictiz_toolkit_grid_col]<br/>[nictiz_toolkit_grid_col col=2]TEXT[/nictiz_toolkit_grid_col]<br/>[nictiz_toolkit_grid_col col=2]TEXT[/nictiz_toolkit_grid_col]<br/>[/nictiz_toolkit_grid_row]<br/>'
        );
    $groups['grid'][] = array(
        'name' => esc_html__('Grid 66% - 33%','nictiz-toolkit'),
        'code' => '[nictiz_toolkit_grid_row]<br/>[nictiz_toolkit_grid_col col=8]TEXT[/nictiz_toolkit_grid_col]<br/>[nictiz_toolkit_grid_col col=4]TEXT[/nictiz_toolkit_grid_col]<br/>[/nictiz_toolkit_grid_row]<br/>'
        );
    $groups['grid'][] = array(
        'name' => esc_html__('Grid 83.3% - 16.6%','nictiz-toolkit'),
        'code' => '[nictiz_toolkit_grid_row]<br/>[nictiz_toolkit_grid_col col=10]TEXT[/nictiz_toolkit_grid_col]<br/>[nictiz_toolkit_grid_col col=2]TEXT[/nictiz_toolkit_grid_col]<br/>[/nictiz_toolkit_grid_row]<br/>'
        );
    return $groups;
}


add_shortcode( 'nictiz_toolkit_grid_row', 'nictiz_toolkit_shortcode_grid_row' );
add_shortcode( 'nictiz_toolkit_grid_col', '__return_false' );

function nictiz_toolkit_shortcode_grid_row( $atts, $content = null ) {
    extract( shortcode_atts( array(), $atts ) );

    $cols   = nictiz_toolkit_extract_shortcodes( $content, true, array( 'nictiz_toolkit_grid_col' ) );
    
    $output = '<div class="row">';

    if ($cols) {
        foreach ($cols as $col) {
            $output .= sprintf( '<div class="col-xs-12 col-md-%s col-sm-%s"><p>%s</p></div>', (int)$col['atts']['col'], (int)$col['atts']['col'], do_shortcode( $col['content'] ) );
        }
    }

    $output .= '</div>';

    return apply_filters( 'nictiz_toolkit_shortcode_grid_row', $output, $atts, $content );
}
