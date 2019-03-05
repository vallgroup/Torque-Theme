<?php

class Torque_Floor_Plans_Entrata {

	public static $instance = NULL;

	public static function get_inst() {
		!self::$instance AND self::$instance = new self;

		return self::$instance;
	}

	public function __construct() {}


  public static $PROPERTY_ID_FILTER_SLUG = 'torque_floor_plans_entrata_property_id';

  public $PROPERTY_ID = false;

  public function init() {
    $this->PROPERTY_ID = apply_filters(self::$PROPERTY_ID_FILTER_SLUG, $this->PROPERTY_ID);
	}

  public function get_shortcode_markup() {
    return 'data-entrata-property-id="'.$this->PROPERTY_ID.'"';
  }

  public function get_unit_types() {
    $unit_types = $this->create_GET_request('propertyunits', '
		{
			"name": "getUnitTypes",
			"params": {
				"propertyId": "'.$this->PROPERTY_ID.'"
			}
		}
		');

		if (! $unit_types->unitTypes->unitType) {
			throw new Exception('Error getting unit types');
			return [];
		}

		return $unit_types->unitTypes->unitType;
  private function create_GET_request($endpoint, $method) {
    $resCurl = curl_init();

    $jsonRequest = '{
        "auth": {
            "type": "basic"
        },
        "requestId": "15",
        "method": '.$method.'
    }';

    curl_setopt( $resCurl, CURLOPT_HTTPHEADER,  array( 'Content-type: APPLICATION/JSON; CHARSET=UTF-8', 'Authorization: Basic dG9ycXVlX2FwaUBsaW5jb2xuYXB0czpUb3JxdWVhcGkxMTcyMDE5JA==' ) );
    curl_setopt( $resCurl, CURLOPT_POSTFIELDS, $jsonRequest );


    curl_setopt( $resCurl, CURLOPT_POST, true );
    curl_setopt( $resCurl, CURLOPT_URL, 'https://lincolnapts.entrata.com/api/v1/'.$endpoint );
    curl_setopt( $resCurl, CURLOPT_RETURNTRANSFER, 1);


    $response = curl_exec( $resCurl );
    curl_close( $resCurl );

    $data = json_decode($response);

		if (!($data->response->code === 200 && $data->response->result)) {
			throw new Exception('Error fetching data from entrata API');
			return [];
		}

		return $data->response->result;
  }
}

?>
