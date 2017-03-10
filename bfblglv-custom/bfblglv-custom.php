<?php
/**
 * @package BFBL-GLV - Customizations
 */
/*
Plugin Name: BFBL-GLV - Customizations
Plugin URI:  http://code.wearekudu.com/wordpress/plugins/bfblglv/custom/
Description: BFBL-GLV WordPress Backend Customizations
Version:     2.0.2
Author:      Kudu Creative
Author URI:  http://wearekudu.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: bfblglv-cust
*/

// Make sure we don"t expose any info if called directly
if ( !function_exists( "add_action" ) ) {
	echo "Hi there!  I\"m just a plugin, not much I can do when called directly.";
	exit;
}

define( "BFBLGLV_CUST__VERSION", "2.0.1" );
define( "BFBLGLV_CUST__MINIMUM_WP_VERSION", "4.0" );
define( "BFBLGLV_CUST__PLUGIN_URL", plugin_dir_url( __FILE__ ) );
define( "BFBLGLV_CUST__PLUGIN_DIR", plugin_dir_path( __FILE__ ) );

require_once( BFBLGLV_CUST__PLUGIN_DIR . "class.BFBL_GLV_Customizations.php" );

register_activation_hook( __FILE__, array( "BFBL_GLV_Customizations", "add_roles_on_plugin_activation" ) );
add_action( "init", array( "BFBL_GLV_Customizations", "init" ) );
add_action( "admin_menu", array( "BFBL_GLV_Customizations", "add_admin_pages" ) );
add_action( "admin_enqueue_scripts", array( "BFBL_GLV_Customizations", "admin_enqueue_scripts" ), 1 );
add_action( "activated_plugin", array( "BFBL_GLV_Customizations", "tl_save_error" ) );