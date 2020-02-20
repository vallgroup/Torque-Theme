<?php
// entry point for backend of plugin

 /**
  * Plugin Name: Torque Filtered Gallery
  * Description:
  * Version:     2.0.0
  * Author:      Torque
  * Author URI:  https://torque.digital
  * License:     GPL
  *
  * @package Torque Filtered Gallery
  */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define constants for plugin's url and path
 */
define( 'Torque_Filtered_Gallery_PATH', plugin_dir_path(__FILE__) );
define( 'Torque_Filtered_Gallery_URL', plugin_dir_url(__FILE__) );

/**
 * Require autoloader for plugin classes
 */
require( Torque_Filtered_Gallery_PATH . '/autoload.php' );

/**
 * Register plugin
 */
add_action( 'plugins_loaded', array( Torque_Filtered_Gallery::get_inst(), 'init' ) );

class Torque_Filtered_Gallery {

	public static $instance = NULL;

	public static $PLUGIN_NAME = 'Torque Filtered Gallery';

	public static $PLUGIN_SLUG = 'torque-filtered-gallery';

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
		Torque_Filtered_Gallery_Autoloader::autoload( array(
			'Torque_Filtered_Gallery_Shortcode',
			'Torque_Filtered_Gallery_REST_Controller',
			'Torque_Filtered_Gallery_CPT'
		) );

		// enqueue plugin scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_plugin_scripts' ) );
	}

	public function enqueue_plugin_scripts() {
		wp_enqueue_script(
			'torque-filtered-gallery-scripts',
			Torque_Filtered_Gallery_URL . 'bundles/bundle.js',
			array() ,
			'0.0.1',
			true
		);

		wp_enqueue_style(
			'torque-filtered-gallery-styles',
			Torque_Filtered_Gallery_URL . 'bundles/main.css'
		);
	}
}

?>
