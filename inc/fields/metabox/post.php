<?php

if ( ! class_exists( 'Kopa_Framework' ) ) {
    return;
}

add_filter( 'kopa_admin_metabox_advance_field', '__return_true' );

if ( is_admin() ) {
    add_action( 'admin_init', 'nictiz_toolkit_metabox_post_featured' );
}

function nictiz_toolkit_metabox_post_featured() {
    $post_type = array( 'post' );

    $nictiz_toolkit_modules_fields = array(
        array(
            'title' => esc_html__( 'Gallery:', 'nictiz-toolkit' ),
            'type'  => 'gallery',
            'id'    => 'nictitate_toolkit_ii_gallery',
            'desc'  => esc_html__( 'This option only apply for post-format "Gallery".', 'nictiz-toolkit' ),
        ),
        array(
            'title' => esc_html__( 'Quote:', 'nictiz-toolkit' ),
            'type'  => 'quote',
            'id'    => 'nictitate_toolkit_ii_quote',
            'desc'  => esc_html__( 'This option only apply for post-format "Quote".', 'nictiz-toolkit' ),
        ),
        array(
            'title' => esc_html__( 'Link to:', 'nictiz-toolkit' ),
            'type'  => 'text',
            'id'    => 'nictitate_toolkit_ii_linkto',
            'desc'  => esc_html__( 'This option only apply for post-format "Link".', 'nictiz-toolkit' ),
        ),
        array(
            'title' => esc_html__( 'Custom:', 'nictiz-toolkit' ),
            'type'  => 'textarea',
            'id'    => 'nictitate_toolkit_ii_custom',
            'desc'  => esc_html__( 'Enter custom content as shortcode or custom HTML, ...', 'nictiz-toolkit' ),
        ),        
    );
    $nictiz_toolkit_modules_fields = apply_filters( 'nictiz_toolkit_metabox_set_fields_post_featured', $nictiz_toolkit_modules_fields );
    $args = array(
        'id'       => 'nictiz-toolkit-post-options-metabox',
        'title'    => esc_html__( 'Featured content', 'nictiz-toolkit' ),
        'desc'     => '',
        'pages'    => $post_type,
        'context'  => 'normal',
        'priority' => 'high',
        'fields'   => $nictiz_toolkit_modules_fields,
    );

    kopa_register_metabox( $args );
}
