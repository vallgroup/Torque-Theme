<?php
// entry point for backend of plugin

 /**
  * Plugin Name: Torque Rentcafe
  * Description:
  * Version:     1.0.0
  * Author:      Torque
  * Author URI:  https://torque.digital
  * License:     GPL
  *
  * @package Torque Rentcafe
  */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define constants for plugin's url and path
 */
define( 'Torque_Rentcafe_PATH', plugin_dir_path(__FILE__) );
define( 'Torque_Rentcafe_URL', plugin_dir_url(__FILE__) );

/**
 * Require autoloader for plugin classes
 */
require( Torque_Rentcafe_PATH . '/autoload.php' );

/**
 * Register plugin
 */
add_action( 'plugins_loaded', array( Torque_Rentcafe::get_inst(), 'init' ) );

class Torque_Rentcafe {

	public static $instance = NULL;

	public static $PLUGIN_NAME = 'Torque Rentcafe';

	public static $PLUGIN_SLUG = 'torque-rentcafe';

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
		Torque_Rentcafe_Autoloader::autoload( array(
			'Torque_Rentcafe_REST_Controller',
			'Torque_Rentcafe_Shortcode',
			// 'Torque_Rentcafe_CPT',
			'Torque_Rentcafe_ACF_Class',
		) );

		// enqueue plugin scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_plugin_scripts' ) );
	}

	public function enqueue_plugin_scripts() {
		wp_enqueue_script(
			'torque-rentcafe-scripts',
			Torque_Rentcafe_URL . 'bundles/bundle.js',
			array() ,
			'0.0.1',
			true
		);

		wp_enqueue_style(
			'torque-rentcafe-styles',
			Torque_Rentcafe_URL . 'bundles/main.css'
		);
	}
}

?>
