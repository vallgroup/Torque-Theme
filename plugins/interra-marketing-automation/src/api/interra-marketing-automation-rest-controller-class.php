<?php

define( 'Interra_Marketing_Automation_API_ROOT', dirname(__FILE__) . '/' );

require_once( Interra_Marketing_Automation_API_ROOT . 'routes/interra-marketing-automation-example-routes-class.php');

require_once( Interra_Marketing_Automation_API_ROOT . 'routes/interra-marketing-automation-mailchimp-routes-class.php');

require_once( Interra_Marketing_Automation_API_ROOT . 'routes/interra-marketing-automation-loan-amortization-routes-class.php');

/**
* The plugin API class
*/
class Interra_Marketing_Automation_REST_Controller {

  private $namespace;

  public function __construct() {
    $this->namespace = 'ima/v1/';

    // add API endpoints
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
  }

  // Register our routes.
  public function register_routes() {

    $example_routes = new Interra_Marketing_Automation_Example_Routes( $this->namespace );
    $example_routes->register_routes();

    $mailchimp_routes = new Interra_Marketing_Automation_Mailchimp_Routes( $this->namespace );
    $mailchimp_routes->register_routes();

    $loan_amo_routes = new Interra_Marketing_Automation_Loan_Amortization_Routes( $this->namespace );
    $loan_amo_routes->register_routes();
  }
}

?>
