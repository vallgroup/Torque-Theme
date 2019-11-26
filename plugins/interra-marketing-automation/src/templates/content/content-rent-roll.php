<?php

/**
 * Structure array of arrays:
 * [[
    "address"          => string
    "type"             => string
    "total_rooms"      => string
    "sq"               => string
    "rent"             => string
    "lease_expiration" => string
    "tenant_notes"     => string
  ]]
 *
 * @var [array]
 */
$units = get_field( 'units' );

// Is this necessary? Can be extracted from the $units array key values?
$col_keys = array(
	"address",
	"type",
	"total_rooms",
	"sq_ft",
	"rent",
	"lease_expiration",
	"tenant_notes",
);

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

							<?php foreach ( (array) $column as $key => $unit ) { ?>
								<td class="align-center"><?php
									if ( $key === 'rent' ) {
										// Format for monetary value
										output_in_dollars( strip_tags( $unit ) );
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