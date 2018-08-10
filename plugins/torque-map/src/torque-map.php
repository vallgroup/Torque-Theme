<?php
// entry point for backend of plugin

 /**
  * Plugin Name: Torque Map
  * Description:
  * Version:     1.0.0
  * Author:      Torque
  * Author URI:  https://torque.digital
  * License:     GPL
  *
  * @package Torque Map
  */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

//require( plugin_dir_path(__FILE__) . '/api/torque-map-rest-controller-class.php' );
require( plugin_dir_path(__FILE__) . '/shortcode/torque-map-shortcode-class.php' );

/**
 * Define constants for plugin's url and path
 */
define( 'Torque_Map_PATH', plugin_dir_path(__FILE__) );
define( 'Torque_Map_URL', plugin_dir_url(__FILE__) );

class Torque_Map {

	public static $PLUGIN_NAME = 'Torque Map';

	public static $PLUGIN_SLUG = 'torque-map';

	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	/**
   * This should be a function which registers all the plugin's required hooks.
   */
	public function init() {
		// init the REST Controller
		//new Torque_Map_REST_Controller();

		// register plugin shortcode
		new Torque_Map_Shortcode();

		// enqueue plugin scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_plugin_scripts' ) );
	}

	public function enqueue_plugin_scripts() {
		wp_enqueue_script( 'torque-map-scripts', Torque_Map_URL . 'bundles/bundle.js', array() , '0.0.1', true );

		wp_enqueue_style( 'torque-map-styles', Torque_Map_URL . 'bundles/main.css' );
	}
}

// instantiate the plugin class to run the contructor and register all the hooks.
new Torque_Map();

?>
