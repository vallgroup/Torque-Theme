<?php

define( 'Torque_Image_Grid_API_ROOT', dirname(__FILE__) . '/' );

require_once( Torque_Image_Grid_API_ROOT . 'routes/torque-image-grid-routes-class.php');

/**
* The plugin API class
*/
class Torque_Image_Grid_REST_Controller {

  private $namespace;

  public function __construct() {
    $this->namespace = 'image-grid/v1/';

    // add API endpoints
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
  }

  // Register our routes.
  public function register_routes() {

    $example_routes = new Torque_Image_Grid_Routes( $this->namespace );
    $example_routes->register_routes();
  }
}

?>
