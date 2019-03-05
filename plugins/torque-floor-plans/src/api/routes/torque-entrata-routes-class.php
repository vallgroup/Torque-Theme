<?php

require_once( Torque_Floor_Plans_API_ROOT . 'controllers/torque-entrata-controller-class.php');

class Torque_Entrata_Routes {

  public static $resource = '/entrata/';

  private $namespace;

  public function __construct( $namespace ) {
    $this->namespace = $namespace;
  }

  public function register_routes() {

    register_rest_route( $this->namespace, self::$resource.'unit-types' , array(
	  	array(
	  		'methods'             => 'GET',
	  		'callback'            => array( $this, 'get_unit_types' ),
	  		'args'                => Torque_Entrata_Controller::get_unit_types_args(),
	  	),
	  ) );
  }

  public function get_unit_types( $request ) {
    $controller = new Torque_Entrata_Controller( $request );
    return $controller->get_unit_types();
  }

  public function get_available_units( $request ) {
    $controller = new Torque_Entrata_Controller( $request );
    return $controller->get_available_units();
  }
}

?>
