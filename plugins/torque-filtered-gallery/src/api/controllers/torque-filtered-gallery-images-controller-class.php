<?php

require_once( get_template_directory() . '/api/responses/torque-api-responses-class.php');
require_once( get_template_directory() . '/includes/validation/torque-validation-class.php');

class Torque_Filtered_Gallery_Images_Controller {

	public static function get_images_args() {
		return array(
      'gallery_id' => array(
        'validate_callback' => array( 'Torque_Validation', 'string' ),
			),
    );
	}

	protected $request = null;
	protected $params = array();

	function __construct( $request ) {
		$this->request = $request;
		$this->params = $this->request->get_params();
	}

	public function get_images() {
		try {
			// search for images
			$queried_images = $this->build_image_response();

			if ( $queried_images ) {
				return Torque_API_Responses::Success_Response( array(
					'images'	=> $queried_images
				) );
			}
			
			return Torque_API_Responses::Failure_Response( array(
				'images'	=> []
			));

		} catch (Exception $e) {
			return Torque_API_Responses::Error_Response( $e );
		}
	}

	private function build_image_response() {
		$queried_images = null;

		// get the query args
		$query_args = $this->build_query_from_params($this->request->get_params());
		
		// get all images in the gallery
		$all_images = isset( $query_args['gallery_id'] )
			? get_field( 'filtered_gallery_images', $query_args['gallery_id'] )
			: null;

		// if images found and query param set
		if ( $all_images && isset( $query_args['meta_query'] ) ) {
			foreach ( $all_images as $image ) {
				// get all cats assigned to image
				$image_cats = get_field( 'filtered_gallery_categories', $image['ID'] );
				foreach ( $query_args['meta_query'] as $meta_query ) {
					// check if the queried category is in the array of image categories
					if ( 
						$image_cats 
						&& isset( $meta_query['value'] )
						&& in_array( $meta_query['value'], $image_cats ) 
					) {
						// push the image to the queried array
						$queried_images[] = $image;
					}
				}
			}
		} elseif ( $all_images ) {
			// simply return all images
			$queried_images = $all_images;
		}

		return $queried_images;
	}

	private function build_query_from_params($params) {
		$query = array();

		foreach ($params as $key => $value) {

			// meta query params
			if (substr($key, 0 ,5) === 'meta_') {
				if ($value === "0") {
					continue;
				}
				$meta_key = substr($key, 5);

				if (substr($meta_key, 0, 6) === 'field_') {
					// is acf key, need to get the field name
					$field = get_field_object( $meta_key );
					$meta_key = $field['name'];
				}

				$query['meta_query'][] = array(
					'key'	  => $meta_key,
					'value'	=> $value
				);
				continue;
			}

			// other params
			$query[$key] = $value;
		}

		return $query;
	}
}
