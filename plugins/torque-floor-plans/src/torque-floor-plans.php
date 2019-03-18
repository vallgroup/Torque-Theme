<?php
// entry point for backend of plugin

 /**
  * Plugin Name: Torque Floor Plans
  * Description:
  * Version:     2.1.2
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

/**
 * Define constants for plugin's url and path
 */
define( 'Torque_Floor_Plans_PATH', plugin_dir_path(__FILE__) );
define( 'Torque_Floor_Plans_URL', plugin_dir_url(__FILE__) );

/**
 * Register plugin
 */
add_action( 'plugins_loaded', array( Torque_Floor_Plans::get_inst(), 'init' ) );

class Torque_Floor_Plans {

	public static $instance = NULL;

	public static function get_inst() {
		!self::$instance AND self::$instance = new self;

		return self::$instance;
	}

	/**
	 * left empty on purpose
	 */
	public function __construct() {}



	public static $PLUGIN_NAME = 'Torque Floor Plans';

	public static $PLUGIN_SLUG = 'torque-floor-plans';


	/**
   * This should be a function which registers all the plugin's required hooks.
   */
	public function init() {

		// register plugin shortcode
		require_once( plugin_dir_path(__FILE__) . '/shortcode/torque-floor-plans-shortcode-class.php' );
		new Torque_Floor_Plans_Shortcode();

		//Register data source after the theme, since the theme determines which source to use
		require_once( plugin_dir_path(__FILE__) . '/data-sources/torque-floor-plans-data-source-class.php' );
		add_action( 'after_setup_theme', array( Torque_Floor_Plans_Data_Source::get_inst(), 'init' ) );

		// enqueue plugin scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_plugin_scripts' ) );
	}

	public function enqueue_plugin_scripts() {
		wp_enqueue_script( 'torque-floor-plans-scripts', Torque_Floor_Plans_URL . 'bundles/bundle.js', array() , '0.0.1', true );

		wp_enqueue_style( 'torque-floor-plans-styles', Torque_Floor_Plans_URL . 'bundles/main.css' );
	}
}

?>
