<?php
add_filter('nictiz_toolkit_get_elements', 'nictiz_toolkit_register_elements_list_icon');


function nictiz_toolkit_register_elements_list_icon($groups){
	$groups['list'][] = array(
		'name' => esc_html__('List 1','nictiz-toolkit'),
		'code' => '[nictiz_toolkit_lists]<br/>[nictiz_toolkit_list icon_class="fa fa-angle-double-right"]Content 1[/nictiz_toolkit_list]<br/>[nictiz_toolkit_list icon_class="fa fa-angle-double-right"]Content 2[/nictiz_toolkit_list]<br/>[nictiz_toolkit_list icon_class="fa fa-angle-double-right"]Content 3[/nictiz_toolkit_list]<br/>[/nictiz_toolkit_lists]'
		);
	return $groups;
}


add_shortcode( 'nictiz_toolkit_lists', 'nictiz_toolkit_shortcode_lists' );
add_shortcode('nictiz_toolkit_list', '__return_false');

function nictiz_toolkit_shortcode_lists( $atts, $content ) {
	
	extract( shortcode_atts( array(), $atts ) );

	$matches = nictiz_toolkit_extract_shortcodes( $content, true, array( 'nictiz_toolkit_list' ) );

	ob_start();
	?>

		<ul class="k-list list-unstyled">
			<?php 
			for ( $i = 0; $i < count( $matches ); $i++ ) {
				?>
				<li>
					<?php if(isset($matches[$i]['atts']['icon_class'])){
						?>
						<i class="<?php echo esc_attr($matches[$i]['atts']['icon_class']); ?>"></i>
						<?php
					}
					echo '<span>' .do_shortcode($matches[$i]['content']) . '</span>'; 
					?>
				</li>
				<?php
			}
			?>
        </ul>

	<?php

	$string = ob_get_contents();
	ob_end_clean();

	return apply_filters( 'nictiz_toolkit_shortcode_lists', $string, $atts, $content );
}




