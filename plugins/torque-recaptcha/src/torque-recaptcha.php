<?php
// entry point for backend of plugin

 /**
  * Plugin Name: Torque ReCAPTCHA
  * Description:
  * Version:     1.0.0
  * Author:      Torque
  * Author URI:  https://torque.digital
  * License:     GPL
  *
  * @package Torque ReCAPTCHA
  */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define constants for plugin's url and path
 */
define( 'Torque_Recaptcha_PATH', plugin_dir_path(__FILE__) );
define( 'Torque_Recaptcha_URL', plugin_dir_url(__FILE__) );

/**
 * Require autoloader for plugin classes
 */
require( Torque_Recaptcha_PATH . '/autoload.php' );

/**
 * Register plugin
 */
add_action( 'plugins_loaded', array( Torque_Recaptcha::get_inst(), 'init' ) );

class Torque_Recaptcha {

	public static $instance = NULL;

	public static $PLUGIN_NAME = 'Torque ReCAPTCHA';

	public static $PLUGIN_SLUG = 'torque-recaptcha';

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
		Torque_Recaptcha_Autoloader::autoload( array(
			'Torque_Recaptcha_Shortcode',
			'Torque_Recaptcha_ACF',
		) );

		// enqueue plugin scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_plugin_scripts' ) );

		// enqueue google scripts
		add_action('wp_head', array( $this, 'hook_google' ));
	}

	public function enqueue_plugin_scripts() {
		wp_enqueue_script(
			'torque-recaptcha-scripts',
			Torque_Recaptcha_URL . 'bundles/bundle.js',
			array() ,
			'0.0.1',
			true
		);

		wp_enqueue_style(
			'torque-recaptcha-styles',
			Torque_Recaptcha_URL . 'bundles/main.css'
		);
	}

	public function hook_google() {
		echo "<script src='https://www.google.com/recaptcha/api.js'></script>";
	}
}

?>
