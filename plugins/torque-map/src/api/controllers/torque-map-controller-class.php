<?php

require_once( get_template_directory() . '/api/responses/torque-api-responses-class.php');
require_once( get_template_directory() . '/includes/validation/torque-validation-class.php');

class Torque_Map_Controller {

	public static $API_KEY_FILTER = 'torque_map_api_key';

	public static $DISPLAY_POIS_FILTER = 'torque_map_display_pois_list';

	public static $POIS_LOCATION = 'torque_map_pois_location';

	public static $MAP_DEFAULT_STYLES = 'torque_map_default_styles';

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
				$pois = $this->get_pois_shaped( $map );
        return Torque_API_Responses::Success_Response( array(
          'api_key'          => $this->get_api_key(),
          'map_details'	     => $this->get_map_shaped( $map ),
					'map_styles'			 => get_field( 'map_styles', $map->ID ),
          'pois'	           => $this->get_pois( $map ),
          'pois_location'    => $this->pois_location(),
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
		$key = apply_filters( self::$API_KEY_FILTER, '' );
		return $key;
	}

	public function maybe_display_poi_list() {
		/**
		 * Filters whether or not to display the pois list under the map
		 *
		 * @var bool
		 */
		$bool = apply_filters( self::$DISPLAY_POIS_FILTER, false );
		return $bool;
	}

	public function pois_location() {
		/**
		 * Filters the location for the POI buttons
		 *
		 * @var string top|bottom
		 */
		$location = apply_filters( self::$POIS_LOCATION, 'top' );
		return $location;
	}

	private function get_map_styles( $id ) {
		$context = array( 'context' => 'post', 'id' => $id );
		$map_styles = premise_get_value( 'map_styles', $context );

		if (!$map_styles) {
			$map_styles = apply_filters( self::$MAP_DEFAULT_STYLES, false );
		}

		if ( $map_styles ) {
			return preg_replace( "/\r|\n/", "", strip_tags($map_styles) );
		}
	}

	private function get_map_shaped( $map ) {

		return array(
			'center' => get_field( 'center', $map->ID ),
			'zoom' => get_field( 'zoom', $map->ID ),
			'marker' => get_field( 'marker', $map->ID )
		);
	}

	private function get_pois( $map ) {

		return array(
			'section_title' => get_field( 'section_title', $map->ID ),
			'pois' => get_field( 'pois', $map->ID ),
		);
	}

	private function get_pois_shaped( $map ) {
		$context = array( 'context' => 'post', 'id' => $map->ID );
		$number_of_pois = apply_filters( Torque_Map_CPT::$POIS_ALLOWED_FILTER, 0 );

		$return = array();

		// get the pois title
		if ($number_of_pois > 0) {
			$return['title'] = premise_get_value( 'pois_section_title', $context );
		}

		// get the pois
		$pois = $this->retrieve_shaped_pois( $number_of_pois, $context );

		$return['pois'] = $pois;

		return $return;
	}

	private function retrieve_shaped_pois( $number_of_pois, $context ) {

		$manual_pois = (bool) apply_filters( Torque_Map_CPT::$POIS_MANUAL_FILTER, false );
		$pois = array();

		for ($i=0; $i < $number_of_pois; $i++) {
			$_option_name = $manual_pois ? 'torque_map_manual_pois_' : 'torque_map_pois_';
			$_poi = premise_get_value( $_option_name.$i, $context );

			if ( empty( $_poi['name'] ) ) {
				continue;
			}

			if ( ! $manual_pois
				&& empty( $_poi['keyword'] ) ) {
				continue;
			}

			if ( $manual_pois
				&& empty( $_poi['location'] ) ) {
				continue;
			}

			$pois[$i] = $_poi;

			if ( isset( $pois[$i]['marker'] )
				&& isset( $pois[$i]['marker']['size'] ) ) {
				$trimmed_size = str_replace( ' ', '', trim( $pois[$i]['marker']['size'] ) );
				$width_height = explode( ',', $trimmed_size );
				if ( isset( $width_height[1] ) ) {
					$pois[$i]['marker']['width'] = (int) $width_height[0];
					$pois[$i]['marker']['height'] = (int) $width_height[1];
				}
			}
		}

		return $pois;
	}
}
