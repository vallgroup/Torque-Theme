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
	protected static $apiToken = null;
	protected static $apiBaseUrl = 'http://api.rentcafe.com/rentcafeapi.aspx';

	function __construct( $request ) {
		$this->request	= $request;
		$this->params		= $this->request->get_params();
		self::$apiToken = get_field( 'rentcafe_api_token', 'options' );
	}

	/**
	 * Retrieves the latest floorplans and availabilities from RentCafe
	 */
	public static function refresh_cache() {
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
						$floorplan_data = json_decode( self::fetch_from_rentcafe( 'floorPlan', $property_code ), true );
						$floorplans = $floorplan_data !== null
							? array_merge( $floorplans, $floorplan_data ) 
							: $floorplans;
						// get property code availabilities, convert to array, then merge
						$availabilities_data = json_decode( self::fetch_from_rentcafe( 'apartmentAvailability', $property_code ), true );
						$availabilities = $availabilities_data !== null
							? array_merge( $availabilities, $availabilities_data )
							: $availabilities;
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
	 * Fetches floorplans or availabilities
	 */
	public static function fetch_from_rentcafe( $request_type = null, $property_code = null ) {

		// set the api token
		// NB: required as we're also using this function in a wp-cron,
		//	which doesn't initialise the controller class hence 
		//	doesn't set the API token.
		if ( !self::$apiToken ) {
			$tmpApiToken = get_field( 'rentcafe_api_token', 'options' );
			self::$apiToken = $tmpApiToken;
		} 

		// early exit
		if (
			!self::$apiToken ||
			!self::$apiBaseUrl ||
			!$property_code || 
			!$request_type
		) {
			return null;
		}

		// perform the cURL request
		$curl = curl_init();
		curl_setopt_array( $curl, array(
			CURLOPT_URL => self::$apiBaseUrl . "?apiToken=" . self::$apiToken . "&requestType=" . $request_type . "&propertyCode=" . $property_code,
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
		
		// var_dump( '$response', $response );
		return $response;
	}

}
