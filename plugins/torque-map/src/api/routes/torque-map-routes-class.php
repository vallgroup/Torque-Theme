<?php

require_once( get_template_directory() . '/api/permissions/torque-api-permissions-class.php');
require_once( Torque_Map_API_ROOT . 'controllers/torque-map-controller-class.php');

class Torque_Map_Routes {

  public static $resource = '/map/(?P<id>[\d]+)';

  private $namespace;

  public function __construct( $namespace ) {
    $this->namespace = $namespace;
  }

  public function register_routes() {

    register_rest_route( $this->namespace, self::$resource , array(
	  	array(
	  		'methods'             => 'GET',
	  		'callback'            => array( $this, 'get_map' ),
        'args'                => Torque_Map_Controller::get_map_args(),
  			'permission_callback' => '__return_true',
	  		// 'permission_callback' => array('Torque_API_Permissions', 'user_can_read'),
	  	),
	  ) );
  }

  public function get_map( $request ) {
    $controller = new Torque_Map_Controller( $request );
    return $controller->get_map();
  }
}

?>
