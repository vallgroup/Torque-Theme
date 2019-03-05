<?php

define( 'Torque_Floor_Plans_API_ROOT', dirname(__FILE__) . '/' );

require_once( Torque_Floor_Plans_API_ROOT . 'routes/torque-floor-plan-routes-class.php');
require_once( Torque_Floor_Plans_API_ROOT . 'routes/torque-entrata-routes-class.php');

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

    $floor_plan_routes = new Torque_Floor_Plan_Routes( $this->namespace );
    $floor_plan_routes->register_routes();

    $entrata_routes = new Torque_Entrata_Routes( $this->namespace );
    $entrata_routes->register_routes();
  }
}

?>
