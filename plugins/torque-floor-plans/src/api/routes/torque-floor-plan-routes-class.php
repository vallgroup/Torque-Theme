<?php

require_once( Torque_Floor_Plans_API_ROOT . 'controllers/torque-floor-plan-controller-class.php');

class Torque_Floor_Plan_Routes {

  public static $resource = '/floor-plans/';

  private $namespace;

  public function __construct( $namespace ) {
    $this->namespace = $namespace;
  }

  public function register_routes() {

    register_rest_route( $this->namespace, self::$resource , array(
	  	array(
	  		'methods'             => 'GET',
	  		'callback'            => array( $this, 'get_floor_plans' ),
	  		'args'                => Torque_Floor_Plan_Controller::get_floor_plans_args(),
	  	),
	  ) );
  }

  public function get_floor_plans( $request ) {
    $controller = new Torque_Floor_Plan_Controller( $request );
    return $controller->get_floor_plans();
  }
}

?>
