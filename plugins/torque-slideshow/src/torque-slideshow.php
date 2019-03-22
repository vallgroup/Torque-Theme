<?php
// entry point for backend of plugin

 /**
  * Plugin Name: Torque Slideshow
  * Description:
  * Version:     2.0.1
  * Author:      Torque
  * Author URI:  https://torque.digital
  * License:     GPL
  *
  * @package Torque Slideshow
  */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define constants for plugin's url and path
 */
define( 'Torque_Slideshow_PATH', plugin_dir_path(__FILE__) );
define( 'Torque_Slideshow_URL', plugin_dir_url(__FILE__) );

/**
 * Require autoloader for plugin classes
 */
require( Torque_Slideshow_PATH . '/autoload.php' );

/**
 * Register plugin
 */
add_action( 'after_setup_theme', array( Torque_Slideshow::get_inst(), 'init' ) );

class Torque_Slideshow {

	public static $USE_POST_SLIDESHOW_FILTER_HOOK = 'torque_slideshow_allow_post_slideshow';

	public static $instance = NULL;

	public static $PLUGIN_NAME = 'Torque Slideshow';

	public static $PLUGIN_SLUG = 'torque-slideshow';

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
		$to_load = array(
			'Torque_Slideshow_REST_Controller',
			'Torque_Slideshow_Shortcode',
			'Torque_Slideshow_CPT',
		);

		$should_use_post_slideshow = apply_filters( self::$USE_POST_SLIDESHOW_FILTER_HOOK, false );
		if ($should_use_post_slideshow) {
			$to_load[] = 'Torque_Post_Slideshow_CPT';
		}

		// comment out class names to exclude
		Torque_Slideshow_Autoloader::autoload( $to_load );

		// enqueue plugin scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_plugin_scripts' ) );
	}

	public function enqueue_plugin_scripts() {
		wp_enqueue_script(
			'torque-slideshow-scripts',
			Torque_Slideshow_URL . 'bundles/bundle.js',
			array() ,
			'0.0.1',
			true
		);

		wp_enqueue_style(
			'torque-slideshow-styles',
			Torque_Slideshow_URL . 'bundles/main.css'
		);
	}
}

?>
