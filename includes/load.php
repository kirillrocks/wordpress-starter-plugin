<?php
/**
 * Created by CODEJA.
 * User: kirillrocks
 * Date: 24-Jan-17
 * Time: 21:33
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

add_action( 'plugins_loaded', 'cjsp' );
function cjsp() {
    add_shortcode( 'cjsp_default_shortcode', 'cjsp_default_shortcode' );
}