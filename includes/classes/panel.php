<?php
/**
 * Sophi Debug Bar Panel
 *
 * @package SophiDebugBar
 */

namespace SophiDebugBar;

/**
 * Sophi Panel class
 */
class Panel extends \Debug_Bar_Panel {
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
	 * Constructor
	 */
	public function __construct() {
		$this->title( __( 'Sophi', 'sophi-debug-bar' ) );
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

}
