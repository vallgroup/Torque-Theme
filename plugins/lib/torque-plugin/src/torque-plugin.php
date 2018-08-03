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
		// init the REST Controller
		new <torque_plugin_class_name>_REST_Controller();

		// register plugin shortcode
		add_shortcode( self::$SHORTCODE_SLUG , array( $this, 'shortcode_handler') );

		// enqueue scripts
		add_action( 'wp_enqueue_scripts', 'enqueue_plugin_scripts' );
	}

	/**
	 * Callback for the plugin shortcode
	 */
	public function shortcode_handler() {}

	public function enqueue_plugin_scripts() {
		wp_register_script( 'scripts', <torque_plugin_class_name>_PATH . '/bundles/bundle.js', array() , '0.0.1', true );
		wp_enqueue_script( 'scripts' );

		wp_register_style( 'style', <torque_plugin_class_name>_PATH . '/bundles/main.css' );
		wp_enqueue_style( 'style' );
	}
}

new <torque_plugin_class_name>();

?>
