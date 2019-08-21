<?php
// entry point for backend of plugin

 /**
  * Plugin Name: Interra Marketing Automation
  * Description:
  * Version:     1.0.0
  * Author:      Torque
  * Author URI:  https://torque.digital
  * License:     GPL
  *
  * @package Interra Marketing Automation
  */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define constants for plugin's url and path
 */
define( 'Interra_Marketing_Automation_PATH', plugin_dir_path(__FILE__) );
define( 'Interra_Marketing_Automation_URL', plugin_dir_url(__FILE__) );

/**
 * Require autoloader for plugin classes
 */
require( Interra_Marketing_Automation_PATH . '/autoload.php' );

require_once( Interra_Marketing_Automation_PATH . '/includes/acf/ima-acf-class.php');


/**
 * Register plugin
 */
add_action( 'plugins_loaded', array( Interra_Marketing_Automation::get_inst(), 'init' ) );

class Interra_Marketing_Automation {

	public static $instance = NULL;

	public static $PLUGIN_NAME = 'Interra Marketing Automation';

	public static $PLUGIN_SLUG = 'interra-marketing-automation';

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

		if ( class_exists( 'IMA_ACF' ) ) {
		 new IMA_ACF();
		}

		// comment out class names to exclude
		Interra_Marketing_Automation_Autoloader::autoload( array(
			'Interra_Marketing_Automation_REST_Controller',
			'Interra_Marketing_Automation_Shortcode',
			'Interra_Marketing_Automation_CPT',
		) );

		// enqueue plugin scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_plugin_scripts' ) );
	}

	public function enqueue_plugin_scripts() {
		wp_enqueue_script(
			'interra-marketing-automation-scripts',
			Interra_Marketing_Automation_URL . 'bundles/bundle.js',
			array() ,
			'0.0.1',
			true
		);

		wp_enqueue_style(
			'interra-marketing-automation-styles',
			Interra_Marketing_Automation_URL . 'bundles/main.css'
		);
	}
}

?>
