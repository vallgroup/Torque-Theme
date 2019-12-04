<?php

/**
 * Structure array of arrays:
 * [[
 *   "address"          => string
 *   "type"             => string
 *   "total_rooms"      => string
 *   "sq"               => string
 *   "rent"             => string
 *   "lease_expiration" => string
 *   "tenant_notes"     => string
 * ]]
 *
 * @var [array]
 */
$units = get_field( 'units' );

// Holds the col keys for the columns that should be displayed
$col_keys = [];
// iterate through all units first, to find empty
// columns within rows
foreach ( (array) $units as $key => $column ) {
	// check within each column for empty values
	foreach ( (array) $column as $label => $value ) {
		// add column key if value exists
		// and key has not already been added
		if ( ! empty( $value )
		&& ! in_array( $label, $col_keys ) ) {
			$col_keys[] = $label;
		}
	}
}

?>

<div class="ima-rent-roll ima-section">

	<div class="torque-listing-content">

    <div class="torque-listing-content-details ima-full-width">

			<h4>Rent Roll</h4>

			<div class="ima-horizontal-scroll">

				<table class="ima-rent-roll-table ima-table">

					<tr class="ima-table-row">

						<th>Unit #</th>

						<?php foreach ($col_keys as $key) { ?>
							<th><?php echo ucwords( str_replace( '_', ' ', strip_tags( $key ) ) ); ?></th>
						<?php } ?>

					</tr>

					<?php foreach ( (array) $units as $key => $column ) { ?>

						<tr class="ima-table-row">

							<td class="align-center"><?php echo strip_tags( $key + 1 ); ?></td>

							<?php foreach ( (array) $column as $key => $unit ) {
								// bail, if all rows in this column are empty
								if ( ! in_array( $key, $col_keys ) )
								 	continue; ?>
								<td class="align-center"><?php
									if ( 'rent' === $key
								 		|| 'market_rent' === $key ) {
										// Added this additional if stmt for market_rent
										// If no market rent was present, it would appear
										// as $0.00 in the FE. That did not make sense. MV
										if ( '' !== $unit ) {
											// Format for monetary value
											output_in_dollars( strip_tags( $unit ) );
										} else {
											echo '';
										}
									} elseif ( $key === 'sq' ) {
										// Format for area value
										output_in_sq_ft( strip_tags( $unit ) );
									} else {
										// Simply output unit value
										echo strip_tags( $unit );
									}
									?></td>
							<?php } ?>

						</tr>

					<?php } ?>
				</table>

			</div>

		</div>

	</div>

</div>
