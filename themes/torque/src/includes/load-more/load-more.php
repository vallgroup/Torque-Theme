<?php

require_once( 'load-more-loop.php' );
require_once( 'load-more-helpers.php' );

add_action( 'after_setup_theme', array( Torque_Load_More::get_inst(), 'init' ) );

class Torque_Load_More {

	public static $instance = NULL;

	public static function get_inst() {
		!self::$instance AND self::$instance = new self;

		return self::$instance;
	}

	public function __construct() {}


	private $endpoint = '/load-more/';
  private $namespace = 'torque/v1';
	private $script_id = 'load_more_js';

	private $script_data = array();

	private $test;

	public function init() {
    add_action( 'rest_api_init', array($this, 'register_route'));
    add_action( 'wp_enqueue_scripts', array($this, 'enqueue_script'));
	}

	public function register_route() {
    register_rest_route( $this->namespace, $this->endpoint , array(
      'methods' => 'POST',
      'callback' => array($this, 'get_next_page'),
      'args' => array(),
    ) );
  }

  public function enqueue_script() {
    wp_enqueue_script(
      $this->script_id,
      get_template_directory_uri() . '/bundles/loadMore.bundle.js',
      array( 'torque-theme-scripts' ), // depends on parent script
      wp_get_theme()->get('Version'),
      true       // put it in the footer );
    );
  }

	public function add_loop( Torque_Load_More_Loop $loop ) {

		$this->script_data[$loop->id] = $loop->get_data_for_js();

		wp_localize_script( $this->script_id, 'loadMoreData', $this->script_data);
	}

	public function get_next_page($request) {

		$body = $request->get_json_params();
		if ( ! (isset($body['query']) && isset($body['template']) && isset($body['id']) && isset($body['paged'])) ) {
			return new WP_Error( 'bad_request', 'Wrong params passed to request body', array( 'status' => 400 ) );
		}

		Torque_Load_More_Helpers::render_page( $body['id'], $body['paged'], $body['query'], $body['template'] );

		header('Content-Type: text/html');
    exit();
	}
}

?>
