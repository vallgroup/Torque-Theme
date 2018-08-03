<?php

 /**
  * Plugin Name: <torque_plugin_name>
  * Description:
  * Version:     1.0.0
  * Author:      Torque
  * Author URI:  https://torque.digital
  * License:     GPL
  *
  * @package <torque_plugin_name>
  */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require( plugin_dir_path(__FILE__) . '/api/<torque_plugin_slug>-rest-controller-class.php' );

/**
 * Define constants for plugin's url and path
 */
define( '<torque_plugin_class_name>_PATH', plugin_dir_path(__FILE__) );
define( '<torque_plugin_class_name>_URL', plugin_dir_url(__FILE__) );

class <torque_plugin_class_name> {

	public static $PLUGIN_NAME = '<torque_plugin_name>';

	public static $PLUGIN_SLUG = '<torque_plugin_slug>';

	public static $SHORTCODE_SLUG = '<torque_plugin_shortcode>';

	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	/**
   * This should be a function which registers all the plugin's required hooks.
   */
	public function init() {
		new <torque_plugin_class_name>_REST_Controller();

		// register plugin shortcode
		add_shortcode( self::$SHORTCODE_SLUG , array( $this, 'shortcode_handler') );
	}

	/**
	 * Callback for the plugin shortcode
	 */
	public function shortcode_handler() {}

}

new <torque_plugin_class_name>();

?>
