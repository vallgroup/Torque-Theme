<?php

define( 'Torque_Slideshow_API_ROOT', dirname(__FILE__) . '/' );

require_once( Torque_Slideshow_API_ROOT . 'routes/torque-slideshow-example-routes-class.php');

/**
* The plugin API class
*/
class Torque_Slideshow_REST_Controller {

  private $namespace;

  public function __construct() {
    $this->namespace = 'slideshow/v1/';

    // add API endpoints
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
  }

  // Register our routes.
  public function register_routes() {

    $example_routes = new Torque_Slideshow_Example_Routes( $this->namespace );
    $example_routes->register_routes();
  }
}

?>
