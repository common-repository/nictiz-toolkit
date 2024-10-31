<?php

add_action( 'admin_init', 'nictiz_toolkit_admin_init' );

function nictiz_toolkit_admin_init() {
	if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
		add_filter( 'mce_external_plugins', 'nictiz_toolkit_load_editor_plugin' );
		add_filter( 'mce_buttons', 'nictiz_toolkit_add_editor_button' );
	}
}

function nictiz_toolkit_load_editor_plugin( $plugin_array ) {
	$plugin_array['nictiz_toolkit_button'] = NICTIZ_TOOLKIT_DIR . 'assets/js/tinymce.js';
	return $plugin_array;
}

function nictiz_toolkit_add_editor_button( $buttons ) {
	$buttons[] = 'nictiz_toolkit_button';
	return $buttons;
}

add_action( 'admin_enqueue_scripts', 'nictiz_toolkit_admin_enqueue_scripts' );

function nictiz_toolkit_admin_enqueue_scripts( $hook ) {
	if ( in_array( $hook, array( 'widgets.php', 'post.php', 'post-new.php', 'edit.php' ), true ) ) {
		wp_enqueue_style( 'featherlight', NICTIZ_TOOLKIT_DIR . 'assets/css/featherlight.css', array(), null );
		wp_enqueue_style( 'nictiz-toolkit-admin-style', NICTIZ_TOOLKIT_DIR . 'assets/css/admin.style.css', array(), null );

		wp_enqueue_script( 'featherlight', NICTIZ_TOOLKIT_DIR . 'assets/js/featherlight.js', array( 'jquery' ), null, true );
		wp_enqueue_script( 'nictiz-toolkit-admin-script', NICTIZ_TOOLKIT_DIR . 'assets/js/admin.script.js', array( 'jquery' ), null, true );

		$localize_data = array(
			'ajax' => array(
				'url' => admin_url( 'admin-ajax.php' ),
				'security' => array(
					'load_elements' => wp_create_nonce( 'nictiz-toolkit-load-elements' ),
				),
			),
			'translate' => array(
				'nictiz_toolkit_elements' => esc_html__( 'Nictiz Elements', 'nictiz-toolkit' ),
			),
			'resource' => array(
				'icon' => NICTIZ_TOOLKIT_DIR . 'assets/images/icon.png',
			),
		);

		wp_localize_script( 'nictiz-toolkit-admin-script', 'nictiz_toolkit_variables', $localize_data );
	}
}

add_action( 'admin_footer', 'nictiz_toolkit_print_elements', 15 );

function nictiz_toolkit_print_elements() {
	$screen = get_current_screen();
	
	if( 'post' === $screen->base ) {
		$groups = array();
		$groups = apply_filters( 'nictiz_toolkit_get_elements', $groups );
		if( $groups ) {
			$allowed_tags = nictiz_get_allowed_tags();
			?>	
			<div id="nictiz-toolkit-elements">
				<?php
					$is_first = true;		
					foreach ( $groups as $group_slug => $group ) : 
						$title_caret     = '+';
						$title_classes[] = 'nictiz-toolkit-title';					
						$grid_style      = 'display:none;';
						if ( $is_first ) {
							$is_first      = false;
							$title_caret   = '-';
							$grid_style    = '';
							$title_classes[] = 'nictitate-toolkit-other';					
						}
				?>
					<h3 class="<?php echo esc_attr( implode( $title_classes, ' ' ) ); ?>">
						<?php echo esc_attr( nictiz_toolkit_beautify( $group_slug ) ); ?>
						<small>(<?php echo esc_attr( count( $group ) );?>)</small>
						<span class="nictiz-toolkit-caret">+</span>
					</h3>
					<div style="<?php echo esc_attr( $grid_style ); ?>">
						<div class="nictiz-toolkit-row">
							<?php 
								$loop_index = 0;
								foreach ( $group as $element_slug => $element ) :
									if ( $loop_index && 0 === $loop_index  % 2 ) {
										echo '</div>';
										echo '<div class="nictiz-toolkit-row">';
									}								
							?>
								<div class="nictiz-toolkit-col">								
									<span class="nictiz-toolkit-caption" onclick="nictiz_toolkit_element.insert( jQuery( this ) );"><?php echo esc_attr( $element['name'] ); ?></span>
									<div class="nictiz-toolkit-code">
										<?php echo wp_kses( $element['code'], $allowed_tags ); ?>
									</div>
								</div>
							<?php 
							$loop_index++;
							endforeach;
							?>
						</div>
					</div>
		     	<?php endforeach; ?>
			</div>
		<?php
		}
	}
}

function nictiz_toolkit_extract_shortcodes( $content, $enable_multi = false, $shortcodes = array() ) {
	$codes         = array();
	$regex_matches = '';
	$regex_pattern = get_shortcode_regex();

	preg_match_all( '/' . $regex_pattern . '/s', $content, $regex_matches );

	foreach ( $regex_matches[0] as $shortcode ) {
		$regex_matches_new = '';
		preg_match( '/' . $regex_pattern . '/s', $shortcode, $regex_matches_new );

		if ( in_array( $regex_matches_new[2], $shortcodes, true ) ) :
			$codes[] = array(
				'shortcode' => $regex_matches_new[0],
				'type'      => $regex_matches_new[2],
				'content'   => $regex_matches_new[5],
				'atts'      => shortcode_parse_atts( $regex_matches_new[3] ),
			);

			if ( ! $enable_multi ) {
				break;
			}
		endif;
	}

	return $codes;
}

function nictiz_toolkit_beautify( $string ) {
	$string = str_replace( '-', ' ', $string );
	return ucwords( str_replace( '_', ' ', $string ) );
}