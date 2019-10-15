<?php

require_once( get_template_directory() . '/api/permissions/torque-api-permissions-class.php');
require_once( Interra_Marketing_Automation_API_ROOT . 'controllers/interra-marketing-automation-mailchimp-controller-class.php');

class Interra_Marketing_Automation_Mailchimp_Routes {

  public static $resource = '/mailchimp/';

  private $namespace;

  public function __construct( $namespace ) {
    $this->namespace = $namespace;
  }

  public function register_routes() {

    register_rest_route( $this->namespace, self::$resource . 'email-template' , array(
	  	array(
	  		'methods'             => 'GET',
	  		'callback'            => array( $this, 'get_email_tmpl' ),
	  		'args'                => Interra_Marketing_Automation_Mailchimp_Controller::get_email_tmpl_args(),
	  		// 'permission_callback' => array('Torque_API_Permissions', 'user_can_read'),
	  	),
	  ) );
  }

  public function get_email_tmpl( $request ) {
    $controller = new Interra_Marketing_Automation_Mailchimp_Controller( $request );
    return $controller->get_email_tmpl();
  }
}

?>
