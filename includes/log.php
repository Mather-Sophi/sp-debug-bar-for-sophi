<?php
/**
 * Debug Logger
 *
 * @package SophiDebugBar
 */

namespace SophiDebugBar\Log;

use SophiDebugBar\Settings;

/**
 * Initialize logs directory
 *
 * @return void
 */
function setup() {
	$htfilename = trailingslashit( SOPHI_DEBUG_BAR_LOG_PATH ) . '.htaccess';

	if ( wp_mkdir_p( SOPHI_DEBUG_BAR_LOG_PATH )
		&& ! file_exists( $htfilename ) ) {
		$file_handle = @fopen( $htfilename, 'wb' ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged, WordPress.WP.AlternativeFunctions.file_system_read_fopen
		if ( $file_handle ) {
			fwrite( $file_handle, 'deny from all' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fwrite
			fclose( $file_handle ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fclose
		}
	}
}

/**
 * Write log
 *
 * @param mixed $object Object to log
 * @return void
 */
function log( $object ) {
	$settings = Settings::get_settings();
	if ( 'yes' !== $settings['enable_debug_log'] ) {
		return;
	}

	$date     = date_i18n( 'Y-m-d' );
	$filename = SOPHI_DEBUG_BAR_LOG_PATH . "/sophi-{$date}.log";

	// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r -- Wirting debug information.
	$log = date_i18n( 'Y-m-d H:i:s' ) . "\n" . print_r( $object, true ) . "\n============\n";

	// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_file_put_contents -- Using to append file.
	file_put_contents( $filename, $log, FILE_APPEND );
}
