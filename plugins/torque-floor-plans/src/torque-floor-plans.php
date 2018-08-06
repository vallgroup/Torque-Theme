<?php
// entry point for backend of plugin

 /**
  * Plugin Name: Torque Floor Plans
  * Description:
  * Version:     1.0.0
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

require( plugin_dir_path(__FILE__) . '/custom-post-types/torque-floor-plan-cpt-class.php' );
require( plugin_dir_path(__FILE__) . '/api/torque-floor-plans-rest-controller-class.php' );
require( plugin_dir_path(__FILE__) . '/shortcode/torque-floor-plans-shortcode-class.php' );

/**
 * Define constants for plugin's url and path
 */
define( 'Torque_Floor_Plans_PATH', plugin_dir_path(__FILE__) );
define( 'Torque_Floor_Plans_URL', plugin_dir_url(__FILE__) );

class Torque_Floor_Plans {

	public static $PLUGIN_NAME = 'Torque Floor Plans';

	public static $PLUGIN_SLUG = 'torque-floor-plans';

	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	/**
   * This should be a function which registers all the plugin's required hooks.
   */
	public function init() {
		// register plugin specific CPTs
		new Torque_Floor_Plan_CPT();

		// init the REST Controller
		new Torque_Floor_Plans_REST_Controller();

		// register plugin shortcode
		new Torque_Floor_Plans_Shortcode();

		// enqueue plugin scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_plugin_scripts' ) );
	}

	public function enqueue_plugin_scripts() {
		wp_enqueue_script( 'torque-floor-plans-scripts', Torque_Floor_Plans_URL . 'bundles/bundle.js', array() , '0.0.1', true );

		wp_enqueue_style( 'torque-floor-plans-styles', Torque_Floor_Plans_URL . 'bundles/main.css' );
	}
}

// instantiate the plugin class to run the contructor and register all the hooks.
new Torque_Floor_Plans();

?>
