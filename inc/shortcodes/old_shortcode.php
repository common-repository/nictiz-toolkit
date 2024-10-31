<?php
add_shortcode('contact_form', 'nictiz_toolkit_old_shortcode_contactform');
function nictiz_toolkit_old_shortcode_contactform($atts, $content = null){
	return do_shortcode('[nictiz_toolkit_contactform]');
}


add_shortcode('alert', 'kopa_shortcode_alert');

function kopa_shortcode_alert($atts, $content = null) {
    $atts = shortcode_atts(
            array(
        'type' => 'infor',
        'title' => ''
            ), $atts);

    $class = '';

    if (!in_array($atts['type'], array('block', 'error', 'success', 'info'))) {
        $atts['type'] = 'block';
    }

    $out = "<div class='alert alert-{$atts['type']}'>";
    $out .= "<h4>{$atts['title']}</h4>";
    $out .= '<p>' . do_shortcode($content) . '</p>';
    $out .= "</div >";

    return $out;
}

add_shortcode('youtube', 'kopa_shortcode_youtube');

function kopa_shortcode_youtube($atts, $content = null) {
    $atts = shortcode_atts(array(), $atts);
    $out = '';
    if ($content) {
        $matches = array();
        preg_match('#(\.be/|/embed/|/v/|/watch\?v=)([A-Za-z0-9_-]{5,11})#', $content, $matches);
        if (isset($matches[2]) && $matches[2] != '') {
            $out .= '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="http://www.youtube.com/embed/' . $matches[2] . '" width="560" height="315" frameborder="0" allowfullscreen></iframe></div>';
        }
    }

    return $out;
}

add_shortcode('vimeo', 'kopa_shortcode_vimeo');

function kopa_shortcode_vimeo($atts, $content = null) {
    $atts = shortcode_atts(array(), $atts);
    $out = '';
    if ($content) {
        $matches = array();
        preg_match('/(\d+)/', $content, $matches);
        if (isset($matches[0]) && $matches[0] != '') {
            $out .= '<div class=""embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="http://player.vimeo.com/video/' . $matches[0] . '" width="560" height="315" frameborder="0" allowfullscreen></iframe></div>';
        }
    }
    return $out;
}

// add_shortcode('soundcloud', 'kopa_shortcode_soundcloud');

// function kopa_shortcode_soundcloud($atts, $content = null) {
//     $atts = shortcode_atts(array(), $atts);
//     $out = '';

//     if ($content) {
//         $out = '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=' . esc_attr(urlencode($content)) . '"></iframe>';
//     }
//     return $out;
// }


add_shortcode('toggles', 'kopa_shortcode_toggles');
add_shortcode('toggle', '__return_false');
function kopa_shortcode_toggles($atts = array(), $content = NULL) {
    extract( shortcode_atts( array('style' => 1 ), $atts ) );
	
	$style_id = isset($atts['style']) ? (int)$atts['style'] : 0 ; 
	
	$is_toggle = 1 ;


	$tab_classes = apply_filters('nictiz_toolkit_d001_shortcode_accordions_classes', 'style-1', $style_id );

	if(0 === $is_toggle){
		$tab_classes .= ' k-accordion';
	}else{
		$tab_classes .= ' k-toggle';
	}

	$matches = nictiz_toolkit_extract_shortcodes( $content, true, array( 'toggle' ) );
	$accordions_id = 'accordions-' . mt_rand( 10, 100000 );
	for ( $i = 0; $i < count( $matches ); $i++ ) {

		$accordionid[$i] = 'accordion-' . mt_rand( 10, 100000 ) . '-' . strtolower( str_replace( array( "!", "@", "#", "$", "%", "^", "&", "*", ")", "(", "+", "=", "[", "]", "/", "\\", ";", "{", "}", "|", '"', ":", "<", ">", "?", "~", "`", " " ), "", $matches[$i]['atts']['title'] ) );
	}
	
	ob_start();
	?>
	<div class="panel-group <?php echo esc_attr($tab_classes); ?>">
			
            
            	<?php
					for ( $i = 0; $i < count( $matches ); $i++ ) {
						$active = '';
						$class = 'collapsed';
						$collapse = '';
						if ( $i == 0 ) {
							$active = 'active';
							$class = '';
							$collapse = 'in';
						}
						$icon = 'icon';
						if($matches[$i]['atts']['icon']){
							$icon = $matches[$i]['atts']['icon'];
						}
            	?>
		                <div class="panel panel-default">
		                    <div class="panel-heading <?php echo esc_attr( $active ? $active : '' ); ?>">
		                        <h4 class="panel-title">
		                            <a >
		                            <i class="<?php echo esc_attr($icon); ?>"></i>
		                            <?php echo (isset( $matches[$i]['atts']['title'] ) ? $matches[$i]['atts']['title'] : ''); ?>
		                            </a>
		                        </h4>
		                    </div>
		                    <div id="<?php echo esc_attr( $accordionid[$i] ); ?>" class="panel-collapse collapse <?php echo esc_attr( $collapse ); ?>">
		                        <div class="panel-body">
		                            <?php echo do_shortcode( trim( (isset( $matches[$i]['content'] ) ? $matches[$i]['content'] : '' ) ) ); ?>
		                        </div>
		                    </div>
		                </div>
		                <!--/panel panel-default-->
               <?php
               		}
               ?>
            
                                        
		</div>
	<?php
	$string = ob_get_contents();
	ob_end_clean();
	
	return apply_filters( 'nictiz_toolkit_d001_accordions', $string, $atts, $content );

}



