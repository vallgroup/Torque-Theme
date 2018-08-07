<?php
// entry point for backend of plugin

 /**
  * Plugin Name: Torque Gallery Layouts
  * Description:
  * Version:     1.0.0
  * Author:      Torque
  * Author URI:  https://torque.digital
  * License:     GPL
  *
  * @package Torque Gallery Layouts
  */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define constants for plugin's url and path
 */
define( 'Torque_Gallery_Layouts_PATH', plugin_dir_path(__FILE__) );
define( 'Torque_Gallery_Layouts_URL', plugin_dir_url(__FILE__) );

require_once( Torque_Gallery_Layouts_PATH . 'includes/print-media-templates-hook-class.php' );
require_once( Torque_Gallery_Layouts_PATH . 'includes/gallery-post-filter-class.php' );

class Torque_Gallery_Layouts {

	public static $PLUGIN_NAME = 'Torque Gallery Layouts';

	public static $PLUGIN_SLUG = 'torque-gallery-layouts';

	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	/**
   * This should be a function which registers all the plugin's required hooks.
   */
	public function init() {
		new Print_Media_Templates_Hook();
		new Gallery_Post_Filter();

		// enqueue plugin scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_plugin_scripts' ) );
	}

	public function enqueue_plugin_scripts() {
		wp_enqueue_style( 'torque-gallery-layouts-styles', Torque_Gallery_Layouts_URL . 'bundles/main.css' );
	}
}

// instantiate the plugin class to run the contructor and register all the hooks.
new Torque_Gallery_Layouts();

?>
