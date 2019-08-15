<?php
// entry point for backend of plugin

 /**
  * Plugin Name: Torque Map
  * Description:
  * Version:     1.2.0
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

add_action( 'plugins_loaded', array( Torque_Map::get_inst(), 'init' ) );

/**
 * Define constants for plugin's url and path
 */
define( 'Torque_Map_PATH', plugin_dir_path(__FILE__) );
define( 'Torque_Map_URL', plugin_dir_url(__FILE__) );

require( Torque_Map_PATH . '/autoload.php' );

class Torque_Map {

	public static $PLUGIN_NAME = 'Torque Map';

	public static $PLUGIN_SLUG = 'torque-map';

	public static $instance = NULL;

	public static function get_inst() {
		!self::$instance AND self::$instance = new self;

		return self::$instance;
	}

	/**
	 * left empty on purpose
	 */
	public function __construct() {}

	/**
   * This should be a function which registers all the plugin's required hooks.
   */
	public function init() {

		// comment out class names to exclude
		Torque_Map_Autoloader::autoload( array(
			'Torque_Map_REST_Controller',
			'Torque_Map_Shortcode',
			'Torque_Map_CPT',
			'Torque_Map_ACF',
		) );

		// enqueue plugin scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_plugin_scripts' ) );

		// fetch API key
		if ( class_exists( 'Torque_Map_Controller' ) ) {
			add_filter( Torque_Map_Controller::$API_KEY_FILTER , function() { return get_field( 'google_maps', 'option' ); });
		}
	}

	/**
	 * enqueue the scripts for this plugin in the front end
	 *
	 * @return void enqueues scritps
	 */
	public function enqueue_plugin_scripts() {
		wp_enqueue_script(
			'torque-map-scripts',
			Torque_Map_URL . 'bundles/bundle.js',
			array() ,
			'0.0.1',
			true
		);

		wp_enqueue_style(
			'torque-map-styles',
			Torque_Map_URL . 'bundles/main.css'
		);
	}
}

?>
