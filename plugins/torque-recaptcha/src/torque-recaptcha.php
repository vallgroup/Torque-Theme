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
		add_action( 'wp_head', array( $this, 'hook_google' ) );

		// add ajax validation
		add_action( 'wp_ajax_validate_recaptcha', array( $this, 'validate_recaptcha' ) );
		add_action( 'wp_ajax_nopriv_validate_recaptcha', array( $this, 'validate_recaptcha' ) );
	}

	public function enqueue_plugin_scripts() {

		// get the site key
    $site_key = get_field( 'tq_recaptcha_api_key', 'option' );
    $form_selector = get_field( 'tq_recaptcha_form_selector', 'option' );
    $action = 'validate_recaptcha';

		// register script
		wp_register_script(
			'torque-recaptcha-scripts',
			Torque_Recaptcha_URL . 'bundles/bundle.js',
			array('jquery') ,
			'0.0.2',
			true
		);
		// localize vars for script
		wp_localize_script(
			'torque-recaptcha-scripts',
			'tqRecaptcha',
			array( 
				'ajaxURL' => admin_url( 'admin-ajax.php' ),
				'siteKey' => $site_key,
				'formSelector' => $form_selector,
				'action' => $action,
			)
		);
		// first enqueue jQuery
		wp_enqueue_script( 'jquery' );
		// then enqueue our reCAPTCHA
		wp_enqueue_script( 'torque-recaptcha-scripts' );

		// enqueue the styles
		wp_enqueue_style(
			'torque-recaptcha-styles',
			Torque_Recaptcha_URL . 'bundles/main.css'
		);
		
	}

	public function hook_google() {
    $recaptcha_version = get_field('tq_recaptcha_version', 'option');
    $api_key = get_field('tq_recaptcha_api_key', 'option');
		if (
			'v2_invisible' === $recaptcha_version
			|| 'v3' === $recaptcha_version
		) {
			echo '<script src="https://www.google.com/recaptcha/api.js?render='.$api_key.'"></script>';
    } elseif ( 'v2_checkbox' === $recaptcha_version ) {
			echo '<script src="https://www.google.com/recaptcha/api.js"></script>';
		}
	}

	public function validate_recaptcha() {
		// check the reCAPTCHA response isn't empty
		if (
			$_POST['g-recaptcha-response']
			&& ! empty( $_POST['g-recaptcha-response'] )
		) {
			// set the verify URL
			$url = 'https://www.google.com/recaptcha/api/siteverify';
			$secret_key = get_field('tq_recaptcha_secret_key', 'option');
			// check for a match
			$response = file_get_contents( $url."?secret=".$secret_key."&response=".$_POST['g-recaptcha-response'] );
			$data = json_decode( $response );

			// send response to JS
			if ( $data->success == true ) {
				echo 'valid';
			} else {
				echo 'invalid';
			}

			// this is required to terminate immediately and return a proper response
			wp_die();
		}
	}
}

?>
