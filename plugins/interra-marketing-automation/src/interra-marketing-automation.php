<?php
// entry point for backend of plugin

 /**
  * Plugin Name: Interra Marketing Automation
  * Description:
  * Version:     1.0.0
  * Author:      Torque
  * Author URI:  https://torque.digital
  * License:     GPL
  *
  * @package Interra Marketing Automation
  */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define constants for plugin's url and path
 */
define( 'Interra_Marketing_Automation_PATH', plugin_dir_path(__FILE__) );
define( 'Interra_Marketing_Automation_URL', plugin_dir_url(__FILE__) );

/**
 * Require autoloader for plugin classes
 */
require( Interra_Marketing_Automation_PATH . '/autoload.php' );

require_once( Interra_Marketing_Automation_PATH . '/includes/acf/ima-acf-class.php');


/**
 * Register plugin
 */
add_action( 'plugins_loaded', array( Interra_Marketing_Automation::get_inst(), 'init' ) );

class Interra_Marketing_Automation {

	public static $instance = NULL;

	public static $PLUGIN_NAME = 'Interra Marketing Automation';

	public static $PLUGIN_SLUG = 'interra-marketing-automation';

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

		// $this->send_file();

		$this->add_acf_fields();

		// comment out class names to exclude
		Interra_Marketing_Automation_Autoloader::autoload( array(
			'Interra_Marketing_Automation_REST_Controller',
			'Interra_Marketing_Automation_Shortcode',
			'Interra_Marketing_Automation_CPT',
		) );

		// enqueue plugin scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_plugin_scripts' ) );

		add_action('acf/input/admin_enqueue_scripts', array( $this, 'boxapp_ajax_scripts'), 10, 1);

		add_filter( 'template_include', array( $this, 'filter_ima_page_template' ), 99 );

		add_filter( 'torque_map_api_key', array( $this, 'gmap_api_key') );

