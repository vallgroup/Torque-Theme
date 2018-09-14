<?php

require_once( get_template_directory() . '/api/responses/torque-api-responses-class.php');
require_once( get_template_directory() . '/includes/validation/torque-validation-class.php');

class Torque_US_States_Options_Controller {

	public static function get_options_args() {
		return array();
	}

	protected $request = null;

	function __construct( $request ) {

		$this->request = $request;
	}

	public function get_options() {
		try {
			$options = array(
				'post_types' => get_option( Torque_US_States_CPT::$POST_TYPES_WITH_STATE_ASSIGNER_OPTION_HANDLE )
			);

			if ($options && sizeof($options)) {
        return Torque_API_Responses::Success_Response( array(
          'options'	=> $options
        ) );
			}

			return Torque_API_Responses::Failure_Response( array(
				'options'	=> []
			));

		} catch (Exception $e) {
			return Torque_API_Responses::Error_Response( $e );
		}
	}
}
