<?php

require_once( get_template_directory() . '/api/permissions/torque-api-permissions-class.php');
require_once( <torque_plugin_class_name>_API_ROOT . 'controllers/<torque_plugin_slug>-example-controller-class.php');

class <torque_plugin_class_name>_Example_Routes {

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
	  		'args'                => <torque_plugin_class_name>_Example_Controller::get_examples_args(),
	  		'permission_callback' => array('Torque_API_Permissions', 'user_can_read'),
	  	),
	  ) );

    register_rest_route( $this->namespace, self::$resource, array(
	  	array(
	  		'methods'             => 'PUT',
	  		'callback'            => array( $this, 'update_example' ),
	  		'args'                => <torque_plugin_class_name>_Example_Controller::update_example_args(),
	  		'permission_callback' => array('Torque_API_Permissions', 'user_can_create'),
	  	),
	  ) );

	  register_rest_route( $this->namespace, self::$resource, array(
	  	array(
	  		'methods'             => 'DELETE',
	  		'callback'            => array( $this, 'delete_example' ),
	  		'args'                => <torque_plugin_class_name>_Example_Controller::delete_example_args(),
	  		'permission_callback' => array('Torque_API_Permissions', 'user_can_create'),
	  	),
	  ) );
  }

  public function get_example( $request ) {
    $controller = new <torque_plugin_class_name>_Example_Controller( $request );
    return $controller->get_example();
  }

  public function update_exmaple( $request ) {
    $controller = new <torque_plugin_class_name>_Example_Controller( $request );
    return $controller->update_example();
  }

  public function delete_example( $request ) {
    $controller = new <torque_plugin_class_name>_Example_Controller( $request );
    return $controller->delete_example();
  }
}

?>
