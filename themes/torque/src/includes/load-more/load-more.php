<?php

require_once( 'load-more-loop.php' );
require_once( 'load-more-helpers.php' );

/**
 * Usage:
 *
 * 1. Create a new Torque_Load_More_Loop instance
 *
 * $blog_posts_loop = new Torque_Load_More_Loop(
 * 	'blog-posts',
 *	 10,
 *	 array( 'author'  => get_the_ID() ),        // can use template tags in our query
 *  'parts/shared/loop-blog.php'
 * );
 *
 * 2. Register loop instance with this class
 *
 * Torque_Load_More::get_inst()->register_loop( $blog_posts_loop );
 *
 * 3. Include first page of the loop in your template
 *
 * if ( $blog_posts_loop->has_first_page() ) {
 * 	 $blog_posts_loop->the_first_page();
 * }
 *
 *
 *
 *
 * Overview of the problem we solve here:
 *
 * We want to be able to run a 'load more' loop using data from the wp loop in the query
 * (ie template tags).
 *
 * ==============
 *
 * 		The issue with this is that by the time the wp loop has started, it's too late to register a 'rest_api_init' action
 * 		and register an endpoint with a callback involving data from the loop.
 *
 * 		rest_api_init -> wp_loop_start -> create endpoint using data from loop
 *
 * 		X doesnt work
 *
 * 		So we need to register a single endpoint before the loop starts which takes requests params which are generalised to all loops,
 * 		then create the query using template tags from the wp loop,
 * 		and then pass the load more loop query to the script so it can use it to hit the endpoint and get new posts
 *
 * 		create single endpoint -> rest_api_init -> wp_loop_start -> pass load more loop data to script -> script calls endpoint with data
 *
 * 			/
 * 		\/ works
 *
 *
 * 		So the solution, is enqueue the load more script and register the endpoint at 'after_setup_theme',
 * 		then every time we register a load more loop from within the wp loop,
 * 		we re-localize the load more script and add our load more loop's data to it,
 * 		so that by the time the script is loaded it has data for all load more loops appearing on the page.
 *
 * 		When the 'load more' button relevant to a given load more loop is clicked,
 * 		the script now has everything it needs to hit that single endpoint and get the next page of posts
 *
 */

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

	/**
	 * Enqueue script and set up generalised 'next page' endpoint when this class inits
	 */
	public function init() {
    add_action( 'rest_api_init', array($this, 'register_route'));
    add_action( 'wp_enqueue_scripts', array($this, 'enqueue_script'));
	}

	/**
	 * POST request so we can send a complex query object in the body
	 * without having to worry about encoding anything.
	 *
	 * It actually works more like a GET
	 */
	public function register_route() {
    register_rest_route( $this->namespace, $this->endpoint , array(
      'methods' => 'POST',
      'callback' => array($this, 'get_next_page'),
			'permission_callback' => '__return_true',
			'args' => array(),
    ) );
  }

	/**
	 * Callback for our endpoint.
	 *
	 * It gets the next page of posts, and next load more button if necessary, and returns it as html
	 */
	public function get_next_page($request) {

		$body = $request->get_json_params();
		if ( ! (isset($body['query']) && isset($body['template']) && isset($body['id']) && isset($body['paged'])) ) {
			return new WP_Error( 'bad_request', 'Wrong params passed to request body', array( 'status' => 400 ) );
		}

		Torque_Load_More_Helpers::render_page( $body['id'], $body['paged'], $body['query'], $body['template'] );

		header('Content-Type: text/html');
		exit();
	}

	/**
	 * Enqueue our load more script.
	 *
	 * We keep it separate from the theme's 'main' script so we can localize it more easily
	 */
  public function enqueue_script() {
    wp_enqueue_script(
      $this->script_id,
      get_template_directory_uri() . '/bundles/loadMore.bundle.js',
      array( 'torque-theme-scripts' ), // depends on parent script
      wp_get_theme()->get('Version'),
      true       // put it in the footer );
    );
  }

	/**
	 * Register a new load more loop, and add pass its' data to the script
	 *
	 * @param  Torque_Load_More_Loop $loop
	 */
	public function register_loop( Torque_Load_More_Loop $loop ) {

		$this->script_data[$loop->id] = $loop->get_data_for_js();

		wp_localize_script( $this->script_id, 'loadMoreData', $this->script_data);
	}
}

?>
