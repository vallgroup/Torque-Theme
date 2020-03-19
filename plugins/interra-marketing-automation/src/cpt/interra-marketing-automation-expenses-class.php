<?php

/**
 *
 */
class Interra_Marketing_Automation_Expenses Extends Interra_Marketing_Automation_Income {

	public $curr_col_name = '';

	public $mkt_col_name = '';

	protected $expense_table_content = array();

	protected $expenses_total = 0;

	protected $expense_table_totals = array();

	public function __construct() {
		parent::__construct();
		$this->perc_fields = ['per_gross_inc'];
		// get col names for table
		$this->curr_col_name = get_field( 'exp_curr_col_name' );
		$this->mkt_col_name = get_field( 'exp_mkt_col_name' );
		// get expenses
		$this->get_expenses_data();
	}

	public function get_table_info() {
		return array(
			'header' => [
				'current' => $this->curr_col_name,
				'market' => $this->mkt_col_name,
				'per_gross_inc' => '% Of Gross Income',
				'per_unit' => 'Per Unit',
			],
			'rows' => $this->format_columns( $this->expense_table_content ),
			'footer' => $this->format_columns( $this->expense_table_totals ),
			'data' => $this->get_data()
		);
	}

	public function get_data() {
		return array(
			'expense_table_content' => $this->expense_table_content,
			'expenses_total' => $this->expenses_total,
			'expense_table_totals' => $this->expense_table_totals,
			'income_total' => $this->income_total,
			'units_rented' => $this->units_rented,
		);
	}

	/*
		Expenses Data
	 */
	private function get_expenses_data() {
		// get expenses from db
		$expenses = get_field( 'expenses' );

		// format expenses
		foreach ( (array) $expenses as $expense ) {
			$key = strip_tags( $expense['expense_name'] );
			$this->expense_table_content[ $key ] = array(
				'current' => floatval( $expense['expense_amount'] ),
				'market' => floatval( $expense['expense_amount_mkt'] ),
				'per_gross_inc' => floatval( ($expense['expense_amount'] / $this->income_total['current']) * 100 ),
			);
		}
		//
		$this->expense_table_content = $this->add_per_unit_column( $this->expense_table_content );
		//
		$this->expenses_total = $this->add_expenses_total();
		//
		$this->expense_table_totals = array(
			'Gross Expenses' => $this->expenses_total,
		);
	}

	protected function add_expenses_total() {
		$total_expenses = array(
			'current' => 0,
			'market' => 0,
			'per_gross_inc' => 0,
			'per_unit' => 0,
		);
		foreach ((array) $this->expense_table_content as $key => $value) {
			// add current
			if ( isset( $value['current'] )
			 	&& ! empty( $value['current'] ) ) {
				$total_expenses['current'] += floatval( $value['current'] );
			}
			// add market
			if ( isset( $value['market'] )
			 	&& ! empty( $value['market'] ) ) {
				$total_expenses['market'] += floatval( $value['market'] );
			}
			// add % of GI
			if ( isset( $value['per_gross_inc'] )
			 	&& ! empty( $value['per_gross_inc'] ) ) {
				$total_expenses['per_gross_inc'] += floatval( $value['per_gross_inc'] );
			}
			// add per unit
			if ( isset( $value['per_unit'] )
			 	&& ! empty( $value['per_unit'] ) ) {
				$total_expenses['per_unit'] += floatval( $value['per_unit'] );
			}
		}
		return $total_expenses;
	}


}

?>
