<?php

/**
 *
 */
class Interra_Marketing_Automation_Financial_Summary Extends Interra_Marketing_Automation_Expenses {

	public $investment_table_content = array();

	public $operating_table_content = array();

	public $financing_table_content = array();

	public $noi = 0;

	public function __construct() {
		parent::__construct();
		$this->ratio_fields = ['CAP Rate', 'Total Return (Yr. 1)', 'Debt Coverage Ratio', 'Down Payment'];
		// build loan amo data
		$this->loan_amo = new Interra_Marketing_Automation_Loan_Amo();
		//
		// !!!must run in order!!!
		// 1
		$this->operating_data();
		// 2
		$this->get_noi();
		// 3
		$this->financing_data();
		// 4
		$this->investment_data();
	}

	public function get_operating_table_info() {
		return array(
			'header' => [
				'current' => 'Market',
				'market' => 'Pro-Forma',
			],
			'rows' => $this->format_columns( $this->operating_table_content ),
		);
	}

	public function get_investment_table_info() {
		return array(
			'header' => [
				'current' => 'Market',
				'market' => 'Pro-Forma',
			],
			'rows' => $this->format_columns( $this->investment_table_content ),
		);
	}

	public function get_financing_table_info() {
		return array(
			'header' => [
				'current' => 'Market',
				'market' => 'Pro-Forma',
			],
			'rows' => $this->format_columns( $this->financing_table_content ),
		);
	}

	protected function operating_data() {
		$this->operating_table_content = array(
			'Gross Scheduled Income' => $this->rent_roll_total['current'],
			'Additional Income'      => $this->income_total['current'] - $this->rent_roll_total['current'],
			'Total Scheduled Income' => $this->income_total['current'],
			'Vacancy Cost ('.$this->vacancy['current'].'%)' => (-($this->rent_roll_total['current'] * ($this->vacancy['current'] / 100))),
			'Gross Income'           => $this->income_total['current'],
			'Operating Expenses'     => $this->expenses_total['current'],
			'Pre-Tax Cash Flow'      => ( $this->noi - ( $this->loan_amo->morgage_payment['principal_interest'] * 12 ) ),
		);
	}

	protected function get_noi() {
		if ( 0 < $this->noi ) {
			return $this->noi;
		}

		$total = 0;
		foreach ( $this->operating_table_content as $key => $value ) {
			if ( empty( $value ) ) continue;
			$total = $total + floatval( $value );
		}

		$this->noi = $total;
		$this->operating_table_content['Net Operating Income'] = $this->noi;

		return $this->noi;
	}

	protected function financing_data() {
		$this->financing_table_content = array(
			'Down Payment'               => ($this->loan_amo->down_payment / 100),
			'Loan Amount'                => $this->loan_amo->property_value - ( $this->loan_amo->property_value * ( $this->loan_amo->down_payment / 100 ) ),
			'Debt Service'              => ( $this->loan_amo->morgage_payment['principal_interest'] * 12 ),
			'Debt Service Monthly'      => $this->loan_amo->morgage_payment['principal_interest'],
			'Principal Reduction (Yr. 1)' => ( $this->loan_amo->morgage_payment['principal'] * 12 ),
		);
	}

	protected function investment_data() {
		$this->investment_table_content = array(
			'Price'                      => $this->loan_amo->property_value,
			'Price Per Unit'             => ( $this->loan_amo->property_value / count( $this->rent_roll ) ),
			'GRM'                        => ( $this->loan_amo->property_value / $this->rent_roll_total['current'] ),
			'CAP Rate'                   => ( $this->noi / $this->loan_amo->property_value ),
			'Cash-on-Cash Return (Yr. 1)' => ( $this->operating_table_content['Pre-Tax Cash Flow'] / $this->loan_amo->down_payment ),
			'Total Return (Yr. 1)'        => ( $this->income_total['current'] / $this->financing_table_content['Debt Service'] ),
			'Debt Coverage Ratio'        => ( $this->noi / ( $this->loan_amo->morgage_payment['principal_interest'] * 12 ) ),
		);
	}
}

?>
