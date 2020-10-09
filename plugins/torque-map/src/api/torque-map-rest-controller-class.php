<?php

define( 'Torque_Map_API_ROOT', dirname(__FILE__) . '/' );

require_once( Torque_Map_API_ROOT . 'routes/torque-map-routes-class.php');

/**
* The plugin API class
*/
class Torque_Map_REST_Controller {

  private $namespace;

  public function __construct() {
    $this->namespace = 'torque-map/v1';

    // add API endpoints
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
  }

  // Register our routes.
  public function register_routes() {

    $example_routes = new Torque_Map_Routes( $this->namespace );
    $example_routes->register_routes();
  }
}

?>
