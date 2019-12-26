<?php

$tax_year           = get_field( 'tax_year' );
$land_assessment    = get_field( 'land_assessment' );
$building_assesment = get_field( 'building_assesment' );
$tax_rate           = get_field( 'tax_rate' );

$taxes = [
	'tax_year'           => $tax_year,
	'land_assessment'    => $land_assessment,
	'building_assesment' => $building_assesment,
	'tax_rate'           => $tax_rate
];

?>

<div class="ima-taxes ima-section">

	<div class="torque-listing-content">
		<div class="torque-listing-content-details" >

				<h4>Taxes</h4>

				<div class="key-details-wrapper">

				  <?php foreach ( $taxes as $name => $value ) : ?>

				  	<div class="key-detail" >
					    <div class="key-detail-name">
					      <?php echo ucwords( str_replace( '_', ' ', esc_attr( $name ) ) ); ?>
					    </div>
					    <div class="key-detail-value">
					    	<?php
								if ( 'tax_year' === $name ) {
									echo esc_attr( $value );
								} else {
									echo ( 'tax_rate' !== $name )
					    			? output_in_dollars( esc_attr( $value ) )
					    			: output_in_percentage( (esc_attr( $value ) / 100) );
								}
								?>
					    </div>
					  </div>

				  <?php endforeach; ?>

				</div>

		</div>
	</div>

</div>
