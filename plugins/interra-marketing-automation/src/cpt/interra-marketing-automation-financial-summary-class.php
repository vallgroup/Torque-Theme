<?php

/**
 *
 */
class Interra_Marketing_Automation_Financial_Summary Extends Interra_Marketing_Automation_Income_Expenses {

	protected $investment_table_content = array();

	protected $operating_table_content = array();

	protected $financing_table_content = array();

	protected $property_value = 0;

	protected $noi = 0;

	protected $down_payment = 0;

	protected $interest_rate = 0;

	protected $term = 0;

	protected $morgage_payment = 0;

	protected $ratio_fields = ['CAP Rate', 'Total Return (Yr. 1)', 'Debt Coverage Ratio'];

	public function __construct() {
		$this->property_value = floatval( get_field( 'property_value' ) );
		parent::__construct();

		// must run last
		$this->get_load_amo_data();
		$this->operating_data();
		$this->get_noi();
		$this->financing_data();
		$this->investment_data();

	}

	private function get_noi() {
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

	private function get_load_amo_data() {
		$this->down_payment = floatval( get_field( 'down_payment' ) );
		$this->interest_rate = (float) get_field( 'interest_rate' );
		$term_array = get_field( 'term' );
		$this->term = (int) $term_array['value'];
		$this->morgage_payment = $this->morgage_payment();
	}

	protected function investment_data() {
		$this->investment_table_content = array(
			'Price'                      => $this->property_value,
			'Price Per Unit'             => ( $this->property_value / count( $this->rent_roll ) ), // Price / Num Units
			'GRM'                        => ( $this->property_value / $this->rent_roll_total ), // Should use a ratio format
			'CAP Rate'                   => ( $this->noi / $this->property_value ), // NOI / Price
			'Cash-on-Cash Return (Yr. 1)' => ( $this->operating_table_content['Pre-Tax Cash Flow'] / $this->down_payment ),
			'Total Return (Yr. 1)'        => ( $this->income_total / $this->financing_table_content['Debt Service'] ),
			'Debt Coverage Ratio'        => ( $this->noi / ( $this->morgage_payment['principal_interest'] * 12 ) ), // Total NOI / Total Debt Service ??
		);
	}

	protected function operating_data() {
		$this->operating_table_content = array(
			'Gross Scheduled Income' => $this->rent_roll_total,
			'Additional Income'      => ( $this->income_total - $this->rent_roll_total ),
			'Total Scheduled Income' => $this->income_total,
			'Vacancy Cost (3%)'      => $this->income_table_content['Vacancy'],
			'Gross Income'           => $this->income_total, // Confirm same as total scheduled income?
			'Operating Expenses'     => $this->expenses_total,
			'Pre-Tax Cash Flow'      => ( $this->noi - ( $this->morgage_payment['principal_interest'] * 12 ) ),
		);
	}

	protected function financing_data() {
		$this->financing_table_content = array(
			'Down Payment'               => $this->down_payment,
			'Loan Amount'                => $this->property_value - ( $this->property_value * ( $this->down_payment / 100 ) ),
			'Debt Service'              => ( $this->morgage_payment['principal_interest'] * 12 ),
			'Debt Service Monthly'      => $this->morgage_payment['principal_interest'],
			'Principal Reduction (Yr. 1)' => ( $this->morgage_payment['principal'] * 12 ),
		);
	}

	public function output_investment_table() {
		?><table class="ima-investment-table ima-table">
			<thead>
				<tr class="ima-table-row">

					<th>Investment Summary</th>

					<th>Current</th>

					<th>Pro-Forma</th>

				</tr>
			</thead>

			<?php
				$this->output_table_rows( $this->investment_table_content );
			?>

		</table><?php
	}

	public function output_operating_table() {
		?><table class="ima-operating-table ima-table">
			<thead>
				<tr class="ima-table-row">

					<th>Operating Summary</th>

					<th>Current</th>

					<th>Pro-Forma</th>

				</tr>
			</thead>

			<?php
				$this->output_table_rows( $this->operating_table_content );
			?>

		</table><?php
	}

	public function output_financing_table() {
		?><table class="ima-financing-table ima-table">
			<thead>
				<tr class="ima-table-row">

					<th>Financing Summary</th>

					<th>Current</th>

					<th>Pro-Forma</th>

				</tr>
			</thead>

			<?php
				$this->output_table_rows( $this->financing_table_content );
			?>

		</table><?php
	}

	public function output_table_rows( $rows = array(), $expenses = false ) {

		?><tbody><?php
			foreach ( (array) $rows as $label => $value ) {
				if ( empty( $value ) )
					continue;
				?>
				<tr class="ima-table-row">
					<td class="align-left">
						<?php echo strip_tags( $label ); ?>
					</td>
					<td class="align-right">
						<?php if ( in_array( $label, $this->ratio_fields ) ) {
							output_in_percentage( $value );
						} else {
							output_in_dollars( $value );
						} ?>
					</td>
					<td class="align-right">
						<?php if ( in_array( $label, $this->ratio_fields ) ) {
							output_in_percentage( $value );
						} else {
							output_in_dollars( $value );
						} ?>
					</td>
				</tr>
				<?php
			}
		?></tbody><?php
	}

	protected function morgage_payment() {
		$principal = $this->property_value - ( $this->property_value * ( $this->down_payment / 100 ) );
		$rate        = (float) ($this->interest_rate * 0.01);
		$monthly_rate = $rate / 12;
		$periods     = ( $this->term * 12 );

    // console.log({ principal, rate, monthlyRate, periods })

		$factor      = pow( $monthly_rate + 1, $periods );
		$numerator   = $monthly_rate * $factor;
		$denominator = $factor - 1;
		$quotient    = $numerator / $denominator;
		$payment     = floatval($principal * $quotient);

		// build our pament object
		$principal_interest = round( $payment, 2 );
		$interest = round( ( $monthly_rate * $principal ), 2 );
		$principal = (float) number_format( ( $principal_interest - $interest ), 2 );
		return [
			'principal_interest' 	=> $principal_interest,
			'interest' 						=> $interest,
			'principal' 					=> $principal
		];
	}
}

?>
