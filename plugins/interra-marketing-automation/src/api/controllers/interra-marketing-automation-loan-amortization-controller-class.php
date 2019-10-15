<?php

require_once( get_template_directory() . '/api/responses/torque-api-responses-class.php');
require_once( get_template_directory() . '/includes/validation/torque-validation-class.php');

class Interra_Marketing_Automation_Loan_Amortization_Controller {

	protected $request = null;

	public static function get_loan_amo_args() {
		return array(
      'id' => array(
        'validate_callback' => array( 'Torque_Validation', 'int' ),
      ),
    );
	}

	function __construct( $request ) {

		$this->request = $request;
	}

	public function get_loan_amo() {
		try {

			$params = $this->request->get_params();

			$doc = get_post( (int) $params['id'] );
			$doc_post_type = Interra_Marketing_Automation_CPT::$marketer_labels['post_type_name'];

			if ( $doc
				&& $doc->post_type === $doc_post_type ) {
				// build the response
				$term           = get_field( 'term', $doc->ID );
				$down_payment   = get_field( 'down_payment', $doc->ID );
				$property_value = get_field( 'property_value', $doc->ID );
				$interest_rate  = get_field( 'interest_rate', $doc->ID );

				$response = array(
					'term'           => $term['value'],
					'down_payment'   => $down_payment,
					'property_value' => $property_value,
					'interest_rate'  => $interest_rate,
				);

	      return Torque_API_Responses::Success_Response( array(
	        'loan_amo'	=> $response,
	      ) );
			} else {
				// you are passing the wrong ID
				return Torque_API_Responses::Failure_Response( array(
					'message' => 'we could not find any Documents with that ID.'
				) );
			}

		} catch (Exception $e) {
			return Torque_API_Responses::Error_Response( $e );
		}
	}
}
