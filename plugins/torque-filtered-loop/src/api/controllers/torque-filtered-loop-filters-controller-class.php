<?php

require_once( get_template_directory() . '/api/responses/torque-api-responses-class.php');
require_once( get_template_directory() . '/includes/validation/torque-validation-class.php');

class Torque_Filtered_Loop_Filters_Controller {

	public static function get_filter_acf_select_args() {
		return array(
      'field_id' => array(
        'validate_callback' => array( 'Torque_Validation', 'str' ),
      ),
    );
	}

	protected $request = null;

	function __construct( $request ) {

		$this->request = $request;
	}

	public function get_filter_acf_select() {
		try {
			$field = get_field_object( $this->request['field_id'] );
			$choices = $field['choices'];

			if ($choices) {
        return Torque_API_Responses::Success_Response( array(
          'choices'	=> $choices
        ) );
			}

			return Torque_API_Responses::Failure_Response( array(
				'choices'	=> []
			));

		} catch (Exception $e) {
			return Torque_API_Responses::Error_Response( $e );
		}
	}
}
