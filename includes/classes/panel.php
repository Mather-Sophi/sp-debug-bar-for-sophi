<?php
/**
 * Sophi Debug Bar Panel
 *
 * @package SophiDebugBar
 */

/**
 * Sophi Panel class
 */
class SophiDebugBarPanel extends \Debug_Bar_Panel {
	/**
	 * Sophi requests
	 *
	 * @var array
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

		add_filter( 'sophi_tracking_data', array( $this, 'tracking_start' ), 10, 4 );
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
							Response code: <?php echo esc_html( wp_remote_retrieve_response_code( $request['result'] ) ); ?>
						</div>
						<div class="sophi-request-header-item">
							Duration: <?php echo esc_html( number_format( $request['time'] * 1000 ) ); ?> ms
						</div>
						<div class="sophi-request-header-item">
							URL: <?php echo esc_html( $request['url'] ); ?>
						</div>
					</div>
					<div class="sophi-request-details">
						<div>
							<strong>Request</strong>
							<div class="sophi-json-view" id="sophi-request-body-<?php echo esc_attr( $key ); ?>">
								<?php echo esc_attr( $request['args']['body'] ); ?>
							</div>
						</div>
						<div>
							<strong>Response</strong>
							<div class="sophi-json-view" id="sophi-response-body-<?php echo esc_attr( $key ); ?>">
								<?php echo esc_attr( wp_remote_retrieve_body( $request['result'] ) ); ?>
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
		$start    = microtime( true );
		$debug_id = $this->gen_hash();

		$args['sophi_debug_id'] = $debug_id;

		$this->requests[ $debug_id ] = array(
			'is_error' => false,
			'start'    => $start,
			'args'     => $args,
			'url'      => $url,
		);

		return $args;
	}

	/**
	 * Start debugging Sophi tracking request
	 *
	 * @param array                    $data Data being send to tracking server.
	 * @param Snowplow\Tracker\Tracker $tracker Tracker.
	 * @param WP_Post                  $post Post object.
	 * @param string                   $action Tracking action. publish, update, delete or unpublish.
	 * @return array
	 */
	public function tracking_start( $data, $tracker, $post = null, $action = '' ) {
		$start    = microtime( true );
		$debug_id = $this->gen_hash();

		$tracker->sophi_debug_id = $debug_id;

		$this->requests[ $debug_id ] = array(
			'is_error' => false,
			'type'     => 'tracking',
			'start'    => $start,
			'data'     => $data,
			'post'     => $post,
			'action'   => $action,
		);

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

			$this->requests[ $debug_id ] = array(
				'is_error' => false,
				'args'     => $args,
				'url'      => $url,
			);
		}

		if ( isset( $this->requests[ $debug_id ] ) ) {
			$this->requests[ $debug_id ]['result'] = $request;
			$this->requests[ $debug_id ]['end']    = $end;

			$this->requests[ $debug_id ]['time'] = $end - $this->requests[ $debug_id ]['start'];

			$this->total_time += $this->requests[ $debug_id ]['time'];

			if ( is_wp_error( $request ) ) {
				$this->requests[ $debug_id ]['is_error'] = true;
				$this->num_errors++;
			} elseif ( 200 !== wp_remote_retrieve_response_code( $request ) ) {
				$this->requests[ $debug_id ]['is_error'] = true;
				$this->num_errors++;
			}
		}

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
		}

		$emitters = $tracker->returnEmitters();
		$results  = array();

		foreach ( $emitters as $emitter ) {
			$results = array_merge( $results, $emitter->returnRequestResults() );
		}

		$this->requests[ $debug_id ]['results'] = $results;

		$this->log( $this->requests[ $debug_id ] );
	}
}

return SophiDebugBarPanel::instance();
