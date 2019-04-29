<?php

require( Torque_Filtered_Loop_PATH . '/shortcode/torque-filtered-loop-shortcode-class.php' );
require( Torque_Filtered_Loop_PATH . '/api/torque-filtered-loop-rest-controller-class.php' );

/**
 * Autoload all other classes
 */
class Torque_Filtered_Loop_Autoloader {

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
