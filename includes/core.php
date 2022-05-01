<?php
/**
 * Core plugin functionality.
 *
 * @package SophiDebugBar
 */

namespace SophiDebugBar\Core;

use SophiDebugBar\Panel;
use \WP_Error;
use SophiDebugBar\Utility;


/**
 * Default setup routine
 *
 * @return void
 */
function setup() {
	$n = function( $function ) {
		return __NAMESPACE__ . "\\$function";
	};

	$errors   = array();
	$warnings = array();

	if ( ! defined( 'SOPHI_WP_VERSION' ) ) {
		$warnings[] = __( 'Sophi Debug Bar requires Sophi for WordPress plugin', 'sophi-debug-bar' );
	} elseif ( version_compare( SOPHI_WP_VERSION, '1.0.15', '<=' ) ) {
		$warnings[] = __( 'Sophi Debug Bar requires Sophi for WordPress version 1.0.14 or higher', 'sophi-debug-bar' );
	}

	if ( ! class_exists( 'Debug_Bar' ) ) {
		$errors[] = __( 'Sophi Debug Bar requires Debug Bar plugin', 'sophi-debug-bar' );
	}

	if ( ! empty( $warnings ) ) {
		show_notices( $warnings );
	}

	if ( ! empty( $errors ) ) {
		show_notices( $errors, 'error' );
		// Stop plugin.
		return;
	}

	add_action( 'init', $n( 'i18n' ) );
	add_action( 'init', $n( 'init' ) );
	add_action( 'wp_enqueue_scripts', $n( 'scripts' ) );
	add_action( 'wp_enqueue_scripts', $n( 'styles' ) );
	add_action( 'admin_enqueue_scripts', $n( 'admin_scripts' ) );
	add_action( 'admin_enqueue_scripts', $n( 'admin_styles' ) );

	// Editor styles. add_editor_style() doesn't work outside of a theme.
	add_filter( 'mce_css', $n( 'mce_css' ) );
	// Hook to allow async or defer on asset loading.
	add_filter( 'script_loader_tag', $n( 'script_loader_tag' ), 10, 2 );

	add_filter( 'debug_bar_panels', $n( 'add_panel' ) );

	do_action( 'sophi_debug_bar_loaded' );
}

/**
 * Registers the default textdomain.
 *
 * @return void
 */
function i18n() {
	$locale = apply_filters( 'plugin_locale', get_locale(), 'sophi-debug-bar' );
	load_textdomain( 'sophi-debug-bar', WP_LANG_DIR . '/sophi-debug-bar/sophi-debug-bar-' . $locale . '.mo' );
	load_plugin_textdomain( 'sophi-debug-bar', false, plugin_basename( SOPHI_DEBUG_BAR_PATH ) . '/languages/' );
}

/**
 * Initializes the plugin and fires an action other plugins can hook into.
 *
 * @return void
 */
function init() {
	do_action( 'sophi_debug_bar_init' );
}

/**
 * Activate the plugin
 *
 * @return void
 */
function activate() {
	// First load the init scripts in case any rewrite functionality is being loaded
	init();
	flush_rewrite_rules();
}

/**
 * Deactivate the plugin
 *
 * Uninstall routines should be in uninstall.php
 *
 * @return void
 */
function deactivate() {

}


/**
 * The list of knows contexts for enqueuing scripts/styles.
 *
 * @return array
 */
function get_enqueue_contexts() {
	return array( 'admin', 'frontend', 'shared' );
}

/**
 * Generate an URL to a script, taking into account whether SCRIPT_DEBUG is enabled.
 *
 * @param string $script Script file name (no .js extension)
 * @param string $context Context for the script ('admin', 'frontend', or 'shared')
 *
 * @return string|WP_Error URL
 */
function script_url( $script, $context ) {

	if ( ! in_array( $context, get_enqueue_contexts(), true ) ) {
		return new WP_Error( 'invalid_enqueue_context', 'Invalid $context specified in SophiDebugBar script loader.' );
	}

	return SOPHI_DEBUG_BAR_URL . "dist/js/${script}.js";

}

/**
 * Generate an URL to a stylesheet, taking into account whether SCRIPT_DEBUG is enabled.
 *
 * @param string $stylesheet Stylesheet file name (no .css extension)
 * @param string $context Context for the script ('admin', 'frontend', or 'shared')
 *
 * @return string URL
 */
function style_url( $stylesheet, $context ) {

	if ( ! in_array( $context, get_enqueue_contexts(), true ) ) {
		return new WP_Error( 'invalid_enqueue_context', 'Invalid $context specified in SophiDebugBar stylesheet loader.' );
	}

	return SOPHI_DEBUG_BAR_URL . "dist/css/${stylesheet}.css";

}

/**
 * Enqueue scripts for front-end.
 *
 * @return void
 */
