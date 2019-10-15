<?php

require_once( get_template_directory() . '/api/permissions/torque-api-permissions-class.php');
require_once( Interra_Marketing_Automation_API_ROOT . 'controllers/interra-marketing-automation-loan-amortization-controller-class.php');

class Interra_Marketing_Automation_Loan_Amortization_Routes {

  public static $resource = '/loan-amortization/';

  private $namespace;

  public function __construct( $namespace ) {
    $this->namespace = $namespace;
  }

  public function register_routes() {

    register_rest_route( $this->namespace, self::$resource . '(?P<id>[\d]+)' , array(
	  	array(
	  		'methods'             => 'GET',
	  		'callback'            => array( $this, 'get_loan_amo' ),
	  		'args'                => Interra_Marketing_Automation_Loan_Amortization_Controller::get_loan_amo_args(),
	  		// 'permission_callback' => array('Torque_API_Permissions', 'user_can_read'),
	  	),
	  ) );
  }

  public function get_loan_amo( $request ) {
    $controller = new Interra_Marketing_Automation_Loan_Amortization_Controller( $request );
    return $controller->get_loan_amo();
  }
}

?>
