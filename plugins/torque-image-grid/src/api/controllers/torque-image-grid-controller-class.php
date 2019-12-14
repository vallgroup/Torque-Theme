<?php

require_once( get_template_directory() . '/api/responses/torque-api-responses-class.php');
require_once( get_template_directory() . '/includes/validation/torque-validation-class.php');

class Torque_Image_Grid_Controller {

	public static function get_image_grid_args() {
		return array(
      'slug' => array(
        'validate_callback' => array( 'Torque_Validation', 'string' ),
      ),
    );
	}

	protected $request = null;
	protected $params = array();

	public function __construct( $request ) {
		$this->request = $request;
		$this->params = $this->request->get_params();
	}

	public function get_image_grid() {
		try {
			$image_grid = $this->get_image_grid_data();
			if ( $image_grid ) {
        return Torque_API_Responses::Success_Response( array(
					'grid' => $image_grid
        ) );
			}
			return Torque_API_Responses::Failure_Response( array(
				'message' => 'No image grid was found.'
			) );
		} catch (Exception $e) {
			return Torque_API_Responses::Error_Response( $e );
		}
	}

	private function get_image_grid_data() {
		$_grids = get_posts( array(
			'numberposts' => 1,
			'post_type' => Torque_Image_Grid_CPT::$POST_TYPE,
			'name' => strip_tags( $this->params['slug'] ),
		) );

		if ( $_grids ) {
			$_grid = $_grids[0];
		} else {
			return false;
		}

		// prepare media link for API response
		$images = get_field( 'images', $_grid->ID );
		foreach ( $images as $key => $image ) {
			$media_link = get_field( 'media_link', $image['ID'] );
			$images[$key]['media_link'] = $media_link ? $media_link : [] ;
		}
		
		return array(
			'id' => $_grid->ID,
			'title' => $_grid->post_title,
			'content' => $_grid->post_content,
			'images' => $images,
			'images_per_row' => get_field( 'images_per_row', $_grid->ID ),
		);
	}
}
