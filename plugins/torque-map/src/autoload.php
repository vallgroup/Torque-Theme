<?php

require( Torque_Map_PATH . '/api/torque-map-rest-controller-class.php' );
require( Torque_Map_PATH . '/shortcode/torque-map-shortcode-class.php' );
require( Torque_Map_PATH . '/cpt/torque-map-cpt-class.php' );
require( Torque_Map_PATH . '/acf/torque-map-acf-class.php' );


/**
 * Autoload all other classes
 */
class Torque_Map_Autoloader {

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