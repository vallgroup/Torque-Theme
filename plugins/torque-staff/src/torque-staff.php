<?php
// entry point for backend of plugin

 /**
  * Plugin Name: Torque Staff
  * Description:
  * Version:     1.1.1
  * Author:      Torque
  * Author URI:  https://torque.digital
  * License:     GPL
  *
  * @package Torque Staff
  */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define constants for plugin's url and path
 */
define( 'Torque_Staff_PATH', plugin_dir_path(__FILE__) );
define( 'Torque_Staff_URL', plugin_dir_url(__FILE__) );

/**
 * Require autoloader for plugin classes
 */
require( Torque_Staff_PATH . '/autoload.php' );

/**
 * Register plugin
 */
add_action( 'plugins_loaded', array( Torque_Staff::get_inst(), 'init' ) );

class Torque_Staff {

	public static $instance = NULL;

	public static $PLUGIN_NAME = 'Torque Staff';

	public static $PLUGIN_SLUG = 'torque-staff';

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
		Torque_Staff_Autoloader::autoload( array(
			'Torque_Staff_CPT',
		) );

		// enqueue plugin scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_plugin_scripts' ) );
	}

	public function enqueue_plugin_scripts() {
		/*
		 We dont use any js right now

		 wp_enqueue_script(
				'torque-staff-scripts',
				Torque_Staff_URL . 'bundles/bundle.js',
				array() ,
				'0.0.1',
				true
			);
		*/

		wp_enqueue_style(
			'torque-staff-styles',
			Torque_Staff_URL . 'bundles/main.css'
		);
	}
}

?>
