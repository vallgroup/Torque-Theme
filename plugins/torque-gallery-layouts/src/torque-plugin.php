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
	}
}

// instantiate the plugin class to run the contructor and register all the hooks.
new Torque_Gallery_Layouts();

?>
