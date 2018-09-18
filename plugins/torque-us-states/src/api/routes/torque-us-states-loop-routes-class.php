<?php

require_once( get_template_directory() . '/api/permissions/torque-api-permissions-class.php');
require_once( Torque_US_States_API_ROOT . 'controllers/torque-us-states-loop-controller-class.php');

class Torque_US_States_Loop_Routes {

  public static $resource = '/loop/';

  private $namespace;

  public function __construct( $namespace ) {
    $this->namespace = $namespace;
  }

  public function register_routes() {

    register_rest_route( $this->namespace, self::$resource , array(
	  	array(
	  		'methods'             => 'GET',
	  		'callback'            => array( $this, 'get_posts' ),
	  		'args'                => Torque_US_States_Loop_Controller::get_posts_args(),
	  		// 'permission_callback' => array('Torque_API_Permissions', 'user_can_read'),
	  	),
	  ) );
  }

  public function get_posts( $request ) {
    $controller = new Torque_US_States_Loop_Controller( $request );
    return $controller->get_posts();
  }
}

?>
