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
					    	<?php echo ( 'tax_year' !== $name
					    		&& 'tax_rate' !== $name )
					    			? '$'.esc_attr( $value )
					    			: esc_attr( $value ) ?>
					    </div>
					  </div>

				  <?php endforeach; ?>

				</div>

		</div>
	</div>

</div>