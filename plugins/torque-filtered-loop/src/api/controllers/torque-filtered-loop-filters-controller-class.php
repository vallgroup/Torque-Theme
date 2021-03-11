<?php

require_once( get_template_directory() . '/api/responses/torque-api-responses-class.php');
require_once( get_template_directory() . '/includes/validation/torque-validation-class.php');

class Torque_Filtered_Loop_Filters_Controller {

	public static function get_filter_acf_select_args() {
		return array(
      'field_id' => array(
        'validate_callback' => array( 'Torque_Validation', 'string' ),
      ),
    );
	}

	public static function get_filter_dropdown_date_args() {
		return array(
      'post_type' => array(
        'validate_callback' => array( 'Torque_Validation', 'string' ),
      ),
      'date_type' => array(
        'validate_callback' => array( 'Torque_Validation', 'string' ),
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

	public function get_filter_dropdown_date() {
		try {
			$post_type = $this->request['post_type'];
			$date_type = $this->request['date_type'];
			$query = new WP_Query( array(
				'post_type'	=> $post_type,
				'posts_per_page' => -1,
				'orderby'	=> 'date'
			));

			if ($query->have_posts()) {
				$dates_arr = [];

				foreach ($query->posts as $post) {
					if ( 'YYYY' === $date_type ) {
						$dates = date("Y", strtotime($post->post_date));
					} else {
						$dates = date("M Y", strtotime($post->post_date));
					}
					if (!in_array($dates, $dates_arr)) {
						$dates_arr[] = $dates;
					}
				}

        return Torque_API_Responses::Success_Response( array(
          'dates'	=> $dates_arr
        ) );
			}

			return Torque_API_Responses::Failure_Response( array(
				'dates'	=> []
			));

		} catch (Exception $e) {
			return Torque_API_Responses::Error_Response( $e );
		}
	}
}
