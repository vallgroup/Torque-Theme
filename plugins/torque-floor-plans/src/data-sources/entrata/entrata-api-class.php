<?php

class Entrata_API {

	public static $UNIT_TYPE_NAME_FILTER_HANDLE = 'floor_plans_entrata_unit_type_name';

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
			$name = apply_filters(self::$UNIT_TYPE_NAME_FILTER_HANDLE, $unit_type->name);
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
		$responses = $this->get_units($unit_type_ids);

		$units_arr = [];
		foreach ($responses as $response) {
			if (!is_object($response) || !$response->ILS_Units || !$response->ILS_Units->Unit) {
				continue;
			}

			$units = $response->ILS_Units->Unit;

			foreach ($units as &$unit) {
				$this->attach_floorplan_info($unit);
				$this->clean_unit($unit);
				$units_arr[] = $unit;
			}
		}

		$units_by_floorplan = $this->group_units_by_floorplan($units_arr);

		foreach ($units_by_floorplan as $floor_plan_key => &$values) {
			$values['units'] = $this->filter_units_by_availability($values['units'], $start_date);
		}

		return $units_by_floorplan;
	}

	private function get_units($unit_type_ids) {
		$requests = [];

		// send parallel requests, one per unit type id
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
						"availableUnitsOnly": "0",
						"skipPricing": "0",
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
		return $this->parallel_curl($requests);
	}

	private $floor_plan_cache; // set up a cache so we dont have to hit the db too mnay times for the same thing
	private function attach_floorplan_info(&$unit) {
		$name = $unit->{"@attributes"}->FloorPlanName;
		if (!$name) { return; }

		if (isset($this->floor_plan_cache[$name])) {
			$unit->floorplan = $this->floor_plan_cache[$name];
			return;
		}

		$floor_plans_query = new WP_Query( array(
			'post_type' 				=> Torque_Floor_Plan_CPT::$floor_plan_labels['post_type_name'],
			'meta_key'					=> 'entrata_name',
			'meta_value'				=> $name
		) );
		if ($floor_plans_query->found_posts === 0) { return; }

		$floor_plan_wp = $floor_plans_query->post;
		$images = get_post_meta($floor_plan_wp->ID, 'entrata_additional_images', true);
		$rsf = get_post_meta($floor_plan_wp->ID, 'floor_plan_rsf', true);

		$floor_plan = array(
			'post_title'				=> $floor_plan_wp->post_title,
			'thumbnail' 				=> get_the_post_thumbnail_url($floor_plan_wp->ID, 'large') ?? '',
			'key_plan_src'			=> $images['key_plan'] ?? '',
			'rsf'								=> $rsf
		);

		$this->floor_plan_cache[$name] = $floor_plan;
		$unit->floorplan = $floor_plan;
	}

	private function clean_unit(&$unit) {
		unset($unit->Rent->TermRent);
		unset($unit->Deposit);

		$unit->pretty_price = $unit->Rent->{"@attributes"}->MinRent &&
	    $unit->Rent->{"@attributes"}->MaxRent
	    ? $unit->Rent->{"@attributes"}->MinRent ===
	      $unit->Rent->{"@attributes"}->MaxRent
	      ? '$'.$unit->Rent->{"@attributes"}->MaxRent
	      : '$'.$unit->Rent->{"@attributes"}->MinRent.' - $'.$unit->Rent->{"@attributes"}->MaxRent
	    : "N/A";
	}

	private function group_units_by_floorplan($units) {
		$grouped_units = [];

		foreach ($units as &$unit) {
			if (!isset($unit->floorplan)) { continue; }

			$name = $unit->{"@attributes"}->FloorPlanName;

			if (!isset($grouped_units[$name])) {
				$grouped_units[$name] = $unit->floorplan;
			}
			unset($unit->floorplan);

			$grouped_units[$name]['units'][] = $unit;

			$min_price = $unit->Rent->{"@attributes"}->MinRent = intval(str_replace(',', '', $unit->Rent->{"@attributes"}->MinRent));
			$max_price = $unit->Rent->{"@attributes"}->MaxRent = intval(str_replace(',', '', $unit->Rent->{"@attributes"}->MaxRent));

			if ($min_price && ($min_price < $grouped_units[$name]['min_price'] || !$grouped_units[$name]['min_price'])) {
				$grouped_units[$name]['min_price'] = $min_price;
			}
			if ($max_price && ($max_price > $grouped_units[$name]['max_price'] || !$grouped_units[$name]['max_price'])) {
				$grouped_units[$name]['max_price'] = $max_price;
			}
		}

		return $grouped_units;
	}

	private function filter_units_by_availability($units, $start_date) {
		$result = array(
			'available' => [],
			'unavailable'	=> []
		);
		$start_date_date = date_create_from_format("d/m/Y", $start_date);

		if (!$units) {
			return $result;
		}

		foreach ($units as $unit) {
			try {
				// filter by date
				if ($start_date_date) {
					$compare_date = date_create_from_format("d/m/Y",$unit->{'@attributes'}->AvailableOn);
					$diff = date_diff($compare_date, $start_date_date);
					$is_available_by_date = ($diff->invert === 1 || $diff->days === 0);
				} else {
					$is_available_by_date = true;
				}

				$is_available = $is_available_by_date && $unit->{'@attributes'}->Availability === 'Available';

				if ($is_available) {
					$result['available'][] = $unit;
				} else {
					$result['unavailable'][] = $unit;
				}
			} catch (Exception $e) {
				// do nothing
			}
		}

		return $result;
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

	private function parallel_curl($curl_requests) {
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

			$cleaned_results[$i] = $data->response->result;
		}

		return $cleaned_results;
	}
}

?>
