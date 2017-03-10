<?php
/**
 * @package BFBL-GLV - Buy Local Challenge
 */
/*
Plugin Name: BFBL-GLV - Buy Local Challenge
Plugin URI:  http://code.wearekudu.com/wordpress/plugins/bfblglv/challenge/
Description: BFBL-GLV Buy Local Challenge Customizations
Version:     1.5.1
Author:      Kudu Creative
Author URI:  http://wearekudu.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: bfblglv-blc
*/

// Make sure we don"t expose any info if called directly
if ( !function_exists( "add_action" ) ) {
	echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
	exit;
}

define( "BFBLGLV_BLC__VERSION", "1.5.1" );
define( "BFBLGLV_BLC__DB_VERSION", "1.5.1" );
define( "BFBLGLV_BLC__MINIMUM_WP_VERSION", "4.0" );
define( "BFBLGLV_BLC__PLUGIN_URL", plugin_dir_url( __FILE__ ) );
define( "BFBLGLV_BLC__PLUGIN_DIR", plugin_dir_path( __FILE__ ) );
define( "BFBLGLV_BLC__PAGE_SLUG", "options-buy-local-challenge" );

ini_set("log_errors", 1);
ini_set("error_log", BFBLGLV_BLC__PLUGIN_DIR . "/log/php-error.log");

require_once( BFBLGLV_BLC__PLUGIN_DIR . "class.BFBL_GLV_Challenge.php" );

register_activation_hook( __FILE__, array( "BFBL_GLV_Challenge", "run_install" ) );
add_action('init', array( "BFBL_GLV_Challenge", "init_session" ), 1);
add_action( "admin_menu", array( "BFBL_GLV_Challenge", "add_admin_pages" ) );
add_action( "admin_enqueue_scripts", array( "BFBL_GLV_Challenge", "admin_enqueue_scripts" ), 1 );
add_action( "wp_enqueue_scripts", array( "BFBL_GLV_Challenge", "wp_enqueue_scripts" ) );

add_action("wp_ajax_xhr_download_pledges", array( "BFBL_GLV_Challenge", "xhr_download_pledges" ) );
add_action("wp_ajax_nopriv_xhr_bfblglv_blc_add_data", array( "BFBL_GLV_Challenge", "xhr_bfblglv_blc_add_data" ) );
add_action("wp_ajax_xhr_bfblglv_blc_add_data", array( "BFBL_GLV_Challenge", "xhr_bfblglv_blc_add_data" ) );

add_shortcode( "blc", array("BFBL_GLV_Challenge", "blc_shortcode") );