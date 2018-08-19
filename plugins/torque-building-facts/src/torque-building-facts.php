<?php
// entry point for backend of plugin

 /**
  * Plugin Name: Torque Building Facts
  * Description:
  * Version:     1.0.0
  * Author:      Torque
  * Author URI:  https://torque.digital
  * License:     GPL
  *
  * @package Torque Building Facts
  */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define constants for plugin's url and path
 */
define( 'Torque_Building_Facts_PATH', plugin_dir_path(__FILE__) );
define( 'Torque_Building_Facts_URL', plugin_dir_url(__FILE__) );

/**
 * Require autoloader for plugin classes
 */
require( Torque_Building_Facts_PATH . '/autoload.php' );

/**
 * Register plugin
 */
add_action( 'plugins_loaded', array( Torque_Building_Facts::get_inst(), 'init' ) );

class Torque_Building_Facts {

	public static $instance = NULL;

	public static $PLUGIN_NAME = 'Torque Building Facts';

	public static $PLUGIN_SLUG = 'torque-building-facts';

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
		Torque_Building_Facts_Autoloader::autoload( array(
			'Torque_Building_Facts_CPT',
		) );

		// enqueue plugin scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_plugin_scripts' ) );
	}

	public function enqueue_plugin_scripts() {
		/*
		 We dont use any js right now

		 wp_enqueue_script(
				'torque-building-facts-scripts',
				Torque_Building_Facts_URL . 'bundles/bundle.js',
				array() ,
				'0.0.1',
				true
			);
		*/

		wp_enqueue_style(
			'torque-building-facts-styles',
			Torque_Building_Facts_URL . 'bundles/main.css'
		);
	}
}

?>
