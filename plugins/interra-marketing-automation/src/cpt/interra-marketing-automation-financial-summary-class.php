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

	public function __construct() {
		$this->property_value = floatval( get_field( 'property_value' ) );
		parent::__construct();

		// must run last
		$this->investment_data();
		$this->operating_data();
		$this->financing_data();
		$this->get_noi();
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

	protected function investment_data() {
		$this->investment_table_content = array(
			'Price'                      => $this->property_value,
			'Price per unit'             => ($this->property_value / count($this->rent_roll)), // Price / Num Units
			'GRM'                        => '0.00', // Price /. Gross Achievable Rent
			'CAP Rate'                   => ($this->noi / $this->property_value), // NOI / Price
			'Cash-on-Cash Return (yr 1)' => '0.00',
			'Total Return (yr 1)'        => '0.00',
			'Debt Coverage Ratio'        => '0.00', // Total NOI / Total Debt Service ??
		);
	}

	protected function operating_data() {
		$this->operating_table_content = array(
			'Gross Scheduled Income' => '0.00',
			'Additional Income'      => '0.00',
			'Total Scheduled Income' => '0.00',
			'Vacancy Cost (3%)'      => $this->income_table_content['Vacancy'],
			'Gross Income'           => '0.00',
			'Operating Expenses'     => '0.00',
			'Pre-Tax Cash Flow'      => '0.00',
		);
	}

	protected function financing_data() {
		$dp = floatval( get_field( 'down_payment' ) );
		$this->financing_table_content = array(
			'Down Payment'               => $dp,
			'Loan Amount'                => $this->property_value - ($this->property_value * ($dp / 100)),
			'Debt Service '              => '0.00',
			'Debt Service Monthly '      => '0.00',
			'Principal Reduction (yr 1)' => '0.00',
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

	public function output_table_rows( $rows = array() ) {

		?><tbody><?php
			foreach ( (array) $rows as $label => $value ) {
				if ( empty( $value ) )
					continue;
				?>
				<tr class="ima-table-row">
					<td class="align-center">
						<?php echo strip_tags( $label ); ?>
					</td>
					<td class="align-center">
						<?php $this->output_in_dollars( $value ); ?>
					</td>
					<td class="align-center">
						<?php $this->output_in_dollars( $value ); ?>
					</td>
				</tr>
				<?php
			}
		?></tbody><?php
	}

	/*public function output_in_dollars( $amount ) {
		echo '$', (number_format( floatval( $amount ), 2, '.', ',' ));
	}*/
}

?>