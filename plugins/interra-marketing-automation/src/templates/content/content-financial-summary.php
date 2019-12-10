<?php

require_once( Interra_Marketing_Automation_PATH . '/helpers/income-expenses-helpers.php' );

$financial_summary_class = new Interra_Marketing_Automation_Financial_Summary();

?>

<div class="ima-disclaimers ima-section">

	<div class="torque-listing-content">

    <div class="torque-listing-content-details">

			<h4>Financial Summmary</h4>

			<div class="ima-horizontal-scroll">

				<?php output_investment_table( $financial_summary_class->investment_table_content ); ?>

			</div>

			<br /><br />

			<div class="ima-horizontal-scroll">

				<?php output_operating_table( $financial_summary_class->operating_table_content ); ?>

			</div>

			<br /><br />

			<div class="ima-horizontal-scroll">

				<?php output_financing_table( $financial_summary_class->financing_table_content ); ?>

			</div>

	</div>

</div>
