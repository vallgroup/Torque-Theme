<?php

/**
 *
 */
class Interra_Marketing_Automation_Income_Expenses {

	protected $income_table_content = array();

	protected $income_total = 0;

	protected $income_table_totals = array();

	protected $expense_table_content = array();

	protected $expenses_total = 0;

	protected $expense_table_totals = array();

	protected $rent_roll = array();

	protected $rent_roll_total = 0;

	protected $mkt_rent_roll_total = 0;

	protected $units_rented = 0;

	protected $mkt_expense_table_content = 0;
	protected $mkt_expenses_total = 0;
	protected $mkt_expense_table_totals = 0;

	public function __construct() {
		$this->get_data();
	}

	protected function get_data() {
		$this->get_units();
		$this->get_rent_roll_total();
		$this->get_number_of_rented_units();
		$this->get_income_data();
		$this->get_mkt_income_data();
		$this->get_expenses_data();
		$this->get_mkt_expenses_data();

	}

	/*
		Income Data
	 */
	private function get_income_data() {
		$parking_income = get_field('parking_income');
		$vacancy        = get_field('vacancy');
		$laundry        = get_field('laundry');
		$pet_fees       = get_field('pet_fees');
		$rent_total     = $this->get_rent_roll_total();

		$this->income_table_content = array(
			'Rental Income'  => $rent_total,
			'Vacancy'        => $vacancy,
			'Parking Income' => $parking_income,
			'Laundry Income' => $laundry,
			'Pet Fees'       => $pet_fees,
		);

		// Add extra income
		foreach ( (array) get_field( 'extra_income' ) as $income_pair ) {
			// $income_pair = ['income_name' => 'income_amount']
			$this->income_table_content[ $income_pair['income_name'] ] = $income_pair['income_amount'];
		}

		$this->income_total = $this->add_income_total();

		$this->income_table_totals = array(
			'Gross Income' => $this->income_total,
		);
	}

	private function get_mkt_income_data() {
		$mkt_parking_income = get_field('mkt_parking_income');
		$mkt_vacancy        = get_field('mkt_vacancy');
		$mkt_laundry        = get_field('mkt_laundry');
		$mkt_pet_fees       = get_field('mkt_pet_fees');
		// get from market
		$rent_total     = $this->get_mkt_rent_roll_total();

		$this->income_mkt_table_content = array(
			'Rental Income'  => $rent_total,
			'Vacancy'        => $mkt_vacancy,
			'Parking Income' => $mkt_parking_income,
			'Laundry Income' => $mkt_laundry,
			'Pet Fees'       => $mkt_pet_fees,
		);

		// Add extra income
		foreach ( (array) get_field( 'mkt_extra_income' ) as $income_pair ) {
			// $income_pair = ['income_name' => 'income_amount']
			$this->income_mkt_table_content[ $income_pair['income_name'] ] = $income_pair['income_amount'];
		}
		// get from market
		$this->income_mkt_total = $this->add_mkt_income_total();

		$this->income_mkt_table_totals = array(
			'Gross Income' => $this->income_mkt_total,
		);
	}

	/*
		Expenses Data
	 */
	private function get_expenses_data() {
		$taxes             = get_field('taxes');
		$insurance         = get_field('insurance');
		$gas               = get_field('gas');
		$electric          = get_field('electric');
		$water             = get_field('water');
		$trash             = get_field('trash');
		$elevator          = get_field('elevator');
		$extra_expenses    = get_field('extra_expenses');
		$management        = get_field('management');
		$janitorial        = get_field('janitorial');
		$turnover_costs    = get_field('turnover_costs');
		$misc_and_reserves = get_field('misc_and_reserves');

		$this->expense_table_content = array(
			'Taxes'             => $taxes,
			'Insurance'         => $insurance,
			'Gas'               => $gas,
			'Electric'          => $electric,
			'Water'             => $water,
			'Trash'             => $trash,
			'Elevator'          => $elevator,
			'Management'        => $management,
			'Janitorial'        => $janitorial,
			'Turnover Costs'    => $turnover_costs,
			'Misc And Reserves' => $misc_and_reserves,
		);

		foreach ( (array) $extra_expenses as $expense ) {
			$this->expense_table_content[ $expense['expense_name'] ] = $expense['expense_amount'];
		}

		$this->expenses_total = $this->add_expenses_total(  );

		$this->expense_table_totals = array(
			'Gross Expenses' => $this->expenses_total,
		);
	}

