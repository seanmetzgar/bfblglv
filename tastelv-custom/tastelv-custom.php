<?php
/**
 * @package TasteLV - Customizations
 */
/*
Plugin Name: TasteLV - Customizations
Plugin URI:  http://code.wearekudu.com/wordpress/plugins/tastelv/custom/
Description: TasteLV WordPress Backend Customizations
Version:     2.0.0
Author:      Kudu Creative
Author URI:  http://wearekudu.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: tastelv-cust
*/

// Make sure we don"t expose any info if called directly
if ( !function_exists( "add_action" ) ) {
	echo "Hi there!  I\"m just a plugin, not much I can do when called directly.";
	exit;
}

define( "TASTELV_CUST__VERSION", "1.0.0" );
define( "TASTELV_CUST__MINIMUM_WP_VERSION", "4.0" );
define( "TASTELV_CUST__PLUGIN_URL", plugin_dir_url( __FILE__ ) );
define( "TASTELV_CUST__PLUGIN_DIR", plugin_dir_path( __FILE__ ) );

require_once( TASTELV_CUST__PLUGIN_DIR . "class.TasteLV_Customizations.php" );

add_action( "init", array( "TasteLV_Customizations", "init" ) );