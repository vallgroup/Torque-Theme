<?php

require( <torque_plugin_class_name>_PATH . '/api/<torque_plugin_slug>-rest-controller-class.php' );
require( <torque_plugin_class_name>_PATH . '/shortcode/<torque_plugin_slug>-shortcode-class.php' );
require( <torque_plugin_class_name>_PATH . '/cpt/<torque_plugin_slug>-cpt-class.php' );


/**
 * Autoload all other classes
 */
class <torque_plugin_class_name>_Autoloader {

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
