<?php

require_once( get_template_directory() . '/api/responses/torque-api-responses-class.php');
require_once( get_template_directory() . '/includes/validation/torque-validation-class.php');

class Torque_Map_Controller {

	public static function get_map_args() {
		return array(
      'id' => array(
        'validate_callback' => array( 'Torque_Validation', 'int' ),
      ),
    );
	}

	protected $request = null;

	function __construct( $request ) {

		$this->request = $request;
	}

	public function get_map() {
		$_id = isset( $this->request['id'] ) ? (int) $this->request['id'] : 0;

		try {
			$map = get_post( $_id );

			if ($map) {
        return Torque_API_Responses::Success_Response( array(
          'api_key'          => $this->get_api_key(),
          'map_details'	     => $this->get_map_shaped( $map ),
          'pois'	           => $this->get_pois_shaped( $map ),
          'display_poi_list' => $this->maybe_display_poi_list(),
        ) );
			}

			return Torque_API_Responses::Failure_Response( array(
				'example'	=> []
			));

		} catch (Exception $e) {
			return Torque_API_Responses::Error_Response( $e );
		}
	}

	public function get_api_key() {
		/**
		 * Filters the api key to use for google maps.
		 * Allows the theme to add an api key by simply
		 * registering the fiilter
		 *
		 * @var string
		 */
		$key = apply_filters( 'torque_map_api_key', '' );
		return $key;
	}

	public function maybe_display_poi_list() {
		/**
		 * Filters whether or not to display the pois list under the map
		 *
		 * @var bool
		 */
		$bool = apply_filters( 'torque_map_display_pois_list', false );
		return $bool;
	}

	private function get_map_shaped( $map ) {
		// get the map meta
		$context = array( 'context' => 'post', 'id' => $map->ID );
		$map_dets = premise_get_value( 'torque_map', $context );
		// if we have a size for our center marker
		// convert it into separate params: widht and height
		if ( isset( $map_dets['center_marker'] )
			&& isset( $map_dets['center_marker']['size'] ) ) {
			$trimmed_size = str_replace( ' ', '', trim( $map_dets['center_marker']['size'] ) );
			$width_height = explode( ',', $trimmed_size );
			$map_dets['center_marker']['width'] = (int) $width_height[0];
			$map_dets['center_marker']['height'] = (int) $width_height[1];
		}
		// build the map details
		$map_resp = array_merge( array(
			'id' => $map->ID,
			'title' => $map->post_title,
		), $map_dets );

		return $map_resp;
	}

	private function get_pois_shaped( $map ) {
		$context = array( 'context' => 'post', 'id' => $map->ID );
		$number_of_pois = apply_filters( 'torque_map_pois_allowed', 0 );

		$pois = array();
		for ($i=0; $i < $number_of_pois; $i++) {
			$pois[$i] = premise_get_value( 'torque_map_pois_'.$i, $context );
			if ( isset( $pois[$i]['marker'] )
				&& isset( $pois[$i]['marker']['size'] ) ) {
				$trimmed_size = str_replace( ' ', '', trim( $pois[$i]['marker']['size'] ) );
				$width_height = explode( ',', $trimmed_size );
				$pois[$i]['marker']['width'] = (int) $width_height[0];
				$pois[$i]['marker']['height'] = (int) $width_height[1];
			}
		}
		return $pois;
	}
}
