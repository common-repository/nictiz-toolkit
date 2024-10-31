<?php
if(class_exists('Kopa_Framework')){

	add_action('init',  'nictiz_toolkit_register_post_type_pricings');			
	add_action('admin_init', 'nictiz_toolkit_register_metabox_pricings');
	add_filter( 'manage_pricing_table_posts_columns', 'nictiz_toolkit_manage_colums_pricings' );
	add_action( 'manage_pricing_table_posts_custom_column' ,'nictiz_toolkit_manage_colum_pricings' );
	


	function nictiz_toolkit_register_post_type_pricings(){

		$labels = array(
			'name'               => _x('Pricings', 'post type general name', 'nictiz-toolkit'),
			'singular_name'      => _x('Pricing', 'post type singular name', 'nictiz-toolkit'),
			'menu_name'          => _x('Pricings', 'admin menu', 'nictiz-toolkit'),
			'name_admin_bar'     => _x('Pricing', 'add new on admin bar', 'nictiz-toolkit'),
			'add_new'            => _x('Add New', 'pricing_table', 'nictiz-toolkit'),
			'add_new_item'       => esc_html__('Add New Pricing', 'nictiz-toolkit'),
			'new_item'           => esc_html__('New Pricing', 'nictiz-toolkit'),
			'edit_item'          => esc_html__('Edit Pricing', 'nictiz-toolkit'),
			'view_item'          => esc_html__('View Pricing', 'nictiz-toolkit'),
			'all_items'          => esc_html__('All Pricings', 'nictiz-toolkit'),
			'search_items'       => esc_html__('Search Pricings', 'nictiz-toolkit'),
			'parent_item_colon'  => esc_html__('Parent Pricings:', 'nictiz-toolkit'),
			'not_found'          => esc_html__('No pricing_tables found.', 'nictiz-toolkit'),
			'not_found_in_trash' => esc_html__('No pricing_tables found in Trash.', 'nictiz-toolkit')
		);

		$args = array(
			'menu_icon'          => 'dashicons-chart-line',
			'public'             => true,	      
			'labels'             => $labels,
			'supports'           => array('title', 'thumbnail'),
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => false,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'pricing_table' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 100
	  );

	  register_post_type('pricing_table', $args);

		$labels = array(
			'name'              => _x('Pricing Tags', 'taxonomy general name', 'nictiz-toolkit'),
			'singular_name'     => _x('Tag', 'taxonomy singular name', 'nictiz-toolkit'),
			'search_items'      => esc_html__('Search Tags', 'nictiz-toolkit'),
			'all_items'         => esc_html__('All Tags', 'nictiz-toolkit'),
			'parent_item'       => esc_html__('Parent Tag', 'nictiz-toolkit'),
			'parent_item_colon' => esc_html__('Parent Tag:', 'nictiz-toolkit'),
			'edit_item'         => esc_html__('Edit Tag', 'nictiz-toolkit'),
			'update_item'       => esc_html__('Update Tag', 'nictiz-toolkit'),
			'add_new_item'      => esc_html__('Add New Tag', 'nictiz-toolkit'),
			'new_item_name'     => esc_html__('New Tag Name', 'nictiz-toolkit'),
			'menu_name'         => esc_html__('Tag', 'nictiz-toolkit'),
		);

		$args = array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array('slug' => 'pricing_table-tag'),
		);

		register_taxonomy('pricing_table-tag', array('pricing_table'), $args);		    
	}
	
	function nictiz_toolkit_register_metabox_pricings(){
		$args = array(
			'id'          => 'nictitate_toolkit_ii-pricing_table-price-metabox',
		    'title'       => esc_html__('Price', 'nictiz-toolkit'),
		    'desc'        => '',
		    'pages'       => array( 'pricing_table' ),
		    'context'     => 'normal',
		    'priority'    => 'low',
		    'fields'      => array(
		    					
					array(
						'title'   => esc_html__('Price', 'nictiz-toolkit'),
						'type'    => 'text',
						'id'      => 'nictiz_toolkit_price',						
					),
					array(
						'title'   => esc_html__('Currency', 'nictiz-toolkit'),
						'type'    => 'text',
						'id'      => 'nictiz_toolkit_currency',						
					),
					array(
						'title'   => esc_html__('Suffix', 'nictiz-toolkit'),
						'type'    => 'text',
						'id'      => 'nictiz_toolkit_suffix',						
					),

		    )
		);			
		
		kopa_register_metabox( $args );

		$args = array(
			'id'       => 'pricing_table-features-metabox',
			'title'    => esc_html__('Features', 'nictiz-toolkit'),
			'desc'     => '',
			'pages'    => array( 'pricing_table' ),
			'context'  => 'normal',
			'priority' => 'low',
			'fields'   => array()
		);

		$limit = (int)apply_filters('nictiz_toolkit_get_number_of_features_pricing', 10);
		
		for($i=1; $i<= $limit; $i++){
			$args['fields'][$i] = array(
				'title'   => "#{$i}",
				'type'    => 'text',
				'id'      => "nictiz_toolkit_feature_{$i}"
			);
		}

		kopa_register_metabox( $args );			

		$args = array(
			'id'          => 'pricing_table-button-metabox',
		    'title'       => esc_html__('Button', 'nictiz-toolkit'),
		    'desc'        => '',
		    'pages'       => array( 'pricing_table' ),
		    'context'     => 'normal',
		    'priority'    => 'low',
		    'fields'      => array(				
					array(
						'title'   => esc_html__('Label', 'nictiz-toolkit'),
						'type'    => 'text',
						'id'      => 'nictiz_toolkit_button_label',						
					),
					array(
						'title'   => esc_html__('URL', 'nictiz-toolkit'),
						'type'    => 'text',
						'id'      => 'nictiz_toolkit_button_url',						
					)					
		    )
		);			
		
		kopa_register_metabox( $args );	

		$args = array(
			'id'          => 'pricing_table-style-metabox',
		    'title'       => esc_html__('Style', 'nictiz-toolkit'),
		    'desc'        => '',
		    'pages'       => array( 'pricing_table' ),
		    'context'     => 'normal',
		    'priority'    => 'low',
		    'fields'      => array(				
					array(
						'title'   => esc_html__('Style', 'nictiz-toolkit'),
						'type'    => 'select',
						'id'      => 'nictiz_toolkit_style',
						'default' => '1',						
						'options' => apply_filters('nictiz_toolkit_style', array('1' => esc_html__('Style 1', 'nictiz-toolkit'), '2' => esc_html__('Style 2', 'nictiz-toolkit'))) 
					),				
		    )
		);
		kopa_register_metabox( $args );	

		$args = array(
			'id'          => 'pricing_table-sticky-metabox',
		    'title'       => esc_html__('Sticky item', 'nictiz-toolkit'),
		    'desc'        => '',
		    'pages'       => array( 'pricing_table' ),
		    'context'     => 'normal',
		    'priority'    => 'low',
		    'fields'      => array(				
					array(
						
						'type'    => 'checkbox',
						'id'      => 'nictiz_toolkit_sticky',
						'default' => 0,						
						'label'   => esc_html__('Is Sticky', 'nictiz-toolkit')
						
					),				
		    )
		);
		kopa_register_metabox( $args );	
	}

	
    function nictiz_toolkit_manage_colums_pricings( $columns ) {
        $columns = array(
			'cb'                                     => esc_html__( '<input type="checkbox" />', 'nictiz-toolkit' ),
			'title'                                  => esc_html__( 'Title', 'nictiz-toolkit' ),
			'nictitate-toolkit-ii-pricing-shortcode' => esc_html__( 'Shortcode', 'nictiz-toolkit' ),
        );

        return $columns;
    }

	
	function nictiz_toolkit_manage_colum_pricings( $column ) {
		global $post;
		switch ( $column ) {
			case 'nictitate-toolkit-ii-pricing-shortcode':
				
				echo '[pricing_table id="'.$post->ID.'"]';
				break;
			
		}
	}
}


