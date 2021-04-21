<?php

require_once( get_template_directory() . '/api/permissions/torque-api-permissions-class.php');
require_once( Torque_RecruiterBox_API_ROOT . 'controllers/torque-recruiterbox-controller-class.php');

class Torque_RecruiterBox_Routes {

  public static $resource = '/secrets';

  private $namespace;

  public function __construct( $namespace ) {
    $this->namespace = $namespace;
  }

  public function register_routes() {

    register_rest_route( $this->namespace, self::$resource , array(
	  	array(
	  		'methods'             => 'GET',
	  		'callback'            => array( $this, 'get_api_keys' ),
        'permission_callback' => '__return_true',
	  	),
	  ) );

  }

  public function get_api_keys( $request ) {
    $controller = new Torque_RecruiterBox_Controller( $request );
    return $controller->get_api_keys();
  }
}

?>
