<?php

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

require( plugin_dir_path(__FILE__) . 'api/torque-floor-plans-rest-controller-class.php' );

/**
 * Define constants for plugin's url and path
 */
define( 'Torque_Floor_Plans_PATH', plugin_dir_path(__FILE__) );
define( 'Torque_Floor_Plans_URL', plugin_dir_url(__FILE__) );

class Torque_Floor_Plans {

	public static $PLUGIN_NAME = 'Torque Floor Plans';

	public static $PLUGIN_SLUG = 'torque-floor-plans';

	public static $SHORTCODE_SLUG = 'floor_plan';

	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	/**
   * This should be a function which registers all the plugin's required hooks.
   */
	public function init() {
		new Torque_Floor_Plans_REST_Controller();

		// register plugin shortcode
		add_shortcode( self::$SHORTCODE_SLUG , array( $this, 'shortcode_handler') );
	}

	/**
	 * Callback for the plugin shortcode
	 */
	public function shortcode_handler() {}

}

new Torque_Floor_Plans();

?>