add_filter('nictiz_toolkit_get_elements', 'nictiz_toolkit_register_elements_pricings');


function nictiz_toolkit_register_elements_pricings($groups){
	$groups['pricing-table'][] = array(
		'name' => esc_html__('Pricing table','nictiz-toolkit'),
		'code' => '[pricing_table id=""][/pricing_table]'
		);
	
	return $groups;
}

add_shortcode('pricing_table', 'nictiz_toolkit_shortcode_pricingtable');


function nictiz_toolkit_shortcode_pricingtable($atts, $content = null){
	extract(shortcode_atts(array('style'=> 1), $atts));
	ob_start();
	

    $pricing_table_id = isset( $atts['id'] ) ? (int)$atts['id'] : 0;


    $pricing_table = get_post($pricing_table_id);
    if($pricing_table && ! is_wp_error( $pricing_table )){
    	$post_id = $pricing_table->ID;
    	$title = $pricing_table->post_title;
    	
    	$price        = get_post_meta($post_id, 'nictiz_toolkit_price', true);
		$currency     = get_post_meta($post_id, 'nictiz_toolkit_currency', true);
		$suffix       = get_post_meta($post_id, 'nictiz_toolkit_suffix', true);

		$style_id       = intval(get_post_meta($post_id, 'nictiz_toolkit_style', true));
		

		$button_label = get_post_meta($post_id, 'nictiz_toolkit_button_label', true);
		$button_url   = get_post_meta($post_id, 'nictiz_toolkit_button_url', true);

		$is_sticky = get_post_meta($post_id, 'nictiz_toolkit_sticky', true);
		$classes = array('k-pricing-table');
		if($is_sticky){
			$classes[] = 'popular';
		}

		switch($style_id){
			case 2:
				$classes[] = 'style-2';
				break;
			default:
				$classes[] = 'style-1';
				break;
		}
    ?>
    <ul class="<?php echo implode(' ', $classes); ?>">
    	<?php if($title){
    		?>
    		<li class="title"><?php echo wp_kses_post($title ); ?></li>
    		<?php
    	} ?>
    	<?php if(isset($suffix) && 2 === $style_id){
    		?>
    		<li class="time-unit"><?php echo esc_html($suffix); ?></li>
    		<?php
    	} ?>
    	<?php if(isset($price)){
    		?>
    		<li class="price"><span><?php echo esc_html($currency); ?></span><?php echo esc_html($price); ?></li>
    		<?php
    	} ?>
    	<?php if(isset($suffix) && 1 === $style_id){
    		?>
    		<li class="time-unit"><?php echo esc_html($suffix); ?></li>
    		<?php
    	} ?>
    	<?php
    	$limit = (int)apply_filters('nictiz_toolkit_get_number_of_features_pricing', 10);
    	for($i = 0; $i< $limit; $i++){
			$val = get_post_meta($post_id, "nictiz_toolkit_feature_{$i}", true);
			if($i % 2 == 0){
				$li_class = 'bullet-item even';
			}else{
				$li_class = 'bullet-item';
			}
			if($val){
				echo sprintf('<li class="%s">%s</li>',$li_class, wp_kses( $val, nictiz_toolkit_get_allowed_tags()) );
			}
		}
    	?>
    	<?php if(isset($button_label)){		
            ?>
            <li class="cta-button">
	            <a href="<?php echo esc_url($button_url); ?>" class="button" target="_blank" ><?php echo esc_html($button_label); ?></a>
	        </li>
            <?php
		} ?>
    </ul>
    <?php
    }

    $html = ob_get_contents();
    ob_end_clean();

    return apply_filters('nictiz_toolkit_shortcode_pricingtable', $html, $atts, $content);
}


	

	

