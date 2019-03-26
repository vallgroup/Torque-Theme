<?php

require_once( get_template_directory() . '/api/responses/torque-api-responses-class.php');
require_once( get_template_directory() . '/includes/validation/torque-validation-class.php');

class Torque_Filtered_Loop_Terms_Controller {

	public static function get_terms_args() {
		return array(
      'tax' => array(
        'validate_callback' => array( 'Torque_Validation', 'string' ),
      )
    );
	}

	protected $request = null;

	function __construct( $request ) {
		$this->request = $request;
	}

	public function get_terms() {
		try {
			$terms = get_terms( $this->request['tax'] );

			if ($terms) {
				return Torque_API_Responses::Success_Response( array(
          'terms'	=> $terms
        ) );
			}

			return Torque_API_Responses::Failure_Response( array(
				'terms'	=> []
			));

		} catch (Exception $e) {
			return Torque_API_Responses::Error_Response( $e );
		}
	}
}
