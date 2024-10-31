<?php
add_filter('nictiz_toolkit_get_elements', 'nictiz_toolkit_register_elements_tabs');


function nictiz_toolkit_register_elements_tabs($groups){
	$groups['tabs'][] = array(
		'name' => esc_html__('Tab 1','nictiz-toolkit'),
		'code' => '[tabs style="1"]<br/>[tab title="Tab title 1" ]Tab Content 1[/tab]<br/>[tab title="Tab title 2"]Tab Content 2[/tab]<br/>[tab title="Tab title 3"]Tab Content 3[/tab]<br/>[/tabs]'
		);
	return $groups;
}

add_shortcode( 'tabs', 'nictiz_toolkit_shortcode_tabs' );
add_shortcode( 'tab', '__return_false' );

function nictiz_toolkit_shortcode_tabs( $atts, $content ) {
	$rand = rand();
	extract( shortcode_atts( array('style' => '1'), $atts ) );
	
	$style_id = isset($atts['style']) ? (int)$atts['style'] : 0 ; 
	
	$old_atts = $atts;
	unset($old_atts['style']);

	$tab_classes = apply_filters('nictiz_toolkit_shortcode_tabs_classes', 'style-1', $style_id );

	ob_start();
	$matches = nictiz_toolkit_extract_shortcodes( $content, true, array( 'tab' ) );
	
	?>
	<div class="k-tabs <?php echo esc_attr($tab_classes); ?> clearfix">
		<ul class="nav nav-tabs" role="tablist">
			<?php
			for ( $i = 0; $i < count( $matches ); $i++ ) {
				?>
				<li class="<?php echo esc_attr( $i == 0 ? 'active' : ''  ); ?>" role="presentation">
					<a href="#tab<?php echo esc_attr( 'tab1-' . $i . '-' . $rand ); ?>" role="tab" data-toggle="tab" aria-controls="tab<?php echo esc_attr( 'tab1-' . $i . '-' . $rand ); ?>">
						<?php if(isset( $matches[$i]['atts']['title_icon'])){
							?>
							<i class="<?php echo esc_attr($matches[$i]['atts']['title_icon']); ?>"></i>
							<?php
						} ?>
						<?php 
						$title = '';
						if(isset( $matches[$i]['atts']['title'] )){
							$title = $matches[$i]['atts']['title'];
						}else{
							if(!empty($old_atts)){
								$title = $old_atts['tab'.($i+1)];
							}
						}

						?>
						<?php echo wp_kses_post($title ); ?>
					</a>
				</li>
				<?php
			}
			?>
		</ul>
		<div class="tab-content">
			<?php
			for ( $i = 0; $i < count( $matches ); $i++ ) {
				?>
				<div class="tab-pane <?php echo esc_attr( $i == 0 ? 'active' : ''  ); ?>" id="tab<?php echo esc_attr( 'tab1-' . $i . '-' . $rand ); ?>" role="tabpanel">
					<p><?php echo do_shortcode( trim( (isset( $matches[$i]['content'] ) ? $matches[$i]['content'] : '' ) ) ); ?></p>
				</div>
				<?php
			}
			?>
		</div>
	</div>
	<?php
	$string = ob_get_contents();
	ob_end_clean();
	return apply_filters( 'nictiz_toolkit_shortcode_tabs', $string, $atts, $content );
}


