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

require_once( plugin_dir_path( __DIR__ ) . 'lib/torque-plugin/torque-plugin-class.php' );

class Torque_Floor_Plans extends Torque_Plugin {

  public static $PLUGIN_NAME = 'Torque Floor Plans';

  public static $PLUGIN_SLUG = 'torque-floor-plans';

  public static $REST_API_NAMESPACE = 'floor-plans/v1/';

  public static $SHORTCODE_SLUG = 'torque_floor_plan';

  public function __construct() {
    parent::__construct();
  }

  public function init() {}

  public function register_REST_routes() {}

  public function shortcode_handler() {}
}

new Torque_Floor_Plans();

?>
