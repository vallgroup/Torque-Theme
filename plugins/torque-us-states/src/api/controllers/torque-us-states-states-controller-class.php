<?php

require_once( get_template_directory() . '/api/responses/torque-api-responses-class.php');
require_once( get_template_directory() . '/includes/validation/torque-validation-class.php');

class Torque_US_States_States_Controller {

	public static function get_states_args() {
		return array();
	}

	protected $request = null;

	function __construct( $request ) {

		$this->request = $request;
	}

	public function get_states() {
		try {
			$query = new WP_Query( array(
				'post_type'				=> Torque_US_States_CPT::$us_states_labels['post_type_name'],
				'posts_per_page'	=> -1,
			));

			$states = $query->posts;

			if ($states && sizeof($states)) {

				// organise them in assoc array by state code
				$states_by_code = array();

				foreach ($states as $state) {
					$state_code = get_post_meta($state->ID, 'state_code', true);
					$states_by_code[$state_code] = $state;
				}

        return Torque_API_Responses::Success_Response( array(
          'states'	=> $states_by_code
        ) );
			}

			return Torque_API_Responses::Failure_Response( array(
				'states'	=> []
			));

		} catch (Exception $e) {
			return Torque_API_Responses::Error_Response( $e );
		}
	}
}
