<?php

class Entrata_API {

	public static $instance = NULL;

	public static function get_inst() {
		!self::$instance AND self::$instance = new self;

		return self::$instance;
	}

	public function __construct() {}



  public $PROPERTY_ID = false;

  public function init( $property_id ) {
    $this->PROPERTY_ID = $property_id;
	}

  public function get_unit_types() {
    $response = $this->create_GET_request('propertyunits', '
		{
			"name": "getUnitTypes",
			"params": {
				"propertyId": "'.$this->PROPERTY_ID.'"
			}
		}
		');

		if (! $response->unitTypes->unitType) {
			throw new Exception('Error getting unit types');
			return [];
		}

		$unit_types = $response->unitTypes->unitType;

		$cleaned_unit_types = array();
		foreach ($unit_types as $unit_type) {
			// group unit types by name
			$name = $unit_type->name;
			$id = $unit_type->identificationType->idValue;

			if ( ! array_key_exists($name, $cleaned_unit_types) ) {
				$cleaned_unit_types[$name] = [$id];
			} else {
				$cleaned_unit_types[$name][] = $id;
			}
		}

		return $cleaned_unit_types;
  }

	public function get_floor_plans($unit_type_ids, $start_date) {

		$requests = [];

		foreach ($unit_type_ids as $unit_type_id) {
			$requests[] = $this->create_GET_request(
				'propertyunits',
				'
				{
					"name": "getUnitsAvailabilityAndPricing",
					"version": "r1",
					"params": {
						"propertyId": "'.$this->PROPERTY_ID.'",
						"unitTypeId": "'.$unit_type_id.'",
						"availableUnitsOnly": "1",
						"skipPricing": "1",
		        "showChildProperties": "0",
		        "includeDisabledFloorplans": "0",
		        "includeDisabledUnits": "0",
		        "showUnitSpaces": "0",
		        "useSpaceConfiguration": "0"
					}
				}
				',
				true
			);
		}

		$responses = $this->parralel_curl($requests);

		$floor_plan_ids = [];

		foreach ($responses as $response) {
			if (!is_object($response) || !$response->ILS_Units || !$response->ILS_Units->Unit) {
				continue;
			}

			$units = $response->ILS_Units->Unit;
			$start_date_date = date_create_from_format("d/m/Y",$start_date);


			if (!$units) {
				continue;
			}

			foreach ($units as $unit) {
				try {
					// filter by date
					$compare_date = date_create_from_format("d/m/Y",$unit->{'@attributes'}->AvailableOn);
					$diff = date_diff($compare_date, $start_date_date);
					$is_available = ($diff->invert === 0 || $diff->days === 0) && $unit->{'@attributes'}->Availability === 'Available';

					if ($is_available) {
						// seems like their server checks duplicates for us, so lets let them do it
						$floor_plan_ids[] = $unit->{'@attributes'}->FloorplanId;
					}
				} catch (Exception $e) {
					// do nothing
				}
			}
		}

		if (sizeOf($floor_plan_ids) > 0) {
			$floor_plans = [];

			$response = $this->create_GET_request('properties', '
			{
	        "name": "getFloorPlans",
	        "params": {
	            "propertyId": "673841",
							"propertyFloorPlanIds": "'.implode(',', $floor_plan_ids).'"
					}
	    }
			');

			return $response->FloorPlans->FloorPlan;
		} else {
			return [];
		}
	}

  private function create_GET_request($endpoint, $method, $prevent_exec = false) {
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

		if ($prevent_exec) {
			// return un-executed curl object so we can execute it elsewhere
			return $resCurl;
		} else {
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

	private function parralel_curl($curl_requests) {
		// array of curl handles
		$multiCurl = array();
		// data to be returned
		$results = array();
		// multi handle
		$mh = curl_multi_init();

		foreach ($curl_requests as $i => $curl_request) {
		  $multiCurl[$i] = $curl_request;
		  curl_multi_add_handle($mh, $multiCurl[$i]);
		}

		$index=null;
		do {
		  curl_multi_exec($mh,$index);
		} while($index > 0);
		// get content and remove handles
		foreach($multiCurl as $k => $ch) {
		  $results[$k] = curl_multi_getcontent($ch);
		  curl_multi_remove_handle($mh, $ch);
		}
		// close
		curl_multi_close($mh);

		$cleaned_results = [];

		foreach ($results as $i => $result) {
			$data = json_decode($result);

			if (!($data->response->code === 200 && $data->response->result)) {
				throw new Exception('Error fetching data from entrata API');
			}

			$cleaned_results[] = $data->response->result;
		}

		return $cleaned_results;
	}
}

?>
