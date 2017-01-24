<?php

/*
Plugin Name: Cj Social Plugin
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: A brief description of the Plugin.
Version: 1.0
Author: k
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

define( 'CJSP_VERSION', '1.0' );

define( 'CJSP_REQUIRED_WP_VERSION', '4' );

define( 'CJSP_PLUGIN', __FILE__ );

define( 'CJSP_PLUGIN_DIR', untrailingslashit( dirname( CJSP_PLUGIN ) ) );

define( 'CJSP_PLUGIN_URL', plugin_dir_url( CJSP_PLUGIN ) );

define( 'CJSP_PLUGIN_NAME', 'Social Plugin' );

require_once CJSP_PLUGIN_DIR . '/bootstrap.php';