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

/**
 * Define constants for plugin's url and path
 */
define( 'Torque_Floor_Plans_PATH', plugin_dir_path(__FILE__) );
define( 'Torque_Floor_Plans_URL', plugin_dir_url(__FILE__) );

/**
 * Register plugin after the theme, since the theme determines which features are included
 */
add_action( 'after_setup_theme', array( Torque_Floor_Plans::get_inst(), 'init' ) );

class Torque_Floor_Plans {

	public static $instance = NULL;

	public static $PLUGIN_NAME = 'Torque Floor Plans';

	public static $PLUGIN_SLUG = 'torque-floor-plans';

	public static $DATA_SOURCE_FILTER_SLUG = 'torque-floor-plans-data-source';

	public static $SUPPORTED_DATA_SOURCES = [ 'entrata' ];

	public $DATA_SOURCE = false;

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
		$this->set_data_source();

		// register plugin shortcode
		require( plugin_dir_path(__FILE__) . '/shortcode/torque-floor-plans-shortcode-class.php' );
		new Torque_Floor_Plans_Shortcode();


		if ( ! $this->DATA_SOURCE ) {
			require( plugin_dir_path(__FILE__) . '/custom-post-types/torque-floor-plan-cpt-class.php' );
			require( plugin_dir_path(__FILE__) . '/api/torque-floor-plans-rest-controller-class.php' );
			
			// register plugin specific CPTs
			new Torque_Floor_Plan_CPT();

			// init the REST Controller
			new Torque_Floor_Plans_REST_Controller();
		}

		// enqueue plugin scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_plugin_scripts' ) );
	}

	public function enqueue_plugin_scripts() {
		wp_enqueue_script( 'torque-floor-plans-scripts', Torque_Floor_Plans_URL . 'bundles/bundle.js', array() , '0.0.1', true );

		wp_enqueue_style( 'torque-floor-plans-styles', Torque_Floor_Plans_URL . 'bundles/main.css' );
	}

	private function set_data_source() {
		$new_source = apply_filters(self::$DATA_SOURCE_FILTER_SLUG, $this->DATA_SOURCE);

		if ( in_array( $new_source, self::$SUPPORTED_DATA_SOURCES ) ) {
			$this->DATA_SOURCE = $new_source;
		} else {
			throw new Exception('Data source '.$new_source.' not supported by '.self::$PLUGIN_NAME);
		}
	}
}

// instantiate the plugin class to run the contructor and register all the hooks.
new Torque_Floor_Plans();

?>
