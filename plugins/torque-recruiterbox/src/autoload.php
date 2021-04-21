<?php

require( Torque_RecruiterBox_PATH . '/api/torque-recruiterbox-rest-controller-class.php' );
require( Torque_RecruiterBox_PATH . '/shortcode/torque-recruiterbox-shortcode-class.php' );
require( Torque_RecruiterBox_PATH . '/cpt/torque-recruiterbox-cpt-class.php' );


/**
 * Autoload all other classes
 */
class Torque_RecruiterBox_Autoloader {

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
