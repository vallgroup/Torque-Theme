<?php

require( Torque_Rentcafe_Tour_PATH . '/api/torque-rentcafe-tour-rest-controller-class.php' );
require( Torque_Rentcafe_Tour_PATH . '/shortcode/torque-rentcafe-tour-shortcode-class.php' );
require( Torque_Rentcafe_Tour_PATH . '/cpt/torque-rentcafe-tour-cpt-class.php' );


/**
 * Autoload all other classes
 */
class Torque_Rentcafe_Tour_Autoloader {

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
