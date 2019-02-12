<?php

require_once( get_template_directory() . '/api/permissions/torque-api-permissions-class.php');
require_once( Torque_Slideshow_API_ROOT . 'controllers/torque-slideshow-controller-class.php');

class Torque_Slideshow_Routes {

  public static $resource = '/slideshows/(?P<id>[\d]+)';

  private $namespace;

  public function __construct( $namespace ) {
    $this->namespace = $namespace;
  }

  public function register_routes() {

    register_rest_route( $this->namespace, self::$resource , array(
	  	array(
	  		'methods'             => 'GET',
	  		'callback'            => array( $this, 'get_slideshow' ),
	  		'args'                => Torque_Slideshow_Controller::get_slideshow_args(),
	  		//'permission_callback' => array('Torque_API_Permissions', 'user_can_read'),
	  	),
	  ) );
  }

  public function get_slideshow( $request ) {
    $controller = new Torque_Slideshow_Controller( $request );
    return $controller->get_slideshow();
  }
}

?>
