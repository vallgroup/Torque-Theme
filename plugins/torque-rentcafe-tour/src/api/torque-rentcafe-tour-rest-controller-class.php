<?php

define( 'Torque_Rentcafe_Tour_API_ROOT', dirname(__FILE__) . '/' );

require_once( Torque_Rentcafe_Tour_API_ROOT . 'routes/torque-rentcafe-tour-routes-class.php');

/**
* The plugin API class
*/
class Torque_Rentcafe_Tour_REST_Controller {

  private $namespace;

  public function __construct() {
    $this->namespace = 'torque-rentcafe-tour/v1';

    // add API endpoints
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
  }

  // Register our routes.
  public function register_routes() {

    $example_routes = new Torque_Rentcafe_Tour_Routes( $this->namespace );
    $example_routes->register_routes();
  }
}

?>
