<?php

global $post;

?>

<div class="ima-loan-amortization ima-section">

	<div class="torque-listing-content">
		<div class="torque-listing-content-details ima-full-width" >

				<h4>Loan Amortization Tool</h4>

				<p>
					<?php

					$sc_s  = '[Interra_Marketing_Automation';
					$sc_s .= ' module="loanAmortization"';
					$sc_s .= ' options="'. $post->ID .'"';
					$sc_s .= ' /]';

					echo do_shortcode( $sc_s ) ?>
				</p>

		</div>
	</div>

</div>