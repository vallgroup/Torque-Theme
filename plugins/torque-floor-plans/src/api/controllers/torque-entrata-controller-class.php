<?php

require_once( get_template_directory() . '/api/responses/torque-api-responses-class.php');
require_once( get_template_directory() . '/includes/validation/torque-validation-class.php');

class Torque_Entrata_Controller {

	public static function get_unit_types_args() {
		return array();
	}

	public static function get_floor_plans_args() {
		return array(
			'unit_type_ids'				=> array(
        'validate_callback' => array( 'Torque_Validation', 'string' ),
      ),
			'start_date'						=> array(
        'validate_callback' => array( 'Torque_Validation', 'string' ),
      ),
		);
	}

	protected $request = null;

	function __construct( $request ) {

		$this->request = $request;
	}

	public function get_unit_types() {
		try {
      $result = Entrata_API::get_inst()->get_unit_types();

      return Torque_API_Responses::Success_Response( array(
        'unit_types'	=> $result
      ) );
		} catch (Exception $e) {
			return Torque_API_Responses::Error_Response( $e );
		}
	}

	public function get_floor_plans() {
		try {
      $result = Entrata_API::get_inst()->get_floor_plans(
				$this->request['unit_type_ids'] ? explode(',', $this->request['unit_type_ids']) : [],
				$this->request['start_date']
			);

      return Torque_API_Responses::Success_Response( array(
        'floor_plans'	=> $result
      ) );
		} catch (Exception $e) {
			return Torque_API_Responses::Error_Response( $e );
		}
	}

}
