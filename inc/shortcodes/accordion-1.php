<?php

add_filter('nictiz_toolkit_get_elements', 'nictiz_toolkit_register_elements_accordion');

function nictiz_toolkit_register_elements_accordion($groups){
	$groups['accordions'][] = array(
		'name' => esc_html__('Accordion 1','nictiz-toolkit'),
		'code' => '[accordions style="1" is_toggle="0"]<br/>[accordion title="Accordion title 1" icon="fa fa-bars"]Accordion content 1[/accordion]<br/>[accordion title="Accordion title 2" icon="fa fa-bars"]Accordion content 2[/accordion]<br/>[accordion title="Accordion title 3" icon="fa fa-bars"]Accordion content 3[/accordion]<br/>[/accordions]',
		);
	return $groups;
}

add_shortcode('accordions', 'nictiz_toolkit_accordions');
add_shortcode('accordion', '__return_false' );

function nictiz_toolkit_accordions( $atts, $content = null){
	extract( shortcode_atts( array('style' => 1 ), $atts ) );
	
	$style_id = isset($atts['style']) ? (int)$atts['style'] : 0 ; 
	
	$is_toggle = isset($atts['is_toggle']) ? (int)$atts['is_toggle'] : 0 ;


	$tab_classes = apply_filters('nictiz_toolkit_shortcode_accordions_classes', 'style-1', $style_id );

	if(0 === $is_toggle){
		$tab_classes .= ' k-accordion';
	}else{
		$tab_classes .= ' k-toggle';
	}

	$matches = nictiz_toolkit_extract_shortcodes( $content, true, array( 'accordion' ) );
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
						if(isset($matches[$i]['atts']['icon'])){
							$icon = $matches[$i]['atts']['icon'];
						}
						if(5 === (int)$style_id){
							$icon = 'fa fa-plus';
							if($i == 0){
								$icon = 'fa fa-minus';
							}
						}
            	?>
		                <div class="panel panel-default">
		                    <div class="panel-heading <?php echo esc_attr( $active ? $active : '' ); ?>">
		                        <h4 class="panel-title">
		                            <a class="<?php echo esc_attr($class); ?>">
		                            <i class="<?php echo esc_attr($icon); ?>"></i>
		                            <?php echo (isset( $matches[$i]['atts']['title'] ) ? esc_html($matches[$i]['atts']['title']) : ''); ?>
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
	
	return apply_filters( 'nictiz_toolkit_accordions', $string, $atts, $content );

}


