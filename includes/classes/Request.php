<?php
/**
 * Request debug item
 *
 * @package SophiDebugBar
 */

namespace SophiDebugBar;

use WP_HTTP_Requests_Response;

/**
 * Request debug item class
 */
class Request extends Item {

	/**
	 * Set request from WP_HTTP_Request args
	 *
	 * @param array $args Request arguments
	 * @return void
	 */
	public function set_request( $args ) {
		if ( isset( $args['body'] ) ) {
			$this->set_request_body( $args['body'] );
		}
	}

	/**
	 * Set response data from WP HTTP Response
	 *
	 * @param array $response Response.
	 * @return void
	 */
	public function set_response( $response ) {
		$this->set_response_code( wp_remote_retrieve_response_code( $response ) );
		$this->set_response_body( wp_remote_retrieve_body( $response ) );
		if ( $response['http_response'] instanceof WP_HTTP_Requests_Response ) {
			$response_object = $response['http_response']->get_response_object();
			if ( isset( $response_object->raw ) ) {
				$this->set_raw_response( $response_object->raw );
			}
		}
	}
}