		add_filter( 'torque_map_default_styles', array( $this, 'get_map_styles') );

	}

	public function gmap_api_key() {
		return 'AIzaSyBbzylAdZ7vqtFdVbfxK2Vkwt5-lCm1F30';
	}

	public function get_map_styles() {
		return '[
		    {
		        "featureType": "water",
		        "elementType": "geometry",
		        "stylers": [
		            {
		                "color": "#e9e9e9"
		            },
		            {
		                "lightness": 17
		            }
		        ]
		    },
		    {
		        "featureType": "landscape",
		        "elementType": "geometry",
		        "stylers": [
		            {
		                "color": "#f5f5f5"
		            },
		            {
		                "lightness": 20
		            }
		        ]
		    },
		    {
		        "featureType": "road.highway",
		        "elementType": "geometry.fill",
		        "stylers": [
		            {
		                "color": "#ffffff"
		            },
		            {
		                "lightness": 17
		            }
		        ]
		    },
		    {
		        "featureType": "road.highway",
		        "elementType": "geometry.stroke",
		        "stylers": [
		            {
		                "color": "#ffffff"
		            },
		            {
		                "lightness": 29
		            },
		            {
		                "weight": 0.2
		            }
		        ]
		    },
		    {
		        "featureType": "road.arterial",
		        "elementType": "geometry",
		        "stylers": [
		            {
		                "color": "#ffffff"
		            },
		            {
		                "lightness": 18
		            }
		        ]
		    },
		    {
		        "featureType": "road.local",
		        "elementType": "geometry",
		        "stylers": [
		            {
		                "color": "#ffffff"
		            },
		            {
		                "lightness": 16
		            }
		        ]
		    },
		    {
		        "featureType": "poi",
		        "elementType": "geometry",
		        "stylers": [
		            {
		                "color": "#f5f5f5"
		            },
		            {
		                "lightness": 21
		            }
		        ]
		    },
		    {
		        "featureType": "poi.park",
		        "elementType": "geometry",
		        "stylers": [
		            {
		                "color": "#dedede"
		            },
		            {
		                "lightness": 21
		            }
		        ]
		    },
		    {
		        "elementType": "labels.text.stroke",
		        "stylers": [
		            {
		                "visibility": "on"
		            },
		            {
		                "color": "#ffffff"
		            },
		            {
		                "lightness": 16
		            }
		        ]
		    },
		    {
		        "elementType": "labels.text.fill",
		        "stylers": [
		            {
		                "saturation": 36
		            },
		            {
		                "color": "#333333"
		            },
		            {
		                "lightness": 40
		            }
		        ]
		    },
		    {
		        "elementType": "labels.icon",
		        "stylers": [
		            {
		                "visibility": "off"
		            }
		        ]
		    },
		    {
		        "featureType": "transit",
		        "elementType": "geometry",
		        "stylers": [
		            {
		                "color": "#f2f2f2"
		            },
		            {
		                "lightness": 19
		            }
		        ]
		    },
		    {
		        "featureType": "administrative",
		        "elementType": "geometry.fill",
		        "stylers": [
		            {
		                "color": "#fefefe"
		            },
		            {
		                "lightness": 20
		            }
		        ]
		    },
		    {
		        "featureType": "administrative",
		        "elementType": "geometry.stroke",
		        "stylers": [
		            {
		                "color": "#fefefe"
		            },
		            {
		                "lightness": 17
		            },
		            {
		                "weight": 1.2
		            }
		        ]
		    }
		]';
	}

	public function filter_ima_page_template( $template ) {
 		global $post;

		$ima_post_type = Interra_Marketing_Automation_CPT::$marketer_labels['post_type_name'];

 		if ( $post && $ima_post_type === $post->post_type ) {
			if ( $overridden_template = locate_template( 'page-property-marketer.php' ) ) {
				return $overridden_template;
			} else {
				return dirname( __FILE__ ) . '/templates/page-property-marketer.php';
			}
		}

		if ( $post && 'interra_disclaimer' === $post->post_type ) {
			if ( $overridden_template = locate_template( 'page-disclaimer.php' ) ) {
				return $overridden_template;
			} else {
				return dirname( __FILE__ ) . '/templates/page-disclaimer.php';
			}
		}

		return $template;
	}

	public function add_acf_fields() {
		if ( class_exists( 'IMA_ACF' ) ) {
		 new IMA_ACF();
		}
	}

	public function enqueue_plugin_scripts() {
		wp_enqueue_script(
			'interra-marketing-automation-scripts',
			Interra_Marketing_Automation_URL . 'bundles/bundle.js',
			array() ,
			'0.0.1',
			true
		);

		wp_enqueue_style(
			'interra-marketing-automation-app-styles',
			Interra_Marketing_Automation_URL . 'bundles/main.css'
		);

		wp_enqueue_style(
			'interra-marketing-automation-styles',
			Interra_Marketing_Automation_URL . 'ima-styles.css'
		);
	}

	public function boxapp_ajax_scripts($hook) {
		global $post;

		if ( $post && 'property_marketer' === $post->post_type ) {
			wp_enqueue_script(
				'boxapp-ajax-scripts',
				Interra_Marketing_Automation_URL . '/js/boxapp-ajax-client.js',
				array(),
				'1.0.0',
				true
			);

			// rent roll imports
			wp_enqueue_script(
				'ima-rent-roll-import',
				Interra_Marketing_Automation_URL . '/js/ima-rent-roll-import.js',
				array(),
				'1.0.0',
				true
			);

			wp_enqueue_script(
				'ima-mailchimp-tmpl',
				Interra_Marketing_Automation_URL . '/js/ima-mailchimp-tmpl.js',
				array(),
				'1.0.0',
				true
			);

			wp_enqueue_style(
				'interra-marketing-automation-admin-styles',
				Interra_Marketing_Automation_URL . 'admin/ima-admin-styles.css'
			);
		}
	}

}

?>
