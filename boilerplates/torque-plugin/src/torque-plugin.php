<?php
// entry point for backend of plugin

 /**
  * Plugin Name: <torque_plugin_name>
  * Description:
  * Version:     1.0.0
  * Author:      Torque
  * Author URI:  https://torque.digital
  * License:     GPL
  *
  * @package <torque_plugin_name>
  */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define constants for plugin's url and path
 */
define( '<torque_plugin_class_name>_PATH', plugin_dir_path(__FILE__) );
define( '<torque_plugin_class_name>_URL', plugin_dir_url(__FILE__) );

/**
 * Require autoloader for plugin classes
 */
require( <torque_plugin_class_name>_PATH . '/autoload.php' );

/**
 * Register plugin
 */
add_action( 'plugins_loaded', array( <torque_plugin_class_name>::get_inst(), 'init' ) );

class <torque_plugin_class_name> {

	public static $instance = NULL;

	public static $PLUGIN_NAME = '<torque_plugin_name>';

	public static $PLUGIN_SLUG = '<torque_plugin_slug>';

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
		<torque_plugin_class_name>_Autoloader::autoload( array(
			'<torque_plugin_class_name>_REST_Controller',
			'<torque_plugin_class_name>_Shortcode',
			'<torque_plugin_class_name>_CPT',
		) );

		// enqueue plugin scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_plugin_scripts' ) );
	}

	public function enqueue_plugin_scripts() {
		wp_enqueue_script(
			'<torque_plugin_slug>-scripts',
			<torque_plugin_class_name>_URL . 'bundles/bundle.js',
			array() ,
			'0.0.1',
			true
		);

		wp_enqueue_style(
			'<torque_plugin_slug>-styles',
			<torque_plugin_class_name>_URL . 'bundles/main.css'
		);
	}
}

?>
