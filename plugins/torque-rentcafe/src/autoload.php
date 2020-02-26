<?php

require( Torque_Rentcafe_PATH . '/api/torque-rentcafe-rest-controller-class.php' );
require( Torque_Rentcafe_PATH . '/shortcode/torque-rentcafe-shortcode-class.php' );
require( Torque_Rentcafe_PATH . '/includes/acf/torque-rentcafe-acf-class.php' );


/**
 * Autoload all other classes
 */
class Torque_Rentcafe_Autoloader {

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
