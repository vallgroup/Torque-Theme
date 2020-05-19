<?php

/**
 *
 */
class Interra_Marketing_Automation_Financial_Summary Extends Interra_Marketing_Automation_Expenses {

	public $investment_table_content = array();

	public $operating_table_content = array();

	public $financing_table_content = array();

	public $noi = 0;

	public $current_column_name = '';

	public $financial_summary_columns = array();

	public $table_columns = array();

	protected $loan_amo = null;

	public function __construct() {
		parent::__construct();
		$this->ratio_fields = ['CAP Rate', 'Debt Coverage Ratio', 'GRM'];
		$this->perc_fields = ['Cash-on-Cash Return (Yr. 1)', 'Down Payment'];
		$this->current_column_name = get_field( 'current_column_name' );
		$this->financial_summary_columns = get_field( 'financial_summary_columns' );
		$this->table_columns = $this->build_table_header();
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
			'header' => $this->table_columns,
			'rows' => $this->format_columns( $this->operating_table_content ),
		);
	}

	public function get_investment_table_info() {
		return array(
			'header' => $this->table_columns,
			'rows' => $this->format_columns( $this->investment_table_content ),
		);
	}

	public function get_financing_table_info() {
		return array(
			'header' => $this->table_columns,
			'rows' => $this->format_columns( $this->financing_table_content ),
		);
	}

	protected function build_table_header() {
		$header = [
			'current' => $this->current_column_name,
		];
		// load more columns, if any
		if ( $this->financial_summary_columns ) {
			foreach ( (array) $this->financial_summary_columns as $column ) {
				$col_name = strip_tags( $column['column_name'] );
				$header[ $col_name ] = $col_name;
			}
		}
		return $header;
	}

	protected function operating_data() {
		$this->operating_table_content = array(
			'Gross Scheduled Income' => $this->get_formula( 'GSI' ),
			'Vacancy Cost ('.$this->vacancy['current'].'%)' => $this->get_formula( 'VC' ),
			'Total Scheduled Income' => $this->get_formula( 'TSI' ),
			'Additional Income'      => $this->get_formula( 'AI' ),
			'Gross Income'           => $this->get_formula( 'GI' ),
			'Operating Expenses'     => $this->get_formula( 'OE' ),
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
		$this->operating_table_content['Net Operating Income'] = $this->_get_noi();
		$this->operating_table_content['Pre-Tax Cash Flow']    = $this->get_formula( 'PTCF' );

		return $this->noi;
	}

	protected function financing_data() {
		$this->financing_table_content = array(
			'Down Payment'               => $this->get_formula( 'DP' ),
			'Loan Amount'                => $this->get_formula( 'LA' ),
			'Debt Service'              => $this->get_formula( 'DS' ),
			'Debt Service Monthly'      => $this->get_formula( 'DSM' ),
			'Principal Reduction (Yr. 1)' => $this->get_formula( 'PR' ),
		);
	}

	protected function investment_data() {
		$this->investment_table_content = array(
			'Price'                      => $this->get_formula( 'PV' ),
			'Price Per Unit'             => $this->get_formula( 'PPU' ),
			'GRM'                        => $this->get_formula( 'GRM' ),
			'CAP Rate'                   => $this->get_formula( 'CR' ),
			'Cash-on-Cash Return (Yr. 1)' => $this->get_formula( 'COCR' ),
			'Total Return (Yr. 1)'        => $this->get_formula( 'TR' ),
			'Debt Coverage Ratio'        => $this->get_formula( 'DCR' ),
		);
	}

	private function get_formula( $formula_name ) {
		switch ( $formula_name ) {
			case 'GSI':
				return $this->get_gsi();
			break;

			case 'TSI':
				return $this->get_tsi();
			break;

			case 'AI': // Additional Income
				return $this->get_additional_income();
			break;

			case 'GI':
				return $this->get_gi();
			break;

			case 'OE': // Operating Expenses
				return $this->get_operating_expenses();
			break;

			case 'VC': // Vacancy Cost
				return $this->get_vacancy_cost();
			break;

			case 'DP': // Down Payment
				return $this->get_down_payment();
			break;

			case 'PTCF': // Pre-Tax Cash Flow
				return $this->get_pre_tax_cash_flow();
			break;

			case 'LA': // Loan Amount
				return $this->get_loan_amount();
			break;

			case 'DS': // Debt Service
				return $this->get_debt_svc();
			break;

			case 'DSM': // Debt Service Monthly
				return $this->get_debt_svc_monthly();
			break;

			case 'PR': // Principal Reduction
				return $this->get_ppl_reduction();
			break;

			case 'PV': // Property Value
				return $this->get_property_value();
			break;

			case 'PPU': // Price Per Unit
				return $this->get_price_per_unit();
			break;

			case 'GRM': // Gross Rent Multiplier
				return $this->get_gross_rent_mltp();
			break;

			case 'CR': // CAP Rate
				return $this->get_cap_rate();
			break;

			case 'COCR': // Cash on Cash Return
				return $this->get_cash_on_cash_return();
			break;

			case 'TR': // Cash on Cash Return
				return $this->get_total_return();
			break;

			case 'DCR': // Debt Coverage Ratio
				return $this->get_debt_cvg_ratio();
			break;

			default:
				// code...
				break;
		}
	}

	private function get_gsi() {
		$gsi = [];
		foreach ( $this->table_columns as $key => $column ) {
			$gsi[ $key ] = ($this->rent_roll_total['current'] * 12);
		}

		return $gsi;
	}

	private function get_tsi() {
		$vc = (($this->rent_roll_total['current'] * 12) * ($this->vacancy['current'] / 100));
		$gsi = [];
		foreach ( $this->table_columns as $key => $column ) {
			$gsi[ $key ] = ($this->income_total['current'] + $vc);
		}

		return $gsi;
	}

	private function get_additional_income() {
		$vc = (($this->rent_roll_total['current'] * 12) * ($this->vacancy['current'] / 100));
		$ai = [];
		foreach ( $this->table_columns as $key => $column ) {
			$ai[ $key ] = ($this->income_total['current'] - ($this->rent_roll_total['current'] * 12) + $vc);
		}

		return $ai;
	}

	private function get_gi() {
		$vc = (($this->rent_roll_total['current'] * 12) * ($this->vacancy['current'] / 100));
		$gsi = [];
		foreach ( $this->table_columns as $key => $column ) {
			$gsi[ $key ] = $this->income_total['current'];
		}

		return $gsi;
	}

	private function get_operating_expenses() {
		$oe = [];
		foreach ( $this->table_columns as $key => $column ) {
			$oe[ $key ] = $this->expenses_total['current'];
		}

		return $oe;
	}

	private function get_vacancy_cost() {
		$vc = [];
		foreach ( $this->table_columns as $key => $column ) {
			$vc[ $key ] = ((($this->rent_roll_total['current'] * 12) * ($this->vacancy['current'] / 100)));
		}

		return $vc;
	}

	private function get_down_payment() {
		$dp = [];
		foreach ( $this->table_columns as $key => $column ) {
			$dp[ $key ] = ($this->loan_amo->down_payment);
		}

		return $dp;
	}

	private function get_pre_tax_cash_flow() {
		$vc = (($this->rent_roll_total['current'] * 12) * ($this->vacancy['current'] / 100));
		$ptcf = [];
		foreach ( $this->table_columns as $key => $column ) {
			$ptcf[ $key ] = (($this->income_total['current'] - $this->expenses_total['current']) - ( $this->loan_amo->morgage_payment['principal_interest'] * 12 ));
		}

		return $ptcf;
	}

	private function get_loan_amount() {
		$la = [];
		foreach ( $this->table_columns as $key => $column ) {
			if ( 'current' === $key ) {
				$la[ $key ] = $this->loan_amo->property_value - ( $this->loan_amo->property_value * ( $this->loan_amo->down_payment / 100 ) );
			} else {
				foreach ($this->financial_summary_columns as $key => $value) {
					$la[ $key ] = (
						$value['property_value']
						- ( $value['property_value']
						* ( $this->loan_amo->down_payment / 100 ) )
					);
				}
			}
		}

		return $la;
	}

	private function get_debt_svc_monthly() {
		$dsm = [];
		foreach ( $this->table_columns as $key => $column ) {
			$dsm[ $key ] = $this->loan_amo->morgage_payment['principal_interest'];
		}

		return $dsm;
	}

	private function get_debt_svc() {
		$ds = [];
		foreach ( $this->table_columns as $key => $column ) {
			$ds[ $key ] = $this->loan_amo->morgage_payment['principal_interest'] * 12;
		}

		return $ds;
	}

	private function get_ppl_reduction() {
		$pr = [];
		foreach ( $this->table_columns as $key => $column ) {
			$pr[ $key ] = ($this->loan_amo->morgage_payment['principal'] * 12);
		}

		return $pr;
	}


	private function get_property_value() {
		$pvl = [];
		foreach ( $this->table_columns as $key => $column ) {
			if ( 'current' === $key ) {
				$pvl[ $key ] = $this->loan_amo->property_value;
			} else {
				foreach ($this->financial_summary_columns as $key => $value) {
					$pvl[ $key ] = $value['property_value'];
				}
			}
		}
		return $pvl;
	}

	private function get_price_per_unit() {
		$ppu = [];
		foreach ( (array) $this->get_property_value() as $key => $column ) {
			if ( 'current' === $key ) {
				$ppu[ $key ] = ($this->loan_amo->property_value / count( $this->rent_roll ));
			} else {
				foreach ($this->financial_summary_columns as $key => $value) {
					$ppu[ $key ] = ($value['property_value'] / count( $this->rent_roll ));
				}
			}
		}
		return $ppu;
	}

	private function get_gross_rent_mltp() {
		$grm = [];
		foreach ( $this->table_columns as $key => $column ) {
			$__key = ('current' === $key) ? 'current' : 'market';
			$grm[ $key ] = ( $this->loan_amo->property_value / $this->income_total[$__key] );
		}
		return $grm;
	}

	private function get_cap_rate() {
		$ppu = [];
		foreach ( (array) $this->get_property_value() as $key => $column ) {
			if ( 'current' === $key ) {
				$ppu[ $key ] = ($this->_noi() / $this->loan_amo->property_value);
			} else {
				foreach ($this->financial_summary_columns as $key => $value) {
					$ppu[ $key ] = ($this->_noi() / $value['property_value']);
				}
			}
		}
		return $ppu;
	}

	private function get_cash_on_cash_return() {
		$cocr = [];
		foreach ( (array) $this->table_columns as $key => $column ) {
			$cocr[ $key ] = (
				(($this->income_total['current'] - $this->expenses_total['current']) - ( $this->loan_amo->morgage_payment['principal_interest'] * 12 ))
				/ ($this->loan_amo->property_value * ($this->loan_amo->down_payment / 100))
			) * 100;
		}
		return $cocr;
	}

	private function get_total_return() {
		$cocr = [];
		foreach ( (array) $this->table_columns as $key => $column ) {
			$cocr[ $key ] = (
				($this->income_total['current'] - $this->expenses_total['current'])
				- ((float) $this->loan_amo->morgage_payment['principal_interest'] * 12)
				+ ($this->loan_amo->morgage_payment['principal'] * 12)
			);
		}
		return $cocr;
	}

	private function get_debt_cvg_ratio() {
		$vc = (($this->rent_roll_total['current'] * 12) * ($this->vacancy['current'] / 100));
		$cocr = [];
		foreach ( (array) $this->table_columns as $key => $column ) {
			$cocr[ $key ] = ( ((($this->rent_roll_total['current'] * 12) - $vc) + ($this->income_total['current'] - ($this->rent_roll_total['current'] * 12)) - $this->expenses_total['current']) / ( $this->loan_amo->morgage_payment['principal_interest'] * 12 ) );
		}
		return $cocr;
	}

	private function _get_noi() {
		$vc = (($this->rent_roll_total['current'] * 12) * ($this->vacancy['current'] / 100));
		$grm = [];
		foreach ( $this->table_columns as $key => $column ) {
			$grm[ $key ] = $this->_noi();
		}
		return $grm;
	}

	private function _noi() {
		// $vc = (($this->rent_roll_total['current'] * 12) * ($this->vacancy['current'] / 100));
		return ($this->income_total['current'] - $this->expenses_total['current']);
	}
}

?>
