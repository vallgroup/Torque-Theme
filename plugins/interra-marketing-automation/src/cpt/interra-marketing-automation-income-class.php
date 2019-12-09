<?php

/**
 *
 */
class Interra_Marketing_Automation_Income {

	protected $income_table_content = array();

	protected $income_total = 0;

	protected $income_table_totals = array();

	protected $rent_roll = array();

	protected $rent_roll_total = array(
		'current' => 0,
		'market' => 0
	);

	protected $units_rented = 0;

	public function __construct() {
		$this->get_units();
		$this->get_rent_roll_total();
		$this->get_number_of_rented_units();
		$this->get_income_data();

		$this->curr_col_name = get_field( 'inc_curr_col_name' );
		$this->mkt_col_name = get_field( 'inc_mkt_col_name' );
	}

	public function get_table_info() {
		return array(
			'columns' => [
				'current' => $this->curr_col_name,
				'market' => $this->mkt_col_name,
			],
			'rows' => $this->income_table_content,
			'footer' => $this->income_table_totals,
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
	 private function get_income_data() {
 		// get income from db
 		$income_rows = get_field( 'income' );
		//
		$this->income_table_content['Rental Income'] = $this->rent_roll_total;
 		// format income
 		foreach ( (array) $income_rows as $income ) {
 			$key = strip_tags( $income['income_name'] );
 			$this->income_table_content[ $key ] = array(
 				'current' => floatval( $income['income_amount'] ),
 				'market' => floatval( $income['income_amount_mkt'] ),
 			);
 		}
 		//
 		$this->income_total = $this->add_income_total();
 		//
 		$this->income_table_totals = array(
 			'Gross Income' => $this->income_total,
 		);
 	}

	protected function add_income_total() {
		$total_income = ['current' => 0, 'market' => 0];
		$rental_income = ['current' => 0, 'market' => 0];
		$vacancy_percentage = ['current' => 0, 'market' => 0];
		$vacancy_dollars = ['current' => 0, 'market' => 0];
		foreach ( (array) $this->income_table_content as $key => $value) {
			if ( empty( $value ) ) continue;

			$label_to_compare = strtolower( $key );

			if ( 'rental income' === $label_to_compare ) {
				$rental_income['current'] = $value['current'];
				$rental_income['market'] = $value['market'];
			}

			if ( 'vacancy' === $label_to_compare ) {
				$vacancy_percentage['current'] = ($value['current'] / 100);
				$vacancy_percentage['market'] = ($value['market'] / 100);
				continue;
			}

			$total_income['current'] = ($total_income['current'] + $value['current'] );
			$total_income['market'] = ($total_income['market'] + $value['market'] );
		}

		$vacancy_dollars['current'] = ($rental_income['current'] * $vacancy_percentage['current']);
		$vacancy_dollars['market'] = ($rental_income['market'] * $vacancy_percentage['market']);

		$total_income['current'] = ($total_income['current'] - $vacancy_dollars['current']);
		$total_income['market'] = ($total_income['market'] - $vacancy_dollars['market']);

		return $total_income;
	}


}

?>
