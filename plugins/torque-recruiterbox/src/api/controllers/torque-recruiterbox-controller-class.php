<?php

require_once( get_template_directory() . '/api/responses/torque-api-responses-class.php');

class Torque_RecruiterBox_Controller {

	protected $request = null;

	function __construct( $request ) {
		$this->request = $request;
	}

	public function get_api_keys() {
		try {
			$recruiterbox_api_keys = get_field( 'recruiterbox_api_keys', 'options' );

			if ( $recruiterbox_api_keys ) {
        return Torque_API_Responses::Success_Response( array(
          'api_keys'	=> $recruiterbox_api_keys
        ) );
			}

			return Torque_API_Responses::Failure_Response( array(
				'api_keys'	=> []
			));

		} catch (Exception $e) {
			return Torque_API_Responses::Error_Response( $e );
		}
	}
}
