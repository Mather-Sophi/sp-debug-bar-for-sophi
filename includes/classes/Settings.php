<?php
/**
 * Sophi Debug Bar Settings
 *
 * @package SophiDebugBar
 */

namespace SophiDebugBar;

use SophiDebugBar\Log;

use const SophiWP\Settings\SETTINGS_GROUP;

use function SophiWP\Settings\get_sophi_settings;

/**
 * Settings
 */
class Settings {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'fields' ), 20 );

		add_filter( 'sanitize_option_' . SETTINGS_GROUP, array( $this, 'sanitize' ), 10, 2 );

		add_action( 'admin_menu', array( $this, 'logs_menu' ) );
	}

	/**
	 * Add section and fields to the main plugin settings page
	 *
	 * @return void
	 */
	public function fields() {
		add_settings_section(
			'debug',
			__( 'Debug Bar Settings', 'debug-bar-for-sophi' ),
			'',
			SETTINGS_GROUP
		);

		add_settings_field(
			'enable_debug_log',
			__( 'Debug logging', 'debug-bar-for-sophi' ),
			array( $this, 'render_debug_log_field' ),
			SETTINGS_GROUP,
			'debug'
		);

		add_settings_field(
			'disable_sophi_caching',
			__( 'Sophi caching', 'debug-bar-for-sophi' ),
			array( $this, 'render_disable_sophi_caching' ),
			SETTINGS_GROUP,
			'debug'
		);
	}

	/**
	 * Add logs page under Tools
	 *
	 * @return void
	 */
	public function logs_menu() {
		add_management_page(
			__( 'Sophi Logs', 'debug-bar-for-sophi' ),
			__( 'Sophi Logs', 'debug-bar-for-sophi' ),
			'manage_options',
			'sophi-logs',
			array( $this, 'logs_page' )
		);
	}

	/**
	 * Render Sophi logs page
	 *
	 * @return void
	 */
	public function logs_page() {
		$files = glob( trailingslashit( SOPHI_DEBUG_BAR_LOG_PATH ) . 'sophi-*.log' );
		$dates = array();

		foreach ( $files as $file ) {
			if ( preg_match( '/.*?sophi-([\d\-]+)\.log/', $file, $match ) ) {
				$dates[] = $match[1];
			}
		}

		$dates = array_reverse( $dates );

		if ( isset( $_REQUEST['date'] ) ) {
			check_admin_referer( 'sophi-logs' );
			$current = sanitize_file_name( $_REQUEST['date'] );
		} else {
			$current = reset( $dates );
		}

		$log_file = trailingslashit( SOPHI_DEBUG_BAR_LOG_PATH ) . "sophi-{$current}.log";

		if ( ! file_exists( $log_file ) ) {
			esc_html_e( 'There is no log from Sophi.io available yet.', 'debug-bar-for-sophi' );
			return;
		}

		//phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$log_content = file_get_contents( $log_file );

		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Sophi Logs' ); ?></h1>
			<form method="post" action="">
				<select name="date" id="sophi_logs_date">
					<?php foreach ( $dates as $date ) : ?>
						<option value="<?php echo esc_attr( $date ); ?>" <?php echo selected( $date === $current ); ?>><?php echo esc_html( "sophi-{$date}.log" ); ?></option>
					<?php endforeach; ?>
				</select>
				<?php wp_nonce_field( 'sophi-logs' ); ?>
				<button type="submit" class="button"><?php esc_html_e( 'Show', 'debug-bar-for-sophi' ); ?></button>
			</form>

			<pre style="white-space: pre-wrap; word-wrap: break-word;"><?php echo wp_kses_post( $log_content ); ?></pre>
		</div>
		<?php
	}

	/**
	 * Return combined Sophi settings with debug
	 *
	 * @return array
	 */
	public static function get_settings() {
		$settings = get_sophi_settings();

		if ( ! isset( $settings['enable_debug_log'] ) ) {
			$settings['enable_debug_log'] = 'no';
		}

		if ( ! isset( $settings['disable_sophi_caching'] ) ) {
			$settings['disable_sophi_caching'] = 'no';
		}

		return $settings;
	}

	/**
	 * Render debug log field
	 *
	 * @return void
	 */
	public function render_debug_log_field() {
		$settings = $this->get_settings();

		if ( ! is_dir( SOPHI_DEBUG_BAR_LOG_PATH ) ) {
			Log\setup();
		}

		$is_writable = wp_is_writable( SOPHI_DEBUG_BAR_LOG_PATH );

		?>
		<label for="sophi-settings-enable_debug_log">
			<input
				type="checkbox"
				id="sophi-settings-enable_debug_log"
				name="sophi_settings[enable_debug_log]"
				value="yes"
				<?php checked( $is_writable && 'yes' === $settings['enable_debug_log'] ); ?>
				<?php disabled( ! $is_writable ); ?>
			/>
			<?php esc_html_e( 'Display verbose logging output from Sophi Authentication, Sophi API requests, and CMS publishing events', 'debug-bar-for-sophi' ); ?>
		</label>
		<?php

		if ( ! $is_writable ) {
			echo '<p class="description">';
			echo wp_kses_post(
				sprintf(
					/* translators: logs directory path */
					__( 'The logs directory <code>%s</code> is not writable.', 'debug-bar-for-sophi' ),
					esc_attr( SOPHI_DEBUG_BAR_LOG_PATH )
				)
			);
			echo '</p>';
		} else {
			echo '<p class="description">';
			echo '<a href="tools.php?page=sophi-logs">' . esc_html__( 'View Logs', 'debug-bar-for-sophi' ) . '</a>';
			echo '</p>';
		}
	}

	/**
	 * Render debug log field
	 *
	 * @return void
	 */
	public function render_disable_sophi_caching() {
		$settings = $this->get_settings();

		?>
		<label for="sophi-settings-disable_sophi_caching">
			<input
				type="checkbox"
				id="sophi-settings-disable_sophi_caching"
				name="sophi_settings[disable_sophi_caching]"
				value="yes"
				<?php checked( 'yes' === $settings['disable_sophi_caching'] ); ?>
			/>
			<?php esc_html_e( 'Disable WordPress caching of Sophi content', 'debug-bar-for-sophi' ); ?>
		</label>
		<?php
	}

	/**
	 * Sanitize debug log checkbox
	 *
	 * @param array  $value Sophi plugin settings array.
	 * @param string $option Option name.
	 * @return array
	 */
	public function sanitize( $value, $option ) {
		if ( SETTINGS_GROUP !== $option ) {
			return $value;
		}

		if ( ! isset( $value['enable_debug_log'] ) ) {
			$value['enable_debug_log'] = 'no';
		}

		if ( ! isset( $value['disable_sophi_caching'] ) ) {
			$value['disable_sophi_caching'] = 'no';
		}

		return $value;
	}
}
