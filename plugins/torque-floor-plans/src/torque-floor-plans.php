<?php

 /**
  * Plugin Name: Torque Floor Plans
  * Description:
  * Version:     1.0.0
  * Author:      Torque
  * Author URI:  https://torque.digital
  * License:     GPL
  *
  * @package Torque Floor Plans
  */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Torque_Floor_Plans {

	public static $PLUGIN_NAME = 'Torque Floor Plans';

	public static $PLUGIN_SLUG = 'torque_floor_plans';

	public static $REST_API_NAMESPACE = 'floor_plans/v1/';

	public static $SHORTCODE_SLUG = 'torque_floor_plan';

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

new Torque_Floor_Plans();

?>
