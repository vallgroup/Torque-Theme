<?php

define( 'Torque_Rentcafe_API_ROOT', dirname(__FILE__) . '/' );

require_once( Torque_Rentcafe_API_ROOT . 'routes/torque-rentcafe-floorplans-routes-class.php');

/**
* The plugin API class
*/
class Torque_Rentcafe_REST_Controller {

  private $namespace;

  public function __construct() {
    $this->namespace = 'torque-rentcafe/v1/';

    // add API endpoints
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
  }

  // Register our routes.
  public function register_routes() {

    $floorplans_routes = new Torque_Rentcafe_Floorplans_Routes( $this->namespace );
    $floorplans_routes->register_routes();
  }
}

?>
