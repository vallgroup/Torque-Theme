<?php

require_once( Interra_Marketing_Automation_PATH . '/helpers/income-expenses-helpers.php' );

$financial_summary_class = new Interra_Marketing_Automation_Financial_Summary();

?>

<div class="ima-financial-summary ima-section">

	<div class="torque-listing-content">

    <div class="torque-listing-content-details ima-full-width">

			<div class="ima-columns">

				<h4>Financial Summmary</h4>

				<div class="ima-column-left-50">

					<div class="ima-horizontal-scroll">

						<?php output_investment_table( $financial_summary_class->get_investment_table_info() ); ?>

					</div>

					<br /><br />

					<div class="ima-horizontal-scroll">

						<?php output_operating_table( $financial_summary_class->get_operating_table_info() ); ?>

					</div>
				</div>

				<div class="ima-column-right-50">
					<div class="ima-horizontal-scroll">

						<?php output_financing_table( $financial_summary_class->get_financing_table_info() ); ?>

					</div>

					<!-- <br /><br /> -->
					<br /><br />
				</div>


				<div class="ima-column-right-50">
					<?php load_template( Interra_Marketing_Automation_PATH . 'templates/content/content-taxes.php' ); ?>
				</div>

			</div>


		</div>

	</div>

</div>
