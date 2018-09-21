<?php
// entry point for backend of plugin

 /**
  * Plugin Name: Torque US States
  * Description:
  * Version:     1.0.0
  * Author:      Torque
  * Author URI:  https://torque.digital
  * License:     GPL
  *
  * @package Torque US States
  */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define constants for plugin's url and path
 */
define( 'Torque_US_States_PATH', plugin_dir_path(__FILE__) );
define( 'Torque_US_States_URL', plugin_dir_url(__FILE__) );

/**
 * Require autoloader for plugin classes
 */
require( Torque_US_States_PATH . '/autoload.php' );

/**
 * Register plugin
 */
add_action( 'plugins_loaded', array( Torque_US_States::get_inst(), 'init' ) );

class Torque_US_States {

	public static $instance = NULL;

	public static $PLUGIN_NAME = 'Torque US States';

	public static $PLUGIN_SLUG = 'torque-us-states';

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
		Torque_US_States_Autoloader::autoload( array(
			'Torque_US_States_REST_Controller',
			'Torque_US_States_Shortcode',
			'Torque_US_States_CPT',
		) );

		// enqueue plugin scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_plugin_scripts' ) );
	}

	public function enqueue_plugin_scripts() {
		wp_enqueue_script(
			'torque-us-states-scripts',
			Torque_US_States_URL . 'bundles/bundle.js',
			array() ,
			'0.0.1',
			true
		);

		wp_enqueue_style(
			'torque-us-states-styles',
			Torque_US_States_URL . 'bundles/main.css'
		);
	}
}

?>
