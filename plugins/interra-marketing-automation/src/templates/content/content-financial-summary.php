<?php

$financial_summary_class = new Interra_Marketing_Automation_Financial_Summary();

?>

<div class="ima-disclaimers ima-section">

	<div class="torque-listing-content">

    <div class="torque-listing-content-details">

			<h4>Financial Summmary</h4>

			<div class="ima-horizontal-scroll">

				<?php $financial_summary_class->output_investment_table(); ?>

			</div>

			<br /><br />

			<div class="ima-horizontal-scroll">

				<?php $financial_summary_class->output_operating_table(); ?>

			</div>

			<br /><br />

			<div class="ima-horizontal-scroll">

				<?php $financial_summary_class->output_financing_table(); ?>

			</div>

	</div>

</div>