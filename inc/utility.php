<?php

function nictiz_toolkit_print_single_post_author() {
    global $post;
    
    $user_id                     = $post->post_author;
    $social_links                = array(); 
    $social_links['facebook']    = get_user_meta( $user_id, 'facebook', true );
    $social_links['twitter']     = get_user_meta( $user_id, 'twitter', true );
    $social_links['rss']         = get_user_meta( $user_id, 'rss', true );
    $social_links['pinterest']   = get_user_meta( $user_id, 'pinterest', true );
    $social_links['google-plus'] = get_user_meta( $user_id, 'google_plus', true );

    if ( array_filter( $social_links ) ) : 
    ?>
        <div class="list-social">
            <?php foreach ( $social_links as $key => $link ): ?>
                <a href="<?php echo esc_url($link); ?>" class="fa fa-<?php echo esc_attr($key); ?>" target="__blank"></a>
            <?php endforeach; ?>
        </div>
    <?php 
    endif;
}

function nictiz_toolkit_build_query( $query_args = array() ) {
    $default_query_args = array(
        'post_type'           => 'post',
        'posts_per_page'      => -1,
        'post__not_in'        => array(),
        'ignore_sticky_posts' => 1,
        'categories'          => array(),
        'tags'                => array(),
        'relation'            => 'OR',
        'orderby'             => 'lastest',
        'cat_name'            => 'category',
        'tag_name'            => 'post_tag'
    );

    $query_args = wp_parse_args( $query_args, $default_query_args );

    $args = array(
        'post_type'           => $query_args['post_type'],
        'posts_per_page'      => $query_args['posts_per_page'],
        'post__not_in'        => $query_args['post__not_in'],
        'ignore_sticky_posts' => $query_args['ignore_sticky_posts']
    );

    $tax_query = array();

    if ( $query_args['categories'] ) {
        $tax_query[] = array(
            'taxonomy' => $query_args['cat_name'],
            'field'    => 'id',
            'terms'    => $query_args['categories']
        );
    }
    if ( $query_args['tags'] ) {
        $tax_query[] = array(
            'taxonomy' => $query_args['tag_name'],
            'field'    => 'id',
            'terms'    => $query_args['tags']
        );
    }
    if ( $query_args['relation'] && count( $tax_query ) == 2 )
        $tax_query['relation'] = $query_args['relation'];

    if ( $tax_query ) {
        $args['tax_query'] = $tax_query;
    }

    switch ( $query_args['orderby'] ) {
        case 'popular':
            $args['meta_key'] = 'kopa_' . 'nictiz-toolkit' . '_total_view';
            $args['orderby'] = 'meta_value_num';
            break;
        case 'most_comment':
            $args['orderby'] = 'comment_count';
            break;
        case 'random':
            $args['orderby'] = 'rand';
            break;
        default:
            $args['orderby'] = 'date';
            break;
    }

    return new WP_Query( $args );
}

function nictiz_toolkit_get_allowed_tags() {
    if( function_exists( 'nictiz_get_allowed_tags' ) ){
        return nictiz_get_allowed_tags();
    }else{
        return wp_kses_allowed_html( 'post' );
    }
}

function nictiz_toolkit_get_client_ip() {
    $ip = false;

    if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
            $ip_array = explode( ',', $_SERVER['HTTP_X_FORWARDED_FOR'] );
            $ip       = trim( $ip_array[ count( $ip_array ) - 1 ] );
    } elseif ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function nictiz_toolkit_get_likes( $post_id = 0 ) {
    $key = 'nictitate_likes';
    return (int) get_post_meta( $post_id, $key, true );
}

function nictiz_toolkit_is_liked( $post_id = 0 ) {
    $key = sprintf( 'nictitate_like_by_%s', nictiz_toolkit_get_client_ip() );
    return (int) get_post_meta( $post_id, $key, true );
}

function nictiz_toolkit_single_share_post(){
    $single_share = (int) get_theme_mod( 'single_share', '1' );
    if ( 1 == $single_share ) : ?>
    <div class="box-share-post">
        <h4><?php echo esc_html__( 'Share this post', 'nictitate' ); ?></h4>
        <?php
            global $post;
            $post_url       = get_permalink( $post->ID );
            $post_title     = get_the_title( $post->ID );
        ?>
        <div class="list-social">
            <a href="<?php echo esc_url( sprintf( '//www.facebook.com/share.php?u=%s', urlencode( $post_url ) ) ); ?>" class="fa fa-facebook" target="__blank"></a>
            <a href="<?php echo esc_url( sprintf( '//twitter.com/home?status=%s+%s', $post_title, $post_url ) ); ?>" class="fa fa-twitter" target="__blank"></a>
            <a href="http://pinterest.com/pin/create/button/?url=<?php echo $post_url;?>&description=<?php echo substr( $post_title,0,200 );?>" class="fa fa-pinterest" target="__blank"></a>
            <a href="<?php echo esc_url(sprintf('//plus.google.com/share?url=%s', $post_url)); ?>" class="fa fa-google-plus" target="__blank"></a>
        </div>
    </div>
    <?php
    endif;
}