<?php
add_filter('nictiz_toolkit_get_elements', 'nictiz_toolkit_contactform_register_elements');


function nictiz_toolkit_contactform_register_elements($groups){
    $groups['contact-form'][] = array(
        'name' => esc_html__('Contact form 1','nictiz-toolkit'),
        'code' => '[nictiz_toolkit_contactform style="1"]'
        );
    $groups['contact-form'][] = array(
        'name' => esc_html__('Contact form 2','nictiz-toolkit'),
        'code' => '[nictiz_toolkit_contactform style="2"]'
        );
    return $groups;
}

add_shortcode('nictiz_toolkit_contactform', 'nictiz_toolkit_contactform_shortcode');

function nictiz_toolkit_contactform_shortcode($atts, $content = null) {
	$atts = shortcode_atts(array('button_position' => 'left', 'style' => 1), $atts);
    
    $style_id = isset($atts['style']) ? (int)$atts['style'] : 1 ;

    if($atts['button_position'] && 'right' == $atts['button_position']){
        $button_class = 'text-right';
    }else{
        $button_class = 'text_left';
    }
	ob_start();
    if(1 === (int)$style_id){
    	?>
    		<form class="contact-form" action="<?php echo admin_url('admin-ajax.php') ?>" novalidate="novalidate" method="post">
    			<div class="row">
    				<div class="col-md-6 col-sm-6 col-xs-12">
    					<div class="form-group">
            				<input type="text" name="name" placeholder="<?php esc_html_e('First name', 'nictiz-toolkit'); ?>" class="form-control">	
            			</div>
    				</div>
    				<div class="col-md-6 col-sm-6 col-xs-12">
    					<div class="form-group">
    						<input type="text" name="email" placeholder="<?php esc_html_e('Email Address', 'nictiz-toolkit'); ?>" class="form-control">	
    					</div>
    					
    				</div>
    			</div>
    			<div class="form-group">
    				<input type="text" name="subject" placeholder="<?php esc_html_e('Subject', 'nictiz-toolkit'); ?>" class="form-control">	
    			</div>
    			
    			<div class="form-group form-message">
    				<textarea name="message" placeholder="<?php esc_html_e('Enter your Message here', 'nictiz-toolkit'); ?>" class="form-control"></textarea>	
    			</div>
    			<p class="form-submit <?php echo esc_attr($button_class); ?>"><input id="submit-contact" type="submit" value="<?php esc_html_e('Submit', 'nictiz-toolkit'); ?>"></p>		        			
    			<input type="hidden" name="action" value="kopa_send_contact">
    			<?php echo wp_nonce_field('kopa_send_contact_nicole_kidman', 'kopa_send_contact_nonce', true, false); ?>
    		</form>
    		
    	<?php
    }else{
        ?>
        <form class="contact-form" action="<?php echo admin_url('admin-ajax.php') ?>" novalidate="novalidate" method="post">
            
            <div class="form-group">
                <input type="text" name="name" placeholder="<?php esc_html_e('First name', 'nictiz-toolkit'); ?>" class="form-control">  
            </div>
        
            <div class="form-group">
                <input type="text" name="email" placeholder="<?php esc_html_e('Email Address', 'nictiz-toolkit'); ?>" class="form-control">  
            </div>
            
            <div class="form-group form-message">
                <textarea name="message" placeholder="<?php esc_html_e('Enter your Message here', 'nictiz-toolkit'); ?>" class="form-control"></textarea>    
            </div>

            <p class="form-submit <?php echo esc_attr($button_class); ?>"><input id="submit-contact" type="submit" value="<?php esc_html_e('Submit', 'nictiz-toolkit'); ?>"></p>                         
            
            <input type="hidden" name="action" value="kopa_send_contact">
            <?php echo wp_nonce_field('kopa_send_contact_nicole_kidman', 'kopa_send_contact_nonce', true, false); ?>
        
        </form>
        <?php
    }
    ?>
    <div id="response"></div>
    <?php
	$string = ob_get_contents();
	ob_end_clean();

	return apply_filters( 'nictiz_toolkit_contactform_shortcode', $string, $atts, $content );
}



if (!function_exists('kopa_ajax_send_contact')) {

    function kopa_ajax_send_contact() {
        check_ajax_referer('kopa_send_contact_nicole_kidman', 'kopa_send_contact_nonce');

        foreach ($_POST as $key => $value) {
            if (ini_get('magic_quotes_gpc')) {
                $_POST[$key] = stripslashes($_POST[$key]);
            }
            $_POST[$key] = htmlspecialchars(strip_tags($_POST[$key]));
        }

        $name = $_POST["name"];
        $email = $_POST["email"];
        $message = $_POST["message"];

        $message_body = "Name: {$name}" . PHP_EOL . "Message: {$message}";

        $to = get_bloginfo('admin_email');
        if ( isset( $_POST["subject"] ) && $_POST["subject"] != '' )
            $subject = "Contact Form: $name - {$_POST['subject']}";
        else
            $subject = "Contact Form: $name";

        if ( isset( $_POST['url'] ) && $_POST['url'] != '' )
            $message_body .= PHP_EOL . esc_html__('Website:', 'nictiz-toolkit') . $_POST['url'];

        $headers[] = 'From: ' . $name . ' <' . $email . '>';
        $headers[] = 'Cc: ' . $name . ' <' . $email . '>';

        $result = '<span class="failure">' . esc_html__('Oops! errors occured.', 'nictiz-toolkit') . '</span>';
        if (wp_mail($to, $subject, $message_body, $headers)) {
            $result = '<span class="success">' . esc_html__('Success! Your email has been sent.', 'nictiz-toolkit') . '</span>';
        }

        die($result);
    }

    add_action('wp_ajax_kopa_send_contact', 'kopa_ajax_send_contact');
    add_action('wp_ajax_nopriv_kopa_send_contact', 'kopa_ajax_send_contact');
}