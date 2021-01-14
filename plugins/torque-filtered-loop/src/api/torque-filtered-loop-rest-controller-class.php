<?php

define( 'Torque_Filtered_Loop_API_ROOT', dirname(__FILE__) . '/' );

require_once( Torque_Filtered_Loop_API_ROOT . 'routes/torque-filtered-loop-filters-routes-class.php');
require_once( Torque_Filtered_Loop_API_ROOT . 'routes/torque-filtered-loop-posts-routes-class.php');
require_once( Torque_Filtered_Loop_API_ROOT . 'routes/torque-filtered-loop-terms-routes-class.php');
require_once( Torque_Filtered_Loop_API_ROOT . 'routes/torque-filtered-loop-map-routes-class.php');

/**
* The plugin API class
*/
class Torque_Filtered_Loop_REST_Controller {

  private $namespace;

  public function __construct() {
    $this->namespace = 'filtered-loop/v1';

    // add API endpoints
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
  }

  // Register our routes.
  public function register_routes() {

    $filter_routes = new Torque_Filtered_Loop_Filters_Routes( $this->namespace );
    $filter_routes->register_routes();

    $posts_routes = new Torque_Filtered_Loop_Posts_Routes( $this->namespace );
    $posts_routes->register_routes();

    $terms_routes = new Torque_Filtered_Loop_Terms_Routes( $this->namespace );
    $terms_routes->register_routes();

    $map_routes = new Torque_Filtered_Loop_Map_Routes( $this->namespace );
    $map_routes->register_routes();
  }
}

?>
