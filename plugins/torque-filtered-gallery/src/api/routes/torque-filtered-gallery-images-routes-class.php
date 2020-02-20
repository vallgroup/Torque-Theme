<?php

require_once( get_template_directory() . '/api/permissions/torque-api-permissions-class.php');
require_once( Torque_Filtered_Gallery_API_ROOT . 'controllers/torque-filtered-gallery-images-controller-class.php');

class Torque_Filtered_Gallery_Images_Routes {

  public static $resource = '/images/';

  private $namespace;

  public function __construct( $namespace ) {
    $this->namespace = $namespace;
  }

  public function register_routes() {

    register_rest_route( $this->namespace, self::$resource , array(
	  	array(
	  		'methods'             => 'GET',
	  		'callback'            => array( $this, 'get_images' ),
	  		'args'                => Torque_Filtered_Gallery_Images_Controller::get_images_args(),
	  	),
	  ) );
  }

  public function get_images( $request ) {
    $controller = new Torque_Filtered_Gallery_Images_Controller( $request );
    return $controller->get_images();
  }
}

?>
