<?php
/**
 * Request debug item
 *
 * @package SophiDebugBar
 */

namespace SophiDebugBar;

/**
 * Request debug item class
 */
class Event extends Item {

	/**
	 * Set response
	 *
	 * @param array $response Response from Snowball.
	 * @return void
	 */
	public function set_response( $response ) {
		$this->set_response_code( $response['code'] );
		$this->set_response_body( $response['data'] );
	}
}
