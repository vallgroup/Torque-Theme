<?php
/**
 * Some helper functions for interacting with th US_States CPT
 */

require_once( Torque_US_States_PATH . 'cpt/torque-us-states-cpt-class.php');

class Torque_US_States_Functions {

	public static function get_assigned_state_codes($states = []): array {
		if ( ! sizeof($states) ) {
			$states = self::get_state_posts();
		}

		$state_codes = [];

		foreach ($states as $state) {
			$state_code = self::get_state_post_assigned_state_code($state->ID);

			if (! in_array($state_code, $state_codes) ) {
				$state_codes[] = $state_code;
			}	else {
				trigger_error( 'Two states found with same assigned state code - '.$state_code , E_USER_WARNING);
			}
		}

		return $state_codes;
	}

	public static function get_unassigned_states(): array {
		$assigned_codes = self::get_assigned_state_codes();

		if ( ! sizeof($assigned_codes) ) {
			return self::$states;
		}

		$unassigned_states = [];

		foreach (self::$states as $state_code => $state_name) {

			if ( ! in_array($state_code, $assigned_codes) ) {
				$unassigned_states[$state_code] = $state_name;
			}
		}

		return $unassigned_states;
	}

	public static function get_state_posts() {
		$query = new WP_Query( array(
			'post_type'					=> Torque_US_States_CPT::$us_states_labels['post_type_name'],
			'posts_per_page'		=> -1,
		));

		return $query->posts;
	}

	public static function get_state_post_assigned_state_code($state_post_id) {
		return get_post_meta( $state_post_id, 'state_code', true);
	}

	public static $states = array(
		'AL'   => 'Alabama',
		'AK'   => 'Alaska',
		'AZ'   => 'Arizona',
		'AR'   => 'Arkansas',
		'CA'   => 'California',
		'CO'   => 'Colorado',
		'CT'   => 'Connecticut',
		'DE'   => 'Delaware',
		'FL'   => 'Florida',
		'GA'   => 'Georgia',
		'HI'   => 'Hawaii',
		'ID'   => 'Idaho',
		'IL'   => 'Illinois',
		'IN'   => 'Indiana',
		'IA'   => 'Iowa',
		'KS'   => 'Kansas',
		'KY'   => 'Kentucky',
		'LA'   => 'Louisiana',
		'ME'   => 'Maine',
		'MD'   => 'Maryland',
		'MA'   => 'Massachusetts',
		'MI'   => 'Michigan',
		'MN'   => 'Minnesota',
		'MS'   => 'Mississippi',
		'MO'   => 'Missouri',
		'MT'   => 'Montana',
		'NE'   => 'Nebraska',
		'NV'   => 'Nevada',
		'NH'   => 'New Hampshire',
		'NJ'   => 'New Jersey',
		'NM'   => 'New Mexico',
		'NY'   => 'New York',
		'NC'   => 'North Carolina',
		'ND'   => 'North Dakota',
		'OH'   => 'Ohio',
		'OK'   => 'Oklahoma',
		'OR'   => 'Oregon',
		'PA'   => 'Pennsylvania',
		'RI'   => 'Rhode Island',
		'SC'   => 'South Carolina',
		'SD'   => 'South Dakota',
		'TN'   => 'Tennessee',
		'TX'   => 'Texas',
		'UT'   => 'Utah',
		'VT'   => 'Vermont',
		'VA'   => 'Virginia',
		'WA'   => 'Washington',
		'WV'   => 'West Virginia',
		'WI'   => 'Wisconsin',
		'WY'   => 'Wyoming'
	);
}

?>
