<?php

/**
 * __GET STARTED__
 *
 * Find and replace the following:
 *
 * 1. <torque_plugin_class_name>
 * 2. <torque_plugin_name>
 * 3. <torque_plugin_slug>
 * 4. <torque_plugin_namespace>
 * 5. <torque_plugin_shortcode>
 *
 * Remove this comment block once you've successfully run the plugin
 *
 */

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

class <torque_plugin_class_name> {

	public static $PLUGIN_NAME = '<torque_plugin_name>';

	public static $PLUGIN_SLUG = '<torque_plugin_slug>';

	public static $REST_API_NAMESPACE = '<torque_plugin_namespace>';

	public static $SHORTCODE_SLUG = '<torque_plugin_shortcode>';

	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	/**
   * This should be a function which registers all the plugin's required hooks.
   */
	public function init() {
		// register more hooks here

		// add API endpoints
		add_action( 'rest_api_init', array( $this, 'register_REST_routes' ) );

		// register plugin shortcode
		add_shortcode( static::$SHORTCODE_SLUG , array( $this, 'shortcode_handler') );
	}

	/**
   * Call register_rest_route in this this function in a child class
   * to automatically have them automatically added to the API.
   */
	public function register_REST_routes() {}

	/**
	 * Callback for the plugin shortcode
	 */
	public function shortcode_handler() {}

}

new <torque_plugin_class_name>();

?>
