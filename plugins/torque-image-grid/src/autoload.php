<?php

require( Torque_Image_Grid_PATH . '/api/torque-image-grid-rest-controller-class.php' );
require( Torque_Image_Grid_PATH . '/shortcode/torque-image-grid-shortcode-class.php' );
require( Torque_Image_Grid_PATH . '/cpt/torque-image-grid-cpt-class.php' );


/**
 * Autoload all other classes
 */
class Torque_Image_Grid_Autoloader {

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
