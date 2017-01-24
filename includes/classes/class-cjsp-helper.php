<?php

/**
 * Created by CODEJA.
 * User: kirillrocks
 * Date: 24-Jan-17
 * Time: 21:27
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class CJSP_Helper {

    /**
     * Check if option is selected in <select>
     *
     * @param $value_in_question
     * @param $value
     * @return null
     */
    public static function is_selected( $value_in_question, $value ) {
        if ( $value_in_question == $value ) {
            echo ' selected ';
        } else {
            return null;
        }
    }
}