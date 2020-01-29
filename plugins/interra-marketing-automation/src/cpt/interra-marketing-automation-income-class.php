<?php

/**
 *
 */
class Interra_Marketing_Automation_Income {

	public $curr_col_name = '';

	public $mkt_col_name = '';

	public $income_table_content = array();

	public $income_total = 0;

	public $income_table_totals = array();

	public $vacancy = array(
		'current' => 0,
		'market' => 0,
		'per_unit' => 0
	);

	public $rent_roll = array();

	public $rent_roll_total = array(
		'current' => 0,
		'market' => 0,
		'per_unit' => 0
	);

	public $units_rented = 0;

	protected $ratio_fields = [];

	public function __construct() {
		$this->ratio_fields = ['Vacancy'];

		$this->vacancy = get_field( 'vacancy' );

		$this->curr_col_name = get_field( 'inc_curr_col_name' );
		$this->mkt_col_name = get_field( 'inc_mkt_col_name' );

		$this->get_units();
		$this->get_rent_roll_total();
		$this->get_number_of_rented_units();
		$this->build_income_table_content();
	}

	public function get_table_info() {
		return array(
			'header' => [
				'current' => $this->curr_col_name,
				'market' => $this->mkt_col_name,
				'per_unit' => 'Per Unit',
			],
			'rows' => $this->format_columns( $this->income_table_content ),
			'footer' => $this->format_columns( $this->income_table_totals ),
			'data' => $this->get_data()
		);
	}

	public function get_data() {
		return array(
			'income_table_content' => $this->income_table_content,
			'income_total' => $this->income_total,
			'income_table_totals' => $this->income_table_totals,
			'rent_roll' => $this->rent_roll,
			'rent_roll_total' => $this->rent_roll_total,
			'units_rented' => $this->units_rented,
		);
	}


	/*
		PROTECTED METHODS
	*/

	protected function add_per_unit_column( $rows = array() ) {
		if ( empty( $rows ) ) return array();

		if ( 0 < $this->units_rented ) {
			foreach ( $rows as $name => $columns ) {
				if ( isset( $columns['current'] ) ) {
						$rows[ $name ]['per_unit'] = ((float) $columns['current'] / $this->units_rented);
					}
			}
		}

		return $rows;
	}

	protected function format_columns( $rows = array() ) {
		if ( empty( $rows ) ) return array();

		foreach ( $rows as $name => $columns ) {
			if ( ! is_array( $columns ) ) {
				continue;
			}
			foreach ( (array) $columns as $key => $col ) {
				if ( in_array( $name, $this->ratio_fields )
			 		|| in_array( $key, $this->ratio_fields )) {
					$rows[ $name ][ $key ] = get_in_percentage( $col / 100 );
				} else {
					$rows[ $name ][ $key ] = get_in_dollars( $col );
				}
			}
		}
		return $rows;
	}


	/*
		PRIVATE METHODS
	*/

	private function get_units() {
		$this->rent_roll = get_field( 'units' );
		return $this->rent_roll;
	}

	private function get_rent_roll_total() {
		foreach ( $this->rent_roll as $unit ) {
			if ( isset( $unit['rent'] )
				&& ! empty( $unit['rent'] ) ) {
				$this->rent_roll_total['current'] += floatval( $unit['rent'] );
			}

			if ( isset( $unit['market_rent'] )
				&& ! empty( $unit['market_rent'] ) ) {
				$this->rent_roll_total['market'] += floatval( $unit['market_rent'] );
			}
		}

		return $this->rent_roll_total;
	}

	private function get_number_of_rented_units() {
		$this->units_rented = 0;
		foreach ( $this->rent_roll as $unit ) {
			if ( isset( $unit['lease_expiration'] )
				&& ! empty( $unit['lease_expiration'] ) ) {
				// TODO: check if Exp date is older than today
				$this->units_rented++;
			}
		}

		return $this->units_rented;
	}

	/*
		Income Data
	 */
	 private function build_income_table_content() {
 		// get income from db
 		$income_rows = get_field( 'income' );
		//
		$this->income_table_content['Rental Income'] = $this->rent_roll_total;
		$this->income_table_content['Vacancy'] = $this->vacancy;
 		// format income
 		foreach ( (array) $income_rows as $income ) {
 			$key = strip_tags( trim( $income['income_name'] ) );
 			$this->income_table_content[ $key ] = array(
 				'current' => floatval( $income['income_amount'] ),
 				'market'  => floatval( $income['income_amount_mkt'] ),
				// 'per_unit'  => 0.00,
 			);
 		}
		// add per unti column
		$this->income_table_content = $this->add_per_unit_column( $this->income_table_content );
 		// set the income total
 		$this->income_total = $this->add_income_total();
 		// set the table footer
 		$this->income_table_totals = array(
 			'Gross Income' => $this->income_total,
 		);
		// add per unti column
		$this->income_table_totals = $this->add_per_unit_column( $this->income_table_totals );
 	}

	private function add_income_total() {
		$total_income       = ['current' => 0, 'market' => 0];
		$rental_income      = ['current' => 0, 'market' => 0];
		$vacancy_percentage = ['current' => 0, 'market' => 0];
		$vacancy_dollars    = ['current' => 0, 'market' => 0];
		foreach ( (array) $this->income_table_content as $key => $value) {
			if ( empty( $value ) ) continue;

			$label_to_compare = strtolower( $key );

			if ( 'rental income' === $label_to_compare ) {
				$rental_income['current'] = (float) $value['current'];
				$rental_income['market']  = (float) $value['market'];
			}

			if ( 'vacancy' === $label_to_compare ) {
				$vacancy_percentage['current'] = ((float) $value['current'] / 100);
				$vacancy_percentage['market']  = ((float) $value['market'] / 100);
				continue;
			}

			$total_income['current'] = ($total_income['current'] + (float) $value['current'] );
			$total_income['market']  = ($total_income['market'] + (float) $value['market'] );
		}

		$vacancy_dollars['current'] = ($rental_income['current'] * $vacancy_percentage['current']);
		$vacancy_dollars['market']  = ($rental_income['market'] * $vacancy_percentage['market']);

		$total_income['current'] = ($total_income['current'] - $vacancy_dollars['current']);
		$total_income['market']  = ($total_income['market'] - $vacancy_dollars['market']);

		// $total_income['per_unit'] = ($total_income['current'] / $this->units_rented);

		return $total_income;
	}


}

?>
