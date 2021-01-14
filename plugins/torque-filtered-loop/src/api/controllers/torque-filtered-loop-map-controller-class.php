<?php

require_once( get_template_directory() . '/api/responses/torque-api-responses-class.php');
require_once( get_template_directory() . '/includes/validation/torque-validation-class.php');

class Torque_Filtered_Loop_Map_Controller {

	protected $request = null;

	function __construct( $request ) {
		$this->request = $request;
	}

	public function get_map_options() {
		try {
			$api_key = get_field( 'google_maps_api_key', 'options' );
			$marker_icon = get_field( 'marker_icon', 'options' );
			$map_zoom = get_field( 'map_zoom', 'options' );
			$map_center = get_field( 'map_center_latitude', 'options' ) && get_field( 'map_center_latitude', 'options' )
				? array(
					'lat' => get_field( 'map_center_latitude', 'options' ),
					'lng' => get_field( 'map_center_longitude', 'options' ),
				)
				: false;
			$map_styles = get_field( 'map_styles', 'options' );

			return Torque_API_Responses::Success_Response( array(
				'map_options'	=> array(
					'api_key' 		=> $api_key,
					'marker_icon' => $marker_icon,
					'map_zoom' 		=> $map_zoom,
					'map_center' 	=> $map_center,
					'map_styles' 	=> $map_styles,
				)
			) );
		} catch (Exception $e) {
			return Torque_API_Responses::Error_Response( $e );
		}
	}
}
