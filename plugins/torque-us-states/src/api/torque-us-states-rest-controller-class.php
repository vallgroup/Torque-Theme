<?php

define( 'Torque_US_States_API_ROOT', dirname(__FILE__) . '/' );

require_once( Torque_US_States_API_ROOT . 'routes/torque-us-states-options-routes-class.php');

/**
* The plugin API class
*/
class Torque_US_States_REST_Controller {

  private $namespace;

  public function __construct() {
    $this->namespace = 'us-states/v1/';

    // add API endpoints
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
  }

  // Register our routes.
  public function register_routes() {

    $us_states_options_routes = new Torque_US_States_Options_Routes( $this->namespace );
    $us_states_options_routes->register_routes();
  }
}

?>
