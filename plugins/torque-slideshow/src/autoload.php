<?php

require( Torque_Slideshow_PATH . '/api/torque-slideshow-rest-controller-class.php' );
require( Torque_Slideshow_PATH . '/shortcode/torque-slideshow-shortcode-class.php' );
require( Torque_Slideshow_PATH . '/cpt/torque-slideshow-cpt-class.php' );


/**
 * Autoload all other classes
 */
class Torque_Slideshow_Autoloader {

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