add_shortcode('posts', 'kopa_shortcode_posts');

function kopa_shortcode_posts($atts, $content = null) {
    $atts = shortcode_atts(array(
        'cats' => '',
        'tags' => '',
        'relation' => 'OR',
        'count' => 10,
        'orderby' => 'lastest', //lastest, popular, most_like, most_comment, random
        'max_length' => 0
            ), $atts);

    $args = array(
        'post_type' => array('post'),
        'posts_per_page' => (int) $atts['count'],
    );

    $tax_query = array();
    if ($atts['cats']) {
        $tax_query[] = array(
            'taxonomy' => 'category',
            'field' => 'id',
            'terms' => explode(', ', $atts['cats'])
        );
    }
    if ($atts['tags']) {
        $tax_query[] = array(
            'taxonomy' => 'post_tag',
            'field' => 'id',
            'terms' => explode(', ', $atts['tags'])
        );
    }
    if ($atts['relation'] && count($tax_query) == 2) {
        $tax_query[] = ('OR' == $atts['relation']) ? 'OR' : 'AND';
    }

    if ($tax_query) {
        $args['tax_query'] = $tax_query;
    }

    switch ($atts['orderby']) {
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

    $posts = new WP_Query($args);

    $out = '';
    $max_length = ($atts['max_length']) ? (int) $atts['max_length'] : 0;

    if ($posts->post_count > 0) {
        $out .= '<ul class="kopa-shortcode-posts kp-latest-post cleafix">';
        while ($posts->have_posts()) {
            $posts->the_post();
            $post_id = get_the_ID();
            $url = get_permalink();
            $title = get_the_title();
            $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'kopa-image-size-0');

            $out .= '<li>';
            $out .= '<article class="clearfix">';
            if (has_post_thumbnail($post_id))
                $out .= '<a class="entry-thumb" href="' . $url . '"><img src="' . $thumbnail[0] . '" alt="" class="hover-effect"></a>';

            $out .= '<div class="entry-content">';
            $out .= '<h4 class="entry-title"><a href="' . $url . '">' . $title . '</a></h4>';

            $out .= '<span class="entry-date">' . KopaIcon::getIcon('fa fa-calendar-o entry-icon', 'span') . get_the_date() . '</span>';
            $out .= '<span class="entry-comment">' . KopaIcon::getIcon('fa fa-comment-o entry-icon', 'span');

            $num_comments = get_comments_number(); // get_comments_number returns only a numeric value
            if (comments_open()) {
                if ($num_comments == 0) {
                    $comments = esc_html__('0 Comments', 'nictiz-toolkit');
                } elseif ($num_comments > 1) {
                    $comments = $num_comments . esc_html__(' Comments', 'nictiz-toolkit');
                } else {
                    $comments = esc_html__('1 Comment', 'nictiz-toolkit');
                }
                $out .= $comments;
            } else {
                $out .= esc_html__('Comments off', 'nictiz-toolkit');
            }
            $out .= '</span>';
            $out .= '</div>';
            $out .= '</article>';
            $out .= '</li>';
        }
        $out .= '</ul>';
    }

    wp_reset_postdata();

    return $out;
}
