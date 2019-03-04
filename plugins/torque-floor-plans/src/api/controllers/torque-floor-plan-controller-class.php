<?php

require_once( get_template_directory() . '/api/responses/torque-api-responses-class.php');
require_once( get_template_directory() . '/includes/validation/torque-validation-class.php');

class Torque_Floor_Plan_Controller {

	public static function get_floor_plans_args() {
		return array();
	}

	protected $request = null;

	function __construct( $request ) {

		$this->request = $request;
	}

	public function get_floor_plans() {
		try {
			$floor_plans = get_posts( array(
				'post_type'				=> Torque_Floor_Plan_CPT::$floor_plan_labels['post_type_name'],
				'posts_per_page'	=> -1,
			) );

			if ($floor_plans) {
				//
				foreach ($floor_plans as &$floor_plan) {
					$floor_plan = $this->format_floor_plan_post( $floor_plan );
				}

        return Torque_API_Responses::Success_Response( array(
          'floor_plans'	=> $floor_plans
        ) );
			}

			return Torque_API_Responses::Failure_Response( array(
				'floor_plans'	=> []
			));

		} catch (Exception $e) {
			return Torque_API_Responses::Error_Response( $e );
		}
	}

	private function format_floor_plan_post( $floor_plan ) {
		$id = $floor_plan->ID;

		// add fields
		$floor_plan->thumbnail = 		get_the_post_thumbnail_url( $id, 'original');
		$floor_plan->rsf = 					get_post_meta( $id, 'floor_plan_rsf', true);
		$floor_plan->floor_number = get_post_meta( $id, 'floor_plan_floor_number', true);
		$floor_plan->downloads = 		get_post_meta( $id, 'floor_plan_downloads', true);

		return $floor_plan;
	}
}
