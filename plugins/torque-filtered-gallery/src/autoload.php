<?php

require( Torque_Filtered_Gallery_PATH . '/shortcode/torque-filtered-gallery-shortcode-class.php' );
require( Torque_Filtered_Gallery_PATH . '/api/torque-filtered-gallery-rest-controller-class.php' );
require( Torque_Filtered_Gallery_PATH . '/includes/cpt/torque-filtered-gallery-cpt-class.php' );

/**
 * Autoload all other classes
 */
class Torque_Filtered_Gallery_Autoloader {

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
