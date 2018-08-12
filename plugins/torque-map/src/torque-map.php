<?php
// entry point for backend of plugin

 /**
  * Plugin Name: Torque Map
  * Description:
  * Version:     1.0.0
  * Author:      Torque
  * Author URI:  https://torque.digital
  * License:     GPL
  *
  * @package Torque Map
  */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require( plugin_dir_path(__FILE__) . '/api/torque-map-rest-controller-class.php' );
require( plugin_dir_path(__FILE__) . '/shortcode/torque-map-shortcode-class.php' );

/**
 * Define constants for plugin's url and path
 */
define( 'Torque_Map_PATH', plugin_dir_path(__FILE__) );
define( 'Torque_Map_URL', plugin_dir_url(__FILE__) );

class Torque_Map {

	public static $PLUGIN_NAME = 'Torque Map';

	public static $PLUGIN_SLUG = 'torque-map';

	public function __construct() {
// 		add_filter( 'torque_map_pois_allowed', 'allow_pois' );
// function allow_pois( $n ) {
//   return 4;
// }
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	/**
   * This should be a function which registers all the plugin's required hooks.
   */
	public function init() {
		// init the REST Controller
		new Torque_Map_REST_Controller();

		// register plugin shortcode
		new Torque_Map_Shortcode();

		// enqueue plugin scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_plugin_scripts' ) );

		if ( class_exists( 'PremiseCPT' ) ) {
			$torque_maps = new PremiseCPT( array(
				'plural'         => 'Maps',
				'singular'       => 'Map',
				'post_type_name' => 'torque_map',
				'slug'           => 'torque-map'
			), array(
				'supports'             => array( 'title' ),
				'public'               => false,
				'show_ui'              => true,
				'show_in_rest'         => true,
			));
		}

		// must run at init, otherwise the filter for pois will not work.
		add_action( 'init', array( $this, 'register_mb' ) );
	}

	public function enqueue_plugin_scripts() {
		wp_enqueue_script( 'torque-map-scripts', Torque_Map_URL . 'bundles/bundle.js', array() , '0.0.1', true );

		wp_enqueue_style( 'torque-map-styles', Torque_Map_URL . 'bundles/main.css' );
	}

	public function output_sc_string() {
		global $post;
		?>
		<p>To use this map anywhere on your site, copy and paste this shortcode: <code>[torque_map map_id="<?php echo $post->ID; ?>"]</code></p>
		<?php
	}

	public function register_mb() {

		pwp_add_metabox( array(
			'title' => 'The Shortcode',
			'callback' => array( $this, 'output_sc_string' ),
		), array( 'torque_map' ), '', '' );

		pwp_add_metabox( 'Map Details', array( 'torque_map' ), array(
			'name_prefix' => 'torque_map',
			array(
				'context'     => 'post',
				'type'        => 'text',
				'name'        => '[center]',
				'label'       => 'Map Center',
				'placeholder' => 'Address, Zip Code or Place',
			),
			array(
				'context'     => 'post',
				'type'        => 'wp_media',
				'name'        => '[center_marker][url]',
				'label'       => 'Center Marker Icon',
				'placeholder' => 'Enter icon url or click upload button',
			),
			array(
				'context'     => 'post',
				'type'        => 'text',
				'name'        => '[center_marker][size]',
				'label'       => 'Center Marker Size',
				'placeholder' => '20,32',
			),
		), 'torque_map');

		$this->maybe_add_pois();
	}

	public function maybe_add_pois() {
		/**
		 * Filters the number of pois allowed for the map
		 * Allows theme to register number of pois it uses
		 * in design
		 *
		 * @var int
		 */
		$number_of_pois = apply_filters( 'torque_map_pois_allowed', 0 );
		for ($i=0; $i < $number_of_pois; $i++) {
			$this->poi_mb( $i );
		}
	}

	public function poi_mb( $n = 0 ) {

		$option_name = 'torque_map_pois_'.$n;
		$mb_title = ( 0 === $n )
			? 'Points Of Interest'
			: 'Points Of Interest '.($n + 1);

		pwp_add_metabox( $mb_title, array( 'torque_map' ), array(
			'name_prefix' => $option_name,
			array(
				'context'     => 'post',
				'type'        => 'text',
				'name'        => '[name]',
				'label'       => 'Name',
				'placeholder' => 'Hospitals',
			),
			array(
				'context'     => 'post',
				'type'        => 'text',
				'name'        => '[keyword]',
				'label'       => 'Keyword',
				'placeholder' => 'hospitals, clinics, urgent care',
			),
			array(
				'context'     => 'post',
				'type'        => 'wp_media',
				'name'        => '[marker][url]',
				'label'       => 'Marker To Use For This POI',
				'placeholder' => 'Enter icon url or click upload button',
			),
			array(
				'context'     => 'post',
				'type'        => 'text',
				'name'        => '[marker][size]',
				'label'       => 'Marker Size',
				'placeholder' => '20,32',
			),
		), $option_name);
	}
}

// instantiate the plugin class to run the contructor and register all the hooks.
new Torque_Map();

?>