function scripts() {

	wp_enqueue_script(
		'sophi_debug_bar_shared',
		script_url( 'shared', 'shared' ),
		Utility\get_asset_info( 'shared', 'dependencies' ),
		SOPHI_DEBUG_BAR_VERSION,
		true
	);

	wp_enqueue_script(
		'sophi_debug_bar_frontend',
		script_url( 'frontend', 'frontend' ),
		Utility\get_asset_info( 'frontend', 'dependencies' ),
		SOPHI_DEBUG_BAR_VERSION,
		true
	);

}

/**
 * Enqueue scripts for admin.
 *
 * @return void
 */
function admin_scripts() {

	wp_enqueue_script(
		'sophi_debug_bar_shared',
		script_url( 'shared', 'shared' ),
		Utility\get_asset_info( 'shared', 'dependencies' ),
		SOPHI_DEBUG_BAR_VERSION,
		true
	);

	wp_enqueue_script(
		'sophi_debug_bar_admin',
		script_url( 'admin', 'admin' ),
		Utility\get_asset_info( 'admin', 'dependencies' ),
		SOPHI_DEBUG_BAR_VERSION,
		true
	);

}

/**
 * Enqueue styles for front-end.
 *
 * @return void
 */
function styles() {

	wp_enqueue_style(
		'sophi_debug_bar_shared',
		style_url( 'shared', 'shared' ),
		array(),
		SOPHI_DEBUG_BAR_VERSION
	);

	if ( is_admin() ) {
		wp_enqueue_style(
			'sophi_debug_bar_admin',
			style_url( 'admin', 'admin' ),
			array(),
			SOPHI_DEBUG_BAR_VERSION
		);
	} else {
		wp_enqueue_style(
			'sophi_debug_bar_frontend',
			style_url( 'frontend', 'frontend' ),
			array(),
			SOPHI_DEBUG_BAR_VERSION
		);
	}

}

/**
 * Enqueue styles for admin.
 *
 * @return void
 */
function admin_styles() {

	wp_enqueue_style(
		'sophi_debug_bar_shared',
		style_url( 'shared', 'shared' ),
		array(),
		SOPHI_DEBUG_BAR_VERSION
	);

	wp_enqueue_style(
		'sophi_debug_bar_admin',
		style_url( 'admin', 'admin' ),
		array(),
		SOPHI_DEBUG_BAR_VERSION
	);

}

/**
 * Enqueue editor styles. Filters the comma-delimited list of stylesheets to load in TinyMCE.
 *
 * @param string $stylesheets Comma-delimited list of stylesheets.
 * @return string
 */
function mce_css( $stylesheets ) {
	if ( ! empty( $stylesheets ) ) {
		$stylesheets .= ',';
	}

	return $stylesheets . SOPHI_DEBUG_BAR_URL . ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ?
			'assets/css/frontend/editor-style.css' :
			'dist/css/editor-style.min.css' );
}

/**
 * Add async/defer attributes to enqueued scripts that have the specified script_execution flag.
 *
 * @link https://core.trac.wordpress.org/ticket/12009
 * @param string $tag    The script tag.
 * @param string $handle The script handle.
 * @return string
 */
function script_loader_tag( $tag, $handle ) {
	$script_execution = wp_scripts()->get_data( $handle, 'script_execution' );

	if ( ! $script_execution ) {
		return $tag;
	}

	if ( 'async' !== $script_execution && 'defer' !== $script_execution ) {
		return $tag;
	}

	// Abort adding async/defer for scripts that have this script as a dependency. _doing_it_wrong()?
	foreach ( wp_scripts()->registered as $script ) {
		if ( in_array( $handle, $script->deps, true ) ) {
			return $tag;
		}
	}

	// Add the attribute if it hasn't already been added.
	if ( ! preg_match( ":\s$script_execution(=|>|\s):", $tag ) ) {
		$tag = preg_replace( ':(?=></script>):', " $script_execution", $tag, 1 );
	}

	return $tag;
}

/**
 * Display notices in admin area
 *
 * @param string[] $warnings Warnings list.
 * @param string   $type Messages type.
 * @return void
 */
function show_notices( $warnings = array(), $type = 'warning' ) {
	if ( ! is_admin() ) {
		return;
	}

	if ( ! empty( $warnings ) ) {
		?>
		<div class="notice notice-<?php echo esc_attr( $type ); ?> is-dismissible">
			<?php foreach ( $warnings as $warning ) : ?>
			<p><?php echo esc_html( $warning ); ?></p>	
			<?php endforeach; ?>
		</div>
		<?php
	}
}

/**
 * Add Sophi to Debug Bar panels
 *
 * @param Debug_Bar_Panel[] $panels Debug Bar panels.
 * @return Debug_Bar_Panel[]
 */
function add_panel( $panels = array() ) {
	$panels[] = new Panel();
	return $panels;
}
