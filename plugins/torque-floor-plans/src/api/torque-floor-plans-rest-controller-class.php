<?php

define( 'Torque_Floor_Plans_API_ROOT', dirname(__FILE__) . '/' );

require_once( Torque_Floor_Plans_API_ROOT . 'routes/torque-floor-plans-example-routes-class.php');

/**
* The plugin API class
*/
class Torque_Floor_Plans_REST_Controller {

  private $namespace;

  public function __construct() {
    $this->namespace = 'floor-plans/v1/';

    // add API endpoints
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
  }

  // Register our routes.
  public function register_routes() {

    $example_routes = new Torque_Floor_Plans_Example_Routes( $this->namespace );
    $example_routes->register_routes();
  }
}

?>
