<?php

require_once( get_template_directory() . '/api/permissions/torque-api-permissions-class.php');
require_once( Torque_Rentcafe_API_ROOT . 'controllers/torque-rentcafe-floorplans-controller-class.php');

class Torque_Rentcafe_Floorplans_Routes {

  private $namespace;

  public function __construct( $namespace ) {
    $this->namespace = $namespace;
  }

  public function register_routes() {

    register_rest_route( 
			$this->namespace,
			'/floorplans/',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'get_floorplans' ),
					'args'                => Torque_Rentcafe_Floorplans_Controller::get_args(),
					'permission_callback' => '__return_true',
				),
		) );

    register_rest_route( 
			$this->namespace,
			'/refresh_cache/',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'refresh_cache' ),
					'permission_callback' => '__return_true',
				),
		) );
		
  }

  public function get_floorplans( $request ) {
    $controller = new Torque_Rentcafe_Floorplans_Controller( $request );
    return $controller->get_floorplans();
	}

  public function refresh_cache( $request ) {
    $controller = new Torque_Rentcafe_Floorplans_Controller( $request );
    return $controller->refresh_cache();
	}
	
}

?>
