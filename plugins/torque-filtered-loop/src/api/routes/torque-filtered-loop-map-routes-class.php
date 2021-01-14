<?php

require_once( get_template_directory() . '/api/permissions/torque-api-permissions-class.php');
require_once( Torque_Filtered_Loop_API_ROOT . 'controllers/torque-filtered-loop-map-controller-class.php');

class Torque_Filtered_Loop_Map_Routes {

  public static $resource = '/map-options/';

  private $namespace;

  public function __construct( $namespace ) {
    $this->namespace = $namespace;
  }

  public function register_routes() {

    register_rest_route( $this->namespace, self::$resource , array(
	  	array(
	  		'methods'             => 'GET',
	  		'callback'            => array( $this, 'get_map_options' ),
        'permission_callback' => '__return_true',
	  	),
	  ) );
  }

  public function get_map_options( $request ) {
    $controller = new Torque_Filtered_Loop_Map_Controller( $request );
    return $controller->get_map_options();
  }
}

?>
