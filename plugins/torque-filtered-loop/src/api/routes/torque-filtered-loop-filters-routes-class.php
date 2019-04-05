<?php

require_once( get_template_directory() . '/api/permissions/torque-api-permissions-class.php');
require_once( Torque_Filtered_Loop_API_ROOT . 'controllers/torque-filtered-loop-filters-controller-class.php');

class Torque_Filtered_Loop_Filters_Routes {

  public static $resource = '/filters/';

  private $namespace;

  public function __construct( $namespace ) {
    $this->namespace = $namespace;
  }

  public function register_routes() {

    register_rest_route( $this->namespace, self::$resource.'acf-select' , array(
	  	array(
	  		'methods'             => 'GET',
	  		'callback'            => array( $this, 'get_filter_acf_select' ),
	  		'args'                => Torque_Filtered_Loop_Filters_Controller::get_filter_acf_select_args(),
	  		//'permission_callback' => array('Torque_API_Permissions', 'user_can_read'),
	  	),
	  ) );

    register_rest_route( $this->namespace, self::$resource.'dropdown-date' , array(
	  	array(
	  		'methods'             => 'GET',
	  		'callback'            => array( $this, 'get_filter_dropdown_date' ),
	  		'args'                => Torque_Filtered_Loop_Filters_Controller::get_filter_dropdown_date_args(),
	  		//'permission_callback' => array('Torque_API_Permissions', 'user_can_read'),
	  	),
	  ) );
  }

  public function get_filter_acf_select( $request ) {
    $controller = new Torque_Filtered_Loop_Filters_Controller( $request );
    return $controller->get_filter_acf_select();
  }

  public function get_filter_dropdown_date( $request ) {
    $controller = new Torque_Filtered_Loop_Filters_Controller( $request );
    return $controller->get_filter_dropdown_date();
  }
}

?>
