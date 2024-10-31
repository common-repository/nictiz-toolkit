<?php
/**
 * Plugin Name: Nictiz Toolkit
 * Description: A specific plugin use in Nictiz Theme to help you register post types, widgets and shortcodes.
 * Version: 1.0.0
 * Author: Kopatheme
 * Author URI: http://kopatheme.com
 * License: GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * Nictiz Toolkit plugin, Copyright 2016 Kopatheme.com
 * Nictiz Toolkit is distributed under the terms of the GNU GPL
 *
 * Requires at least: 4.4
 * Tested up to: 4.6.1
 * Text Domain: nictiz-toolkit
 * Domain Path: /languages/
 *
 * @package Nictiz
 * @subpackage Nictiz Toolkit
 */

define( 'NICTIZ_TOOLKIT_DIR', plugin_dir_url( __FILE__ ) );
define( 'NICTIZ_TOOLKIT_PATH', plugin_dir_path( __FILE__ ) );

add_action( 'plugins_loaded', array( 'Nictiz_Toolkit', 'plugins_loaded' ) );	
add_action( 'after_setup_theme', array( 'Nictiz_Toolkit', 'after_setup_theme' ), 25 );	

class Nictiz_Toolkit {

	function __construct(){		
		
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 15 );
		add_action( 'nictiz_share_post', 'nictiz_toolkit_single_share_post' );
		add_filter( 'excerpt_more', '__return_null' );

		if ( is_admin() ) {
			add_filter( 'user_contactmethods', array( 'Nictiz_Toolkit', 'add_user_socials' ) );
		} else {
			add_filter( 'widget_text', 'do_shortcode' );
			add_action( 'nictiz_print_single_post_author', 'nictiz_toolkit_print_single_post_author' );
		}

		# UTILITY.
		require NICTIZ_TOOLKIT_PATH . 'inc/utility.php';

		# METABOX-FIELD.
		require_once NICTIZ_TOOLKIT_PATH . 'inc/fields/metabox/post.php';	
		require_once NICTIZ_TOOLKIT_PATH . 'inc/fields/metabox/meta-like.php';	

		# POSTTYPES.
		require NICTIZ_TOOLKIT_PATH . 'inc/post-types/service/service.php';
		require NICTIZ_TOOLKIT_PATH . 'inc/post-types/portfolio/portfolio.php';
		require NICTIZ_TOOLKIT_PATH . 'inc/post-types/client/client.php';
		require NICTIZ_TOOLKIT_PATH . 'inc/post-types/testimonial/testimonial.php';
		require NICTIZ_TOOLKIT_PATH . 'inc/post-types/staff/staff.php';
		require NICTIZ_TOOLKIT_PATH . 'inc/post-types/post/post.php';
		require NICTIZ_TOOLKIT_PATH . 'inc/post-types/contact/contact.php';
		require NICTIZ_TOOLKIT_PATH . 'inc/post-types/slides/slide.php';
		require NICTIZ_TOOLKIT_PATH . 'inc/post-types/skill/skill.php';

		# WIDGETS.
		require NICTIZ_TOOLKIT_PATH . 'inc/widgets/about-site.php';
		require NICTIZ_TOOLKIT_PATH . 'inc/widgets/flickr.php';
		require NICTIZ_TOOLKIT_PATH . 'inc/widgets/recent-comment.php';
        require NICTIZ_TOOLKIT_PATH . 'inc/widgets/tagline.php';

		# SHORTCODES.
		require_once( NICTIZ_TOOLKIT_PATH . 'inc/shortcode-util.php' );
		
		$nictiz_toolkit_dirs = 'inc/shortcodes/';

		$path  = NICTIZ_TOOLKIT_PATH . $nictiz_toolkit_dirs . '*.php';
		$files = glob( $path );

		if ( $files ) {
		    foreach ( $files as $file ) {
		        require_once $file;
		    }
		}		

	}

	public static function admin_enqueue_scripts() {
		global $pagenow;
		
		if ( in_array( $pagenow, array( 'post.php', 'post-new.php', 'widgets.php' ) ) ) {
			wp_enqueue_style( 'kopa_font_awesome' );
			wp_enqueue_style( 'nictitate-lite-toolkit-metabox', plugins_url( "assets/css/metabox.css", __FILE__ ), NULL, NULL );
		} elseif ( in_array( $pagenow, array( 'edit.php' ) ) ) {
			wp_enqueue_style( 'nictiz-toolkit-manage-colums', plugins_url( "assets/css/manage-colums.css", __FILE__ ), NULL, NULL );		
		}
	}

	public static function plugins_loaded() {
		load_plugin_textdomain( 'nictiz-toolkit', false, NICTIZ_TOOLKIT_PATH . '/languages/' );
	}

	public static function after_setup_theme() {
		if ( ! class_exists( 'Kopa_Framework' ) )
			return; 		
		else	
			new Nictiz_Toolkit();							
	}

	public static function add_user_socials( $methods ) {
		$methods['facebook']    = esc_html__( 'Facebook', 'nictiz-toolkit' );
		$methods['twitter']     = esc_html__( 'Twitter', 'nictiz-toolkit' );
		$methods['rss'] 		= esc_html__( 'Rss', 'nictiz-toolkit' );
		$methods['pinterest']   = esc_html__( 'Pinterest', 'nictiz-toolkit' );
		$methods['google_plus'] = esc_html__( 'Google Plus', 'nictiz-toolkit' );
        
		return $methods;
	}
}