	private function get_mkt_expenses_data() {
		$mkt_taxes             = get_field('mkt_taxes');
		$mkt_insurance         = get_field('mkt_insurance');
		$mkt_gas               = get_field('mkt_gas');
		$mkt_electric          = get_field('mkt_electric');
		$mkt_water             = get_field('mkt_water');
		$mkt_trash             = get_field('mkt_trash');
		$mkt_elevator          = get_field('mkt_elevator');
		$mkt_extra_expenses    = get_field('mkt_extra_expenses');
		$mkt_management        = get_field('mkt_management');
		$mkt_janitorial        = get_field('mkt_janitorial');
		$mkt_turnover_costs    = get_field('mkt_turnover_costs');
		$mkt_misc_and_reserves = get_field('mkt_misc_and_reserves');

		$this->mkt_expense_table_content = array(
			'Taxes'             => $mkt_taxes,
			'Insurance'         => $mkt_insurance,
			'Gas'               => $mkt_gas,
			'Electric'          => $mkt_electric,
			'Water'             => $mkt_water,
			'Trash'             => $mkt_trash,
			'Elevator'          => $mkt_elevator,
			'Management'        => $mkt_management,
			'Janitorial'        => $mkt_janitorial,
			'Turnover Costs'    => $mkt_turnover_costs,
			'Misc And Reserves' => $mkt_misc_and_reserves,
		);

		foreach ( (array) $mkt_extra_expenses as $expense ) {
			$this->mkt_expense_table_content[ $expense['expense_name'] ] = $expense['expense_amount'];
		}

		$this->mkt_expenses_total = $this->add_expenses_total(  );

		$this->mkt_expense_table_totals = array(
			'Gross Expenses' => $this->mkt_expenses_total,
		);
	}

	private function get_units() {
		if ( empty( $this->rent_roll ) ) {
			$this->rent_roll = get_field( 'units' );
		}
		return $this->rent_roll;
	}

	private function get_rent_roll_total() {

		if ( 0 < $this->rent_roll_total ) {
			return $this->rent_roll_total;
		}

		foreach ( $this->rent_roll as $unit ) {
			if ( isset( $unit['rent'] )
				&& ! empty( $unit['rent'] ) ) {
				$rental_amount = floatval( $unit['rent'] );
				$this->rent_roll_total = $this->rent_roll_total + $rental_amount;
			}
		}

		return $this->rent_roll_total;
	}

	private function get_mkt_rent_roll_total() {

		if ( 0 < $this->mkt_rent_roll_total ) {
			return $this->mkt_rent_roll_total;
		}

		foreach ( $this->rent_roll as $unit ) {
			if ( isset( $unit['market_rent'] )
				&& ! empty( $unit['market_rent'] ) ) {
				$rental_amount = floatval( $unit['market_rent'] );
				$this->mkt_rent_roll_total = $this->mkt_rent_roll_total + $rental_amount;
			}
		}

		return $this->mkt_rent_roll_total;
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

	protected function add_expenses_total(  ) {
		$total_expenses = 0;
		foreach ((array) $this->expense_table_content as $key => $value) {
			if ( empty( $value ) ) continue;

			$total_expenses = ($total_expenses + floatval( $value ) );
		}
		return $total_expenses;
	}

	protected function add_mkt_expenses_total(  ) {
		$total_expenses = 0;
		foreach ((array) $this->mkt_expense_table_content as $key => $value) {
			if ( empty( $value ) ) continue;

			$total_expenses = ($total_expenses + floatval( $value ) );
		}
		return $total_expenses;
	}

	protected function add_income_total() {
		$total_income = 0;
		$rental_income = 0;
		$vacancy_percentage = 0;
		$vacancy_dollars = 0;
		foreach ( (array) $this->income_table_content as $key => $value) {
			if ( empty( $value ) ) continue;

			if ( 'Rental Income' === $key ) {
				$rental_income = floatval( $value );
			}

			if ( 'Vacancy' === $key ) {
				$vacancy_percentage = floatval( ($value / 100) );
				continue;
			}

			$total_income = ($total_income + floatval( $value ) );
		}

		$vacancy_dollars = ($rental_income * $vacancy_percentage);
		$total_income = ($total_income - $vacancy_dollars);

		return $total_income;
	}

	protected function add_mkt_income_total() {
		$total_income = 0;
		$rental_income = 0;
		$vacancy_percentage = 0;
		$vacancy_dollars = 0;
		foreach ( (array) $this->income_mkt_table_content as $key => $value) {
			if ( empty( $value ) ) continue;

			if ( 'Rental Income' === $key ) {
				$rental_income = floatval( $value );
			}

			if ( 'Vacancy' === $key ) {
				$vacancy_percentage = floatval( ($value / 100) );
				continue;
			}

			$total_income = ($total_income + floatval( $value ) );
		}

		$vacancy_dollars = ($rental_income * $vacancy_percentage);
		$total_income = ($total_income - $vacancy_dollars);

		return $total_income;
	}

	public function output_income_table() {
		?><table class="ima-income-table ima-table">
			<thead>
				<tr class="ima-table-row">

					<th>Income Summary</th>

					<th><?php echo strip_tags( get_field( 'inc_column_name' ) ) ?></th>

					<th><?php echo strip_tags( get_field( 'mkt_inc_column_name' ) ) ?></th>

					<th>Per Unit</th>

				</tr>
			</thead>

			<?php
				$this->output_income_table_rows();
				$this->output_table_footer( $this->income_table_totals );
			?>

		</table><?php
	}

	public function output_expenses_table() {
		?><table class="ima-income-table ima-table">
			<thead>
				<tr class="ima-table-row">

					<th>Expense Summary</th>

					<th><?php echo strip_tags( get_field( 'exp_column_name' ) ) ?></th>

					<th><?php echo strip_tags( get_field( 'mkt_exp_column_name' ) ) ?></th>

					<th>% of Gross Income</th>

					<th>Per Unit</th>

				</tr>
			</thead>

			<?php
				$this->output_expenses_table_rows();
				$this->output_table_footer( $this->expense_table_totals, true );
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
						<?php output_in_dollars( $value ); ?>
					</td>

					<?php if ( $expenses ) { ?>
						<td class="align-right">
							<?php output_in_percentage( $value / $this->income_total ); ?>
						</td>
					<?php } ?>

					<td class="align-right">
						<?php output_in_dollars( $value / $this->units_rented ); ?>
					</td>
				</tr>
				<?php
			}
		?></tbody><?php
	}

