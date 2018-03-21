<?php
/**
 * @package DoubleSNAP - Customizations
 */
/*
Plugin Name: DoubleSNAP - Customizations
Plugin URI:  
Description: DoubleSNAP WordPress Backend Customizations
Version:     0.0.1
Author:      Sean Metzgar
Author URI:  http://www.seanmetzgar.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: snap-cust
*/

// Make sure we don"t expose any info if called directly
if ( !function_exists( "add_action" ) ) {
	echo "Hi there!  I\"m just a plugin, not much I can do when called directly.";
	exit;
}

define( "DOUBLESNAP_CUST__VERSION", "0.0.1" );
define( "DOUBLESNAP_CUST__MINIMUM_WP_VERSION", "4.0" );
define( "DOUBLESNAP_CUST__PLUGIN_URL", plugin_dir_url( __FILE__ ) );
define( "DOUBLESNAP_CUST__PLUGIN_DIR", plugin_dir_path( __FILE__ ) );

require_once( DOUBLESNAP_CUST__PLUGIN_DIR . "class.DoubleSNAP_Customizations.php" );

add_action( "init", array( "DoubleSNAP_Customizations", "init" ) );