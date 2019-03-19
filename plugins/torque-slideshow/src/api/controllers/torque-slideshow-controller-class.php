<?php

require_once( get_template_directory() . '/api/responses/torque-api-responses-class.php');
require_once( get_template_directory() . '/includes/validation/torque-validation-class.php');

class Torque_Slideshow_Controller {

	public static function get_slideshow_args() {
		return array(
      'id' => array(
        'validate_callback' => array( 'Torque_Validation', 'int' ),
      ),
    );
	}

	protected $request = null;

	function __construct( $request ) {

		$this->request = $request;
	}

	public function get_slideshow() {
		try {
			$slideshow = get_post( $this->request['id'] );

			if ($slideshow) {
				$meta = [];

				if ($slideshow->post_type === Torque_Slideshow_CPT::$slideshow_labels['post_type_name']) {
					$meta = get_post_meta( $this->request['id'], 'torque_slideshow', true );

				} else if ($slideshow->post_type === Torque_Post_Slideshow_CPT::$post_slideshow_labels['post_type_name']) {
					$meta = get_fields( $this->request['id'] );
				}

        return Torque_API_Responses::Success_Response( array(
          'data'	=> array(
						'post' => $slideshow,
						'meta' => $meta
					)
        ) );
			}

			return Torque_API_Responses::Failure_Response( array(
				'data'	=> []
			));

		} catch (Exception $e) {
			return Torque_API_Responses::Error_Response( $e );
		}
	}
}
