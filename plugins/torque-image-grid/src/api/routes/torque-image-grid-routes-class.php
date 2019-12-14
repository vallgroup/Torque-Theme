<?php

require_once( get_template_directory() . '/api/permissions/torque-api-permissions-class.php');
require_once( Torque_Image_Grid_API_ROOT . 'controllers/torque-image-grid-controller-class.php');

class Torque_Image_Grid_Routes {

  public static $resource = '/torque-image-grid/';

  private $namespace;

  public function __construct( $namespace ) {
    $this->namespace = $namespace;
  }

  public function register_routes() {

		register_rest_route( 
			$this->namespace,
			self::$resource , 
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'get_image_grid' ),
					'args'                => Torque_Image_Grid_Controller::get_image_grid_args()
				),
	  ) );
  }

  public function get_image_grid( $request ) {
		$controller = new Torque_Image_Grid_Controller( $request );
    return $controller->get_image_grid();
  }
}

?>
