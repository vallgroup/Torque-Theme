<?php

require( Torque_US_States_PATH . '/shortcode/torque-us-states-shortcode-class.php' );
require( Torque_US_States_PATH . '/cpt/torque-us-states-cpt-class.php' );


/**
 * Autoload all other classes
 */
class Torque_US_States_Autoloader {

	/**
	 * empty contructor on purpose.
	 */
	function __construct() {}

	/**
	 * load the classes based on class names passed in array
	 *
	 * @param  array $classes the class names to load
	 * @return void           does not return anything. instantiates the classese only
	 */
	public static function autoload( $classes ) {

		foreach ($classes as $class_name) {
			new $class_name();
		}
	}
}

?>
