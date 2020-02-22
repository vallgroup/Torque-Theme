<?php

require_once( get_template_directory() . '/api/responses/torque-api-responses-class.php');
require_once( get_template_directory() . '/includes/validation/torque-validation-class.php');

class Torque_Rentcafe_Floorplans_Controller {

	public static function get_args() {
		return array(
      'request_type' => array(
        'validate_callback' => array( 'Torque_Validation', 'string' ),
      ),
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

	public function get_floorplans() {

		// check cache first, else fetch from RentCafe API
		if ( $cached_floorplans = get_field( 'floorplans_response', 'option' ) ) {
			return Torque_API_Responses::Success_Response( array(
				'floorplans'	=> $cached_floorplans
			) );
		} else {
			try {
				$floorplans = $this->fetch_from_rentcafe();
	
				if ( $floorplans ) {
					
					update_field( 'floorplans_response', $floorplans, 'option' );
	
					return Torque_API_Responses::Success_Response( array(
						'floorplans'	=> $floorplans
					) );
				}
	
				return Torque_API_Responses::Failure_Response( array(
					'floorplans'	=> []
				));
	
			} catch (Exception $e) {
				return Torque_API_Responses::Error_Response( $e );
			}
		}
	}
	

	private function fetch_from_rentcafe() {

		// early exit
		if ( 
			!$this->apiToken ||
			!isset( $this->params['request_type'] ) ||
			!isset( $this->params['property_code'] )
		) {
			return null;
		}

		// perform the cURL request
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->apiBaseUrl . "?apiToken=" . $this->apiToken . "&requestType=" . $this->params['request_type'] . "&propertyCode=" . $this->params['property_code'],
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
		));
		$response = curl_exec($curl);
		curl_close($curl);

		return $response;

	}

}
