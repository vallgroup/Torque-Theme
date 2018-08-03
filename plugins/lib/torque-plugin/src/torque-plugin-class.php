<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * We define the base class that all Torque plugins must extend.
 *
 * It is mainly responsible for defining the minimum plugin implementations,
 * but also wraps the plugin installation logic.
 */

abstract class Torque_Plugin {

	/**
	 * Make sure plugins implement these static properties
	 * to pass validation.
	 *
	 * Otherwisse will trigger a fatal error on loading the plugin.
	 */

	public static $PLUGIN_NAME;

	public static $PLUGIN_SLUG;

	public static $REST_API_NAMESPACE;

	public static $SHORTCODE_SLUG;

	/**
   * This should be a function which registers all the plugin's required hooks.
   */
	abstract public function init();

	/**
   * Call register_rest_route in this this function in a child class
   * to automatically have them automatically added to the API.
   */
	abstract public function register_REST_routes();

	/**
	 * Callback for the plugin shortcode
	 */
	abstract public function shortcode_handler();

	/**
	 * Important that this is called by the child class's constructor
	 */
	protected function __construct() {
		if ($this->validate_plugin()) {
			add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );
		}
	}

	/**
	 * Register the minimum required hooks for every Torque plugin
	 */
	public function init_plugin() {
		// run child init to add plugin specific hooks
		$this->init();

		// add API endpoints
		add_action( 'rest_api_init', array( $this, 'register_REST_routes' ) );

		// register plugin shortcode
		add_shortcode( static::$SHORTCODE_SLUG , array( $this, 'shortcode_handler') );
	}

	/**
	 * We check all the required static variables exist on the child class,
	 * and if not we throw a fatal error
	 */
	private function validate_plugin() {
		$required_static = [
			'PLUGIN_NAME',
			'PLUGIN_SLUG',
			'REST_API_NAMESPACE',
			'SHORTCODE_SLUG'
		];

		foreach ($required_static as $key) {
			if ( ! isset(static::$$key) ) {
	      throw new Exception('Child class '.get_called_class().' failed to define static '.$key.' property');
	    }
		}

		return true;
	}
}

?>
