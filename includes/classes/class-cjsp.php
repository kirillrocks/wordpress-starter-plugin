<?php
/**
 * Created by CODEJA.
 * User: kirillrocks
 * Date: 24-Jan-17
 * Time: 21:23
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class CJSP {
	public static function get_option( $name, $default = false ) {
		$option = get_option( 'cjsp' );

		if ( false === $option ) {
			return $default;
		}

		if ( isset( $option[ $name ] ) ) {
			return $option[ $name ];
		} else {
			return $default;
		}
	}

	public static function update_option( $name, $value ) {
		$option = get_option( 'cjsp' );
		$option = ( false === $option ) ? array() : (array) $option;
		$option = array_merge( $option, array( $name => $value ) );
		update_option( 'cjsp', $option );
	}

	public static function delete_option( $name ) {
		$option = get_option( 'cjsp' );
		$option = ( false === $option ) ? array() : (array) $option;
		unset( $option[ $name ] );
		update_option( 'cjsp', $option );
	}

	public static function add_log( $action, $description, $file = null, $line = null ) {
		$logs = self::get_logs();

		$backtrace = debug_backtrace();

		$logs[] = array(
			'action'      => $action,
			'description' => $description,
			'time'        => time(),
			'file'        => $backtrace[0]['file'],
		);

		self::update_option( 'logs', $logs );
	}

	public static function get_logs() {
		$logs = self::get_option( 'logs' );
		$logs = ( false === $logs ) ? array() : (array) $logs;

		//usort( $logs, 'cjsp_sorting_array' );

		return $logs;
	}
}