<?php
/**
 * Debug item
 *
 * @package SophiDebugBar
 */

namespace SophiDebugBar;

use WP_Post;

/**
 * Main class for debug item
 */
class Item {

	/**
	 * Whether this object is error
	 *
	 * @var boolean
	 */
	protected $is_error = false;

	/**
	 * Start timestamp
	 *
	 * @var float
	 */
	protected $start = 0.0;

	/**
	 * End timestamp
	 *
	 * @var float
	 */
	protected $end = 0.0;

	/**
	 * Request body
	 *
	 * @var string|array
	 */
	protected $request_body = '';

	/**
	 * Response body
	 *
	 * @var string|array
	 */
	protected $response_body = '';

	/**
	 * Response code
	 *
	 * @var integer
	 */
	protected $response_code = 0;

	/**
	 * Raw response data
	 *
	 * @var string
	 */
	public $raw_response = '';

	/**
	 * Associative array request context
	 *
	 * @var array
	 */
	public $request_context = array();

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->start = microtime( true );
	}

	/**
	 * Set end time
	 *
	 * @param integer|float $end End timestamp
	 * @return void
	 */
	public function set_end( $end = 0 ) {
		$this->end = $end;
	}

	/**
	 * Get end time
	 *
	 * @return integer|float
	 */
	public function get_end() {
		return $this->end;
	}

	/**
	 * Get total time
	 *
	 * @return integer|float
	 */
	public function get_time() {
		return $this->end - $this->start;
	}

	/**
	 * Set request body
	 *
	 * @param mixed $body body to set.
	 * @return void
	 */
	public function set_request_body( $body ) {
		$this->request_body = $body;
	}

	/**
	 * Get request body
	 *
	 * @return mixed
	 */
	public function get_request_body() {
		return $this->request_body;
	}

	/**
	 * Set response code
	 *
	 * @param integer $code Response code.
	 * @return void
	 */
	public function set_response_code( $code ) {
		$this->response_code = $code;
	}

	/**
	 * Get response code
	 *
	 * @return integer
	 */
	public function get_response_code() {
		return $this->response_code;
	}

	/**
	 * Set response body
	 *
	 * @param mixed $body Response body.
	 * @return void
	 */
	public function set_response_body( $body ) {
		$this->response_body = $body;
	}

	/**
	 * Get response body
	 *
	 * @return mixed
	 */
	public function get_response_body() {
		return $this->response_body;
	}

	/**
	 * Get error status
	 *
	 * @return boolean
	 */
	public function is_error() {
		return $this->is_error;
	}

	/**
	 * Set error status
	 *
	 * @param boolean $error Is error.
	 * @return void
	 */
	public function set_error( $error = false ) {
		$this->is_error = $error;
	}

	/**
	 * Set raw response
	 *
	 * @param mixed $raw_response Raw response
	 * @return void
	 */
	public function set_raw_response( $raw_response ) {
		$this->raw_response = $raw_response;
	}

	/**
	 * Set request context
	 *
	 * @param array $context Context.
	 * @return void
	 */
	public function set_request_context( $context ) {
		$this->request_context = $context;
	}

	/**
	 * Get request context
	 *
	 * @return array
	 */
	public function get_request_context() {
		return $this->request_context;
	}

	/**
	 * Return context as compact array
	 *
	 * @return array
	 */
	public function get_request_context_compact() {
		$context = $this->request_context;

		if ( isset( $context['post'] ) && $context['post'] instanceof WP_Post ) {
			$context['post'] = $context['post']->ID;
		}

		return $context;
	}

	/**
	 * Set response
	 *
	 * @param mixed $args Arguments.
	 * @return void
	 */
	public function set_response( $args ) {
	}

	/**
	 * Set request
	 *
	 * @param mixed $args Arguments.
	 * @return void
	 */
	public function set_request( $args ) {
	}
}
