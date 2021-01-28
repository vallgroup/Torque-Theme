<?php
// entry point for backend of plugin

 /**
  * Plugin Name: Torque Rentcafe Tour
  * Description:
  * Version:     1.0.0
  * Author:      Torque
  * Author URI:  https://torque.digital
  * License:     GPL
  *
  * @package Torque Rentcafe Tour
  */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define constants for plugin's url and path
 */
define( 'Torque_Rentcafe_Tour_PATH', plugin_dir_path(__FILE__) );
define( 'Torque_Rentcafe_Tour_URL', plugin_dir_url(__FILE__) );

/**
 * Require autoloader for plugin classes
 */
require( Torque_Rentcafe_Tour_PATH . '/autoload.php' );

/**
 * Register plugin
 */
add_action( 'plugins_loaded', array( Torque_Rentcafe_Tour::get_inst(), 'init' ) );

class Torque_Rentcafe_Tour {

	public static $instance = NULL;

	public static $PLUGIN_NAME = 'Torque Rentcafe Tour';

	public static $PLUGIN_SLUG = 'torque-rentcafe-tour';

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
		Torque_Rentcafe_Tour_Autoloader::autoload( array(
			// 'Torque_Rentcafe_Tour_REST_Controller',
			'Torque_Rentcafe_Tour_Shortcode',
			'Torque_Rentcafe_Tour_CPT',
		) );

		// enqueue plugin scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_plugin_scripts' ) );
	}

	public function enqueue_plugin_scripts() {
		wp_enqueue_script(
			'torque-rentcafe-tour-scripts',
			Torque_Rentcafe_Tour_URL . 'bundles/bundle.js',
			array() ,
			'0.0.1',
			true
		);

		wp_enqueue_style(
			'torque-rentcafe-tour-styles',
			Torque_Rentcafe_Tour_URL . 'bundles/main.css'
		);
	}
}

?>
