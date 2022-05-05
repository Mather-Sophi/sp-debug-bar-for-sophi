<?php
/**
 * Sophi Debug Bar Settings
 *
 * @package SophiDebugBar
 */

namespace SophiDebugBar;

use function SophiWP\Settings\get_sophi_settings;

/**
 * Settings
 */
class Settings {

	const SETTINGS_GROUP = 'sophi_settings';

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'fields' ), 20 );

		add_filter( 'sanitize_option_{self::SETTINGS_GROUP}', array( $this, 'sanitize' ), 10, 2 );
	}

	/**
	 * Add section and fields to the main plugin settings page
	 *
	 * @return void
	 */
	public function fields() {
		add_settings_section(
			'debug',
			__( 'Debug', 'sophi-debug-bar' ),
			'',
			self::SETTINGS_GROUP
		);

		add_settings_field(
			'enable_debug_log',
			__( 'Debug log', 'sophi-debug-bar' ),
			array( $this, 'render_debug_log_field' ),
			self::SETTINGS_GROUP,
			'debug'
		);
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

		return $settings;
	}

	/**
	 * Render debug log field
	 *
	 * @return void
	 */
	public function render_debug_log_field() {
		$settings = $this->get_settings();
		?>
		<label for="sophi-settings-enable_debug_log"><input type="checkbox" id="sophi-settings-enable_debug_log" class="" name="sophi_settings[enable_debug_log]" value="yes" <?php checked( 'yes' === $settings['enable_debug_log'] ); ?>> <?php esc_html_e( 'Enable debug log' ); ?></label>
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
		if ( self::SETTINGS_GROUP !== $option ) {
			return $value;
		}

		if ( ! isset( $value['enable_debug_log'] ) ) {
			$value['enable_debug_log'] = 'no';
		}

		return $value;
	}
}
