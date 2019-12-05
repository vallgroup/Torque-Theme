<?php

require_once( get_template_directory() . '/api/permissions/torque-api-permissions-class.php');
require_once( Torque_Image_Grid_API_ROOT . 'controllers/torque-image-grid-example-controller-class.php');

class Torque_Image_Grid_Routes {

  public static $resource = '/examples/';

  private $namespace;

  public function __construct( $namespace ) {
    $this->namespace = $namespace;
  }

  public function register_routes() {

    register_rest_route( $this->namespace, self::$resource , array(
	  	array(
	  		'methods'             => 'GET',
	  		'callback'            => array( $this, 'get_example' ),
	  		'args'                => Torque_Image_Grid_Controller::get_image_grid_args(),
	  		'permission_callback' => array('Torque_API_Permissions', 'user_can_read'),
	  	),
	  ) );

    register_rest_route( $this->namespace, self::$resource, array(
	  	array(
	  		'methods'             => 'PUT',
	  		'callback'            => array( $this, 'update_example' ),
	  		'args'                => Torque_Image_Grid_Controller::update_image_grid_args(),
	  		'permission_callback' => array('Torque_API_Permissions', 'user_can_create'),
	  	),
	  ) );

	  register_rest_route( $this->namespace, self::$resource, array(
	  	array(
	  		'methods'             => 'DELETE',
	  		'callback'            => array( $this, 'delete_example' ),
	  		'args'                => Torque_Image_Grid_Controller::delete_image_grid_args(),
	  		'permission_callback' => array('Torque_API_Permissions', 'user_can_create'),
	  	),
	  ) );
  }

  public function get_example( $request ) {
    $controller = new Torque_Image_Grid_Controller( $request );
    return $controller->get_example();
  }

  public function update_exmaple( $request ) {
    $controller = new Torque_Image_Grid_Controller( $request );
    return $controller->update_example();
  }

  public function delete_example( $request ) {
    $controller = new Torque_Image_Grid_Controller( $request );
    return $controller->delete_example();
  }
}

?>
