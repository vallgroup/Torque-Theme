<?php

require_once( get_template_directory() . '/api/permissions/torque-api-permissions-class.php');
require_once( Torque_Filtered_Loop_API_ROOT . 'controllers/torque-filtered-loop-terms-controller-class.php');

class Torque_Filtered_Loop_Terms_Routes {

  public static $resource = '/terms/';

  private $namespace;

  public function __construct( $namespace ) {
    $this->namespace = $namespace;
  }

  public function register_routes() {

    register_rest_route( $this->namespace, self::$resource , array(
	  	array(
	  		'methods'             => 'GET',
	  		'callback'            => array( $this, 'get_terms' ),
	  		'args'                => Torque_Filtered_Loop_Terms_Controller::get_terms_args(),
	  		//'permission_callback' => array('Torque_API_Permissions', 'user_can_read'),
	  	),
	  ) );


    register_rest_route( $this->namespace, self::$resource . 'get-neighborhood-order/' , array(
      array(
        'methods'             => 'GET',
        'callback'            => array( $this, 'get_neighborhood_order' ),
        // 'args'                => array(),
        //'permission_callback' => array('Torque_API_Permissions', 'user_can_read'),
      ),
    ) );
  }

  public function get_terms( $request ) {
    $controller = new Torque_Filtered_Loop_Terms_Controller( $request );
    return $controller->get_terms();
  }

  public function get_neighborhood_order( $request ) {
    $controller = new Torque_Filtered_Loop_Terms_Controller( $request );
    return $controller->get_neighborhood_order();
  }
}

?>