	public function output_income_table_rows() {

		?><tbody><?php
			foreach ( (array) $this->income_table_content as $label => $value ) {
				if ( empty( $value ) )
					continue;
				?>
				<tr class="ima-table-row">
					<td class="align-left">
						<?php echo strip_tags( $label ); ?>
					</td>

					<td class="align-right">
						<?php output_in_dollars( $value ); ?>
					</td>

					<td class="align-right">
						<?php if ( isset( $this->income_mkt_table_content[ $label ] )
							&& ! empty( $this->income_mkt_table_content[ $label ] ) ) { ?>
							<?php output_in_dollars( $this->income_mkt_table_content[ $label ] ); ?>
						<?php } ?>
					</td>

					<td class="align-right">
						<?php output_in_dollars( $value / $this->units_rented ); ?>
					</td>
				</tr>
				<?php
			}
		?></tbody><?php
	}

	public function output_expenses_table_rows(  ) {

		?><tbody><?php
			foreach ( (array) $this->expense_table_content as $label => $value ) {
				if ( empty( $value ) )
					continue;
				?>
				<tr class="ima-table-row">
					<td class="align-left">
						<?php echo strip_tags( $label ); ?>
					</td>
					<td class="align-right">
						<?php output_in_dollars( $value ); ?>
					</td>

					<td class="align-right">
						<?php if ( isset( $this->mkt_expense_table_content[ $label ] )
							&& ! empty( $this->mkt_expense_table_content[ $label ] ) ) { ?>
							<?php output_in_dollars( $this->mkt_expense_table_content[ $label ] ); ?>
						<?php } ?>
					</td>

					<td class="align-right">
						<?php output_in_percentage( $value / $this->income_total ); ?>
					</td>

					<td class="align-right">
						<?php output_in_dollars( $value / $this->units_rented ); ?>
					</td>
				</tr>
				<?php
			}
		?></tbody><?php
	}

	public function output_table_footer( $rows = array(), $expenses = false ) {

		?><tfoot><?php
			foreach ( (array) $rows as $label => $value ) {
				if ( empty( $value ) )
					continue;
				?>
				<tr class="ima-table-row">
					<th class="align-center">
						<?php echo strip_tags( $label ); ?>
					</th>
					<th class="align-center">
						<?php output_in_dollars( $value ); ?>
					</th>

					<?php if ( $expenses ) { ?>
						<th class="align-center">
							<?php output_in_percentage( $value / $this->income_total ); ?>
						</th>
					<?php } ?>

					<th class="align-center">
						<?php output_in_dollars( $value / $this->units_rented ); ?>
					</th>
				</tr>
				<?php
			}
		?></tfoot><?php
	}
}

?>
