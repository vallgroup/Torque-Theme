<?php

require( Torque_Building_Facts_PATH . '/cpt/torque-building-facts-cpt-class.php' );


/**
 * Autoload all other classes
 */
class Torque_Building_Facts_Autoloader {

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
