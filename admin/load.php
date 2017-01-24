<?php
/**
 * Created by CODEJA.
 * User: kirillrocks
 * Date: 24-Jan-17
 * Time: 21:55
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

add_action('admin_init', 'cjsp_load_admin_pages');
function cjsp_load_admin_pages() {
    CJSP_Admin_Page::load();
}

add_action( 'admin_enqueue_scripts', 'cjsp_admin_enqueue' );
function cjsp_admin_enqueue( ) {
    if ( strpos( 'cjbl', $hook ) === false ) {
        wp_enqueue_script( 'cjbl-admin-javascript', CJBL_PLUGIN_URL . '/admin/assets/js/admin.js', array( 'jquery' ) );
        wp_enqueue_style( 'cjbl-admin-style', CJBL_PLUGIN_URL . '/admin/assets/css/admin.css' );

        wp_localize_script( 'cjbl-admin-javascript', 'ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
        );
    }
}
