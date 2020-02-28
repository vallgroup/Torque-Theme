<?php

require_once( get_template_directory() . '/api/responses/torque-api-responses-class.php');
require_once( get_template_directory() . '/includes/validation/torque-validation-class.php');

class Torque_Rentcafe_Floorplans_Controller {

	/**
	 * NOTE: currently not using params, and instead fetching ALL floorplans based on the ACF field 'Options' > 'RentCafe Options' > 'Property Codes'.
	 */
	public static function get_args() {
		return array(
      'property_code' => array(
        'validate_callback' => array( 'Torque_Validation', 'string' ),
      ),
    );
	}

	protected $request	= null;
	protected $params		= array();
	protected $apiToken = null;
	protected $apiBaseUrl = 'http://api.rentcafe.com/rentcafeapi.aspx';

	function __construct( $request ) {
		$this->request	= $request;
		$this->params		= $this->request->get_params();
		$this->apiToken = get_field( 'rentcafe_api_token', 'options' );
	}

	/**
	 * Retrieves the latest floorplans and availabilities from RentCafe
	 */
	public function refresh_cache() {
		// empty vars
		$floorplans = [];
		$availabilities = [];

		try {

			// fetch new data
			if ( have_rows( 'property_codes', 'options' ) ) :
				while ( have_rows( 'property_codes', 'options' ) ) : the_row();
					$property_code = get_sub_field('property_code');
					if ( $property_code ) {
						// get property code floorplans, convert to array, then merge
						$floorplan_data = json_decode( $this->fetch_floorplans_from_rentcafe( $property_code ), true );
						$floorplans = array_merge( $floorplans, $floorplan_data );
						// get property code availabilities, convert to array, then merge
						$availabilities_data = json_decode( $this->fetch_availabilities_from_rentcafe( $property_code ), true );
						$availabilities = array_merge( $availabilities, $availabilities_data );
					}
				endwhile;
			endif;
			
			// cache save new data
			update_field( 'floorplans_response', json_encode( $floorplans ), 'option' );
			update_field( 'availabilities_response', json_encode( $availabilities ), 'option' );
	
			return Torque_API_Responses::Success_Response( array(
				'message' => 'the floorplans cache has been first cleared, and then populated with the latest data.',
			) );

		} catch (Exception $e) {
			return Torque_API_Responses::Error_Response( $e );
		}
	}

	/**
	 * Retrieves the cached floorplans and availabilities from WP
	 */
	public function get_floorplans() {
		
		// check cache
		$cached_floorplans = get_field( 'floorplans_response', 'option' );
		$cached_availabilities = get_field( 'availabilities_response', 'option' );

		if ( $cached_floorplans && $cached_availabilities ) {
			return Torque_API_Responses::Success_Response( array(
				'floorplans'			=> json_decode( $cached_floorplans ),
				'availabilities'	=> json_decode( $cached_availabilities ),
			) );
		} else {
			return Torque_API_Responses::Failure_Response( array(
				'floorplans'			=> [],
				'availabilities'	=> [],
			));
		}
	}

	/**
	 * Fetches floorplans 
	 */
	private function fetch_floorplans_from_rentcafe( $property_code = null ) {
		// early exit
		if ( 
			!$this->apiToken ||
			!$this->apiBaseUrl ||
			( !isset( $this->params['property_code'] ) && !$property_code )
		) {
			return null;
		}

		$property_code = isset( $this->params['property_code'] )
			? $this->params['property_code']
			: $property_code;

		// perform the cURL request
		$curl = curl_init();
		curl_setopt_array( $curl, array(
			CURLOPT_URL => $this->apiBaseUrl . "?apiToken=" . $this->apiToken . "&requestType=floorPlan&propertyCode=" . $property_code,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
		) );
		$response = curl_exec( $curl );
		curl_close( $curl );
		
		// var_dump( $response );
		return $response;
	}

	private function fetch_availabilities_from_rentcafe( $property_code = null ) {

		// early exit
		if ( 
			!$this->apiToken ||
			!$this->apiBaseUrl ||
			( !isset( $this->params['property_code'] ) && !$property_code )
		) {
			return null;
		}

		$property_code = isset( $this->params['property_code'] )
			? $this->params['property_code']
			: $property_code;

		// perform the cURL request
		$curl = curl_init();
		curl_setopt_array( $curl, array(
			CURLOPT_URL => $this->apiBaseUrl . "?apiToken=" . $this->apiToken . "&requestType=apartmentAvailability&propertyCode=" . $property_code,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
		) );
		$response = curl_exec( $curl );
		curl_close( $curl );
		
		return $response;
	}

}
