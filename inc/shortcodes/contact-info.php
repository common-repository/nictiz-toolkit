<?php
add_filter('nictiz_toolkit_get_elements', 'nictiz_toolkit_contactinfo_register_elements');


function nictiz_toolkit_contactinfo_register_elements($groups){
    $groups['contact-info'][] = array(
        'name' => esc_html__('Contact Info 1','nictiz-toolkit'),
        'code' => '[nictiz_toolkit_contact_infos title="" style="1"]<br/>[nictiz_toolkit_contactinfo icon="fa fa-home"]Content 1[/nictiz_toolkit_contactinfo]<br/>[nictiz_toolkit_contactinfo icon="fa fa-home"]Content 2[/nictiz_toolkit_contactinfo]<br/>[nictiz_toolkit_contactinfo icon="fa fa-home"]Content 3[/nictiz_toolkit_contactinfo]<br/>[/nictiz_toolkit_contact_infos]<br/>'
        );
    $groups['contact-info'][] = array(
        'name' => esc_html__('Contact Info 2','nictiz-toolkit'),
        'code' => '[nictiz_toolkit_contact_infos title="" style="2"]<br/>[nictiz_toolkit_contactinfo icon="fa fa-home"]Content 1[/nictiz_toolkit_contactinfo]<br/>[nictiz_toolkit_contactinfo icon="fa fa-home"]Content 2[/nictiz_toolkit_contactinfo]<br/>[nictiz_toolkit_contactinfo icon="fa fa-home"]Content 3[/nictiz_toolkit_contactinfo]<br/>[/nictiz_toolkit_contact_infos]<br/>'
        );
    $groups['contact-info'][] = array(
        'name' => esc_html__('Contact Info 3','nictiz-toolkit'),
        'code' => '[nictiz_toolkit_contact_infos title="" style="3"]<br/>[nictiz_toolkit_contactinfo icon="fa fa-home"]Content 1[/nictiz_toolkit_contactinfo]<br/>[nictiz_toolkit_contactinfo icon="fa fa-home"]Content 2[/nictiz_toolkit_contactinfo]<br/>[nictiz_toolkit_contactinfo icon="fa fa-home"]Content 3[/nictiz_toolkit_contactinfo]<br/>[/nictiz_toolkit_contact_infos]<br/>'
        );
    return $groups;
}

add_shortcode('nictiz_toolkit_contact_infos', 'nictiz_toolkit_contactinfo_shortcode');
add_shortcode('nictiz_toolkit_contactinfo', '__return_false' );

function nictiz_toolkit_contactinfo_shortcode($atts, $content = null){
	extract( shortcode_atts( array(), $atts ) );

	$style_id = isset($atts['style']) ? (int)$atts['style'] : 1 ;

	$matches = nictiz_toolkit_extract_shortcodes( $content, true, array( 'nictiz_toolkit_contactinfo' ) );

	$title = isset($atts['title']) ? $atts['title']: '' ;

	$widget_class = '';
	switch($style_id){
		case 1:
			$widget_class='k-widget-info';
			break;
		case 2:
			$widget_class='k-widget-info-2';
			break;
		default:
			$widget_class='k-widget-info-3';
			break;
	}

	ob_start();

	?>
	<div class="widget <?php echo esc_attr($widget_class); ?>">
		<?php if($title){ ?>
    	<h3 class="widget-title"><?php echo wp_kses_post($title); ?></h3>
    	<?php } ?>
    	<?php if(count($matches) > 0 ){ ?>
    	<ul class="list-item list-unstyled">
			<?php for($i = 0; $i < count( $matches ); $i++){ ?>
			<li class="item">
				<?php if($matches[$i]['atts']['icon']){ ?>
				<i class="icon <?php echo esc_attr($matches[$i]['atts']['icon']); ?>"></i>
				<?php } ?>
				
				<?php echo do_shortcode($matches[$i]['content']); ?>
				
			</li>	    				
			<?php } ?>		        
		</ul>					
    	<?php } ?>
    	<?php echo do_action('nictiz_toolkit_shortcode_contactinfo_after_list', $atts); ?>	
    </div>
	<?php

	$string = ob_get_contents();
	ob_end_clean();

	return apply_filters( 'nictiz_toolkit_contactinfo_shortcode', $string, $atts, $content );
}