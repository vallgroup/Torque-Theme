<?php

require( Interra_Marketing_Automation_PATH . '/api/interra-marketing-automation-rest-controller-class.php' );
require( Interra_Marketing_Automation_PATH . '/shortcode/interra-marketing-automation-shortcode-class.php' );
require( Interra_Marketing_Automation_PATH . '/cpt/interra-marketing-automation-cpt-class.php' );
require( Interra_Marketing_Automation_PATH . '/cpt/interra-marketing-automation-income-expenses-class.php' );
require( Interra_Marketing_Automation_PATH . '/cpt/interra-marketing-automation-financial-summary-class.php' );


/**
 * Autoload all other classes
 */
class Interra_Marketing_Automation_Autoloader {

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
