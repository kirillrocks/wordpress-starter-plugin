<?php
/**
 * Created by CODEJA.
 * User: kirillrocks
 * Date: 24-Jan-17
 * Time: 21:29
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// CLASSES
require_once CJSP_PLUGIN_DIR . '/includes/classes/class-cjsp.php';
require_once CJSP_PLUGIN_DIR . '/includes/classes/class-cjsp-helper.php';

// DEFAULT FUNCTIONS
require_once CJSP_PLUGIN_DIR . '/includes/functions.php';

// SHORTCODES
require_once CJSP_PLUGIN_DIR . '/includes/shortcodes.php';

if ( is_admin() ) {
	require_once CJSP_PLUGIN_DIR . '/admin/admin.php';
} else {
	require_once CJSP_PLUGIN_DIR . '/includes/load.php';
}

// ON PLUGIN ACTIVATE
register_activation_hook( CJSP_PLUGIN, 'cjsp_activation' );
function cjbl_activation() {
    if ( $option = get_option( 'cjsp' ) ) {
        return;
    }

    CJSP::update_option( 'default_option', 'default option' );

    flush_rewrite_rules(); // RESET PERMALINKS
}

// ON PLUGIN DEACTIVATION
register_deactivation_hook( CJSP_PLUGIN, 'cjsp_deactivation' );
function cjsp_deactivation() {
    flush_rewrite_rules(); // RESET PERMALINKS
}