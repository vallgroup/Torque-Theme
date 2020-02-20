<?php

define( 'Torque_Filtered_Gallery_API_ROOT', dirname(__FILE__) . '/' );

require_once( Torque_Filtered_Gallery_API_ROOT . 'routes/torque-filtered-gallery-filters-routes-class.php');
require_once( Torque_Filtered_Gallery_API_ROOT . 'routes/torque-filtered-gallery-images-routes-class.php');

/**
* The plugin API class
*/
class Torque_Filtered_Gallery_REST_Controller {

  private $namespace;

  public function __construct() {
    $this->namespace = 'filtered-gallery/v1/';

    // add API endpoints
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
  }

  // Register our routes.
  public function register_routes() {

    $filter_routes = new Torque_Filtered_Gallery_Filters_Routes( $this->namespace );
    $filter_routes->register_routes();

    $images_routes = new Torque_Filtered_Gallery_Images_Routes( $this->namespace );
    $images_routes->register_routes();
  }
}

?>
