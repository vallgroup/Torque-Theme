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
			$tax = get_taxonomy( $this->request['tax'] );
			$tax_name = $tax->singular_label ?? $tax->label;

			if ($terms && $tax_name) {
				return Torque_API_Responses::Success_Response( array(
          'terms'	=> $terms,
					'tax_name' => $tax_name
        ) );
			}

			return Torque_API_Responses::Failure_Response( array(
				'terms'	=> [],
				'tax_name' => ''
			));

		} catch (Exception $e) {
			return Torque_API_Responses::Error_Response( $e );
		}
	}


	public function get_neighborhood_order() {
		try {

			$order = get_field('order_neighborhoods', 'options');
			if ($order) {
				$order_ids = [];
				foreach ( $order as $_o ) {
					$order_ids[] = $_o['neighborhood'];
				}
				return Torque_API_Responses::Success_Response( array(
          'order'	=> $order_ids,
        ) );
			}

			return Torque_API_Responses::Failure_Response( array(
				'order'	=> [],
			));

		} catch (Exception $e) {
			return Torque_API_Responses::Error_Response( $e );
		}
	}
}
