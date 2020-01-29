<?php

require_once( Interra_Marketing_Automation_PATH . '/helpers/income-expenses-helpers.php' );

$expenses_class = new Interra_Marketing_Automation_Expenses();

$income_class = new Interra_Marketing_Automation_Income();

?>

<div class="ima-income-expenses ima-section">

	<div class="torque-listing-content">

    <div class="torque-listing-content-details ima-full-width">

			<div class="ima-columns">

				<div class="ima-column-left-70">
					<h4>Income & Expenses</h4>

					<div class="ima-horizontal-scroll">

						<?php output_income_table( $income_class->get_table_info() ); ?>

					</div>

					<br /><br />

					<div class="ima-horizontal-scroll">

						<?php output_expenses_table( $expenses_class->get_table_info() ); ?>

					</div>
				</div>

				<div class="ima-column-right-30">
					<?php load_template( Interra_Marketing_Automation_PATH . 'templates/content/content-taxes.php' ); ?>
				</div>

			</div>

		</div>

	</div>

</div>
