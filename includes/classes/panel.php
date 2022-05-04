<?php
/**
 * Sophi Debug Bar Panel
 *
 * @package SophiDebugBar
 */

use SophiDebugBar\Event;
use SophiDebugBar\Request;

/**
 * Sophi Panel class
 */
class SophiDebugBarPanel extends \Debug_Bar_Panel {
	/**
	 * Sophi requests
	 *
	 * @var SophiDebugBar\Item[]
	 */
	private $requests = array();

	/**
	 * Total time in milliseconds
	 *
	 * @var integer
	 */
	private $total_time = 0;

	/**
	 * Number of errors
	 *
	 * @var integer
	 */
	private $num_errors = 0;

	/**
	 * Instance
	 *
	 * @var SophiDebugBarPanel
	 */
	protected static $instance = null;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->title( __( 'Sophi', 'sophi-debug-bar' ) );

		add_filter( 'sophi_request_args', array( $this, 'request_start' ), 10, 2 );
		add_filter( 'sophi_request_result', array( $this, 'request_end' ), 10, 3 );

		add_filter( 'sophi_tracking_request_data', array( $this, 'tracking_start' ), 10, 4 );
		add_action( 'sophi_tracking_result', array( $this, 'tracking_end' ), 10, 4 );

		add_filter( 'sophi_tracker_emitter_debug', '__return_true' );
	}

	/**
	 * Main Sophi Panel Instance.
	 *
	 * Ensures only one instance of Sophi Panel is loaded or can be loaded.
	 *
	 * @static
	 * @return SophiDebugBarPanel - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Adds warning class to Debug Bar menu item
	 *
	 * @param string[] $classes Debug Bar classes.
	 * @return string[]
	 */
	public function debug_bar_classes( $classes = array() ) {
		if ( $this->num_errors > 0 ) {
			$classes[] = 'debug-bar-php-warning-summary';
		}
		return $classes;
	}

	/**
	 * Display panel content
	 *
	 * @return void
	 */
	public function render() {
		$requests = $this->requests;
		$history  = get_transient( 'sophi_debug_history' );

		$history = array_reverse( $history );

		if ( is_array( $history ) ) {
			$requests = array_merge( $requests, $history );
		}

		if ( is_array( $requests ) && count( $requests ) > 0 ) {
			echo '<div class="sophi-debug-bar-requests">';
			$c = 0;
			foreach ( $requests as $key => $request ) {
				$c++;
				?>
				<div class="sophi-request" id="sophi-request-<?php echo esc_attr( $key ); ?>">
					<div class="sophi-request-header">
						<div class="sophi-request-header-item">
							#<?php echo esc_html( $c ); ?>
						</div>
						<div class="sophi-request-header-item">
							Response code: <?php echo esc_html( $request->get_response_code() ); ?>
						</div>
						<div class="sophi-request-header-item">
							Duration: <?php echo esc_html( number_format( $request->get_time() ) ); ?> ms
						</div>
						<div class="sophi-request-header-item">
							Context:
							<?php
							foreach ( $request->get_request_context_compact() as $context_key => $context_value ) {
								echo '<span>' . esc_attr( $context_key ) . ':</span>';
								echo esc_attr( var_export( $context_value ) ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_var_export
							}
							?>
						</div>
					</div>
					<div class="sophi-request-details">
						<div>
							<strong>Request</strong>
							<div class="sophi-json-view" id="sophi-request-body-<?php echo esc_attr( $key ); ?>">
								<?php echo esc_attr( $request->get_request_body() ); ?>
							</div>
						</div>
						<div>
							<strong>Response</strong>
							<div class="sophi-json-view" id="sophi-response-body-<?php echo esc_attr( $key ); ?>">
								<?php echo esc_attr( $request->get_response_body() ); ?>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
			echo '</div>';
		}
	}

	/**
	 * Write log
	 *
	 * @param mixed $object Object to log
	 * @return void
	 */
	public function log( $object ) {
		$date     = date_i18n( 'Y-m-d' );
		$filename = SOPHI_DEBUG_BAR_LOG_PATH . "/sophi-{$date}.log";

		if ( ! is_dir( SOPHI_DEBUG_BAR_LOG_PATH ) ) {
			mkdir( SOPHI_DEBUG_BAR_LOG_PATH );
		}

		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r -- Wirting debug information.
		$log = date_i18n( 'Y-m-d H:i:s' ) . "\n" . print_r( $object, true ) . "\n============\n";

		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_file_put_contents -- Using to append file.
		file_put_contents( $filename, $log, FILE_APPEND );
	}

	/**
	 * Return random 8-char hash
	 *
	 * @return string
	 */
	public function gen_hash() {
		$start = microtime( true );
		$hash  = substr( wp_hash( $start . wp_rand() ), 0, 8 );
		return $hash;
	}

	/**
	 * Start debugging Sophi request
	 *
	 * @param array  $args WP HTTP request arguments.
	 * @param string $url The request URL.
	 * @return array
	 */
	public function request_start( $args = array(), $url = '' ) {
		$debug_id = $this->gen_hash();

		$args['sophi_debug_id'] = $debug_id;

		$request = new Request();
		$request->set_request( $args );
		$request->set_request_context( array( 'url' => $url ) );

		$this->requests[ $debug_id ] = $request;

		return $args;
	}

	/**
	 * Start debugging Sophi tracking request
	 *
	 * @param array|string             $data Data being send to tracking server.
	 * @param Snowplow\Tracker\Tracker $tracker Tracker.
	 * @param WP_Post                  $post Post object.
	 * @param string                   $action Tracking action. publish, update, delete or unpublish.
	 * @return array
	 */
	public function tracking_start( $data, $tracker = null, $post = null, $action = '' ) {
		$debug_id = $this->gen_hash();

		$tracker->sophi_debug_id = $debug_id;

		$event = new Event();

		// Check if data is already a json string.
		if ( is_string( $data ) && null !== json_decode( $data ) ) {
			$body = $data;
		} else {
			$body = wp_json_encode( $data );
		}

		$event->set_request_body( $body );
		$event->set_request_context(
			array(
				'post'   => $post,
				'action' => $action,
			)
		);

		$this->requests[ $debug_id ] = $event;

		return $data;
	}

	/**
	 * End debugging Sophi request
	 *
	 * @param array|WP_Error $request Result of HTTP request.
	 * @param array          $args HTTP request arguments.
	 * @param string         $url The request URL.
	 * @return array|WP_Error
	 */
	public function request_end( $request = array(), $args = array(), $url = '' ) {
		$end = microtime( true );

		if ( isset( $args['sophi_debug_id'] ) ) {
			$debug_id = $args['sophi_debug_id'];
		} else {
			// For some reason, Panel::request_start() was not called
			// prior to this result, the debug ID was not assigned.
			$debug_id = 'unhandled' . $this->gen_hash();

			$req = new Request();
			$req->set_request( $args );
			$req->set_request_context( array( 'url' => $url ) );

			$this->requests[ $debug_id ] = $req;
		}

		if ( isset( $this->requests[ $debug_id ] ) ) {
			$this->requests[ $debug_id ]->set_response( $request );
			$this->requests[ $debug_id ]->set_end( $end );

			$this->total_time += $this->requests[ $debug_id ]->get_time();

			if ( is_wp_error( $request ) ) {
				$this->requests[ $debug_id ]->set_error( true );
				$this->num_errors++;
			} elseif ( 200 !== wp_remote_retrieve_response_code( $request ) ) {
				$this->requests[ $debug_id ]->set_error( true );
				$this->num_errors++;
			}
		}

		$this->save( $debug_id, $this->requests[ $debug_id ] );
		$this->log( $this->requests[ $debug_id ] );

		return $request;
	}

	/**
	 * End debugging Sophi tracking request
	 *
	 * @param array                    $data Data being send to tracking server.
	 * @param Snowplow\Tracker\Tracker $tracker Tracker.
	 * @param WP_Post                  $post Post object.
	 * @param string                   $action Tracking action. publish, update, delete or unpublish.
	 */
	public function tracking_end( $data, $tracker, $post = null, $action = '' ) {
		$end = microtime( true );

		if ( isset( $tracker->sophi_debug_id ) ) {
			$debug_id = $tracker->sophi_debug_id;
		} else {
			$debug_id = 'unhandled' . $this->gen_hash();

			$event = new Event();
			$event->set_request_body( $data );
			$event->set_request_context(
				array(
					'post'   => $post,
					'action' => $action,
				)
			);

			$this->requests[ $debug_id ] = $event;
		}

		$this->requests[ $debug_id ]->set_end( $end );

		$emitters = $tracker->returnEmitters();
		$results  = array();

		foreach ( $emitters as $emitter ) {
			$results = array_merge( $results, $emitter->returnRequestResults() );
		}

		$this->requests[ $debug_id ]->set_response( reset( $results ) );

		$this->save( $debug_id, $this->requests[ $debug_id ] );
		$this->log( $this->requests[ $debug_id ] );
	}

	/**
	 * Save debug bar entries to database cache
	 *
	 * @param string             $key History key.
	 * @param SophiDebugBar\Item $data History item.
	 * @return void
	 */
	public function save( $key, $data ) {
		$size    = apply_filters( 'sophi_debug_history_size', 10 );
		$ttl     = apply_filters( 'sophi_debug_history_ttl', HOUR_IN_SECONDS );
		$history = get_transient( 'sophi_debug_history' );
		$expire  = time() - $ttl;

		if ( is_array( $history ) ) {
			// Remove expired items
			foreach ( $history as $item_key => $item ) {
				$end = $item->get_end();
				if ( $end < $expire ) {
					unset( $history[ $item_key ] );
				}
			}

			$history[ $key ] = $data;

			// Remove older item if size exceeds.
			if ( count( $history ) > $size ) {
				array_shift( $history );
			}
		} else {
			$history = array( $key => $data );
		}

		set_transient( 'sophi_debug_history', $history, $ttl );
	}
}

return SophiDebugBarPanel::instance();
