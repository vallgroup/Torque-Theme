<?php

define( '<torque_plugin_class_name>_API_ROOT', dirname(__FILE__) . '/' );

require_once( <torque_plugin_class_name>_API_ROOT . 'routes/<torque_plugin_slug>-example-routes-class.php');

/**
* The plugin API class
*/
class <torque_plugin_class_name>_REST_Controller {

  private $namespace;

  public function __construct() {
    $this->namespace = '<torque_plugin_namespace>';

    // add API endpoints
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
  }

  // Register our routes.
  public function register_routes() {

    $example_routes = new <torque_plugin_class_name>_Example_Routes( $this->namespace );
    $example_routes->register_routes();
  }
}

?>
