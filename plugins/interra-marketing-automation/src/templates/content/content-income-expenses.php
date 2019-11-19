<?php

$income_expenses_class = new Interra_Marketing_Automation_Income_Expenses();

?>

<div class="ima-disclaimers ima-section">

	<div class="torque-listing-content">

    <div class="torque-listing-content-details">

			<h4>Income & Expenses</h4>

			<div class="ima-horizontal-scroll">

				<?php $income_expenses_class->output_income_table(); ?>

			</div>

			<br /><br />

			<div class="ima-horizontal-scroll">

				<?php $income_expenses_class->output_expenses_table(); ?>

			</div>

	</div>

</div>