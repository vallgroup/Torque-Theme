<?php

require_once( get_template_directory() . '/api/responses/torque-api-responses-class.php');
require_once( get_template_directory() . '/includes/validation/torque-validation-class.php');

class Torque_Entrata_Controller {

	public static function get_unit_types_args() {
		return array();
	}

	protected $request = null;

	function __construct( $request ) {

		$this->request = $request;
	}

	public function get_unit_types() {
		try {
      $result = Torque_Floor_Plans_Entrata::get_inst()->get_unit_types();

      return Torque_API_Responses::Success_Response( array(
        'unit_types'	=> $result
      ) );
		} catch (Exception $e) {
			return Torque_API_Responses::Error_Response( $e );
		}
	}

}
