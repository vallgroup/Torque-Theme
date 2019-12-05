<?php
// entry point for backend of plugin

 /**
  * Plugin Name: Torque Image Grid
  * Description:
  * Version:     1.0.0
  * Author:      Torque
  * Author URI:  https://torque.digital
  * License:     GPL
  *
  * @package Torque Image Grid
  */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define constants for plugin's url and path
 */
define( 'Torque_Image_Grid_PATH', plugin_dir_path(__FILE__) );
define( 'Torque_Image_Grid_URL', plugin_dir_url(__FILE__) );

/**
 * Require autoloader for plugin classes
 */
require( Torque_Image_Grid_PATH . '/autoload.php' );

/**
 * Register plugin
 */
add_action( 'plugins_loaded', array( Torque_Image_Grid::get_inst(), 'init' ) );

class Torque_Image_Grid {

	public static $instance = NULL;

	public static $PLUGIN_NAME = 'Torque Image Grid';

	public static $PLUGIN_SLUG = 'torque-image-grid';

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
		Torque_Image_Grid_Autoloader::autoload( array(
			'Torque_Image_Grid_REST_Controller',
			'Torque_Image_Grid_Shortcode',
			'Torque_Image_Grid_CPT',
		) );

		// enqueue plugin scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_plugin_scripts' ) );
	}

	public function enqueue_plugin_scripts() {
		wp_enqueue_script(
			'torque-image-grid-scripts',
			Torque_Image_Grid_URL . 'bundles/bundle.js',
			array() ,
			'0.0.1',
			true
		);

		wp_enqueue_style(
			'torque-image-grid-styles',
			Torque_Image_Grid_URL . 'bundles/main.css'
		);
	}
}

?>
