<?php
/*
Plugin Name: Customization for imthestory.com
Description: Plugin will make Customization for imthestory.com
Version: 1.0.0
Author: Muhammad Atiq
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
    echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
    exit;
}

define( 'IMTHESTORY_PLUGIN_NAME', 'Customization for imthestory.com' );
define( 'IMTHESTORY_PLUGIN_PATH', plugin_dir_path(__FILE__) );
define( 'IMTHESTORY_PLUGIN_URL', plugin_dir_url(__FILE__) );
define( 'IMTHESTORY_SITE_BASE_URL',get_bloginfo('url'));

require_once IMTHESTORY_PLUGIN_PATH.'includes/imthestory_class.php';

register_activation_hook( __FILE__, array( 'IMTHESTORY', 'imthestory_install' ) );
register_deactivation_hook( __FILE__, array( 'IMTHESTORY', 'imthestory_uninstall' ) );