<?php

/**
 * Structure array of arrays:
 * [[
		"address => string
		"price_sold => string
		"differences => string
		"photo => array(WP Attachment Post)
		"map => object(WP Map Post)
  ]]
 *
 * @var [array]
 */
$sales_comps = get_field( 'sales_comps' );

$col_keys = array(
	"address",
	"price_sold",
	"differences",
	"photo",
	"map",
);

/**
 * Structure array of arrays:
 * [[
		"address => string
		"rent => string
		"differences => string
		"photo => array(WP Attachment Post)
		"map => object(WP Map Post)
  ]]
 *
 * @var [array]
 */
$rent_comps = get_field( 'rent_comps' );

$rent_col_keys = array(
	"address",
	"rent",
	"differences",
	"photo",
	"map",
);

?>

<div class="ima-comps ima-section">

	<div class="torque-listing-content">

    <div class="torque-listing-content-details ima-full-width">

			<h4>Sales Comps</h4>

			<div class="ima-horizontal-scroll">

				<table class="ima-sales-comps-table ima-table">

					<tr class="ima-table-row">

						<!-- <th>Unit #</th> -->

						<?php foreach ($col_keys as $key) { ?>
							<th><?php echo ucwords( str_replace( '_', ' ', strip_tags( $key ) ) ); ?></th>
						<?php } ?>

					</tr>

					<?php foreach ( (array) $sales_comps as $key => $column ) { ?>

						<tr class="ima-table-row">

							<!-- <td class="align-center"><?php echo strip_tags( $key + 1 ); ?></td> -->

							<?php foreach ( (array) $column as $col_name => $col_value ) {
								$output_val = is_string( $col_value ) ? strip_tags( $col_value ) : '';

								if ( 'photo' === $col_name ) {
									$photo_url = esc_url( $col_value['sizes']['thumbnail'] );
									$output_val = '<img src="'.$photo_url.'" class="pwp-responsive" />';
								}

								if ( 'map' === $col_name ) {
									$output_val = do_shortcode( '[torque_map map_id="'.(int) $col_value->ID.'"]' );
								}

								if ( 'price_sold' === $col_name ) {
									setlocale( LC_MONETARY, 'en_US' );
									$output_val = money_format( '$%i', (float) $col_value );
								}
								?>

								<td class="align-center ima-col-<?php echo esc_attr( $col_name ); ?>"><?php echo $output_val; ?></td>

							<?php } ?>

						</tr>

					<?php } ?>
				</table>

			</div>
		</div>


		<div class="torque-listing-content-details ima-full-width">

			<h4>Rent Comps</h4>

			<div class="ima-horizontal-scroll">

				<table class="ima-rent-comps-table ima-table">

					<tr class="ima-table-row">

						<!-- <th>Unit #</th> -->

						<?php foreach ($rent_col_keys as $key) { ?>
							<th><?php echo ucwords( str_replace( '_', ' ', strip_tags( $key ) ) ); ?></th>
						<?php } ?>

					</tr>

					<?php foreach ( (array) $rent_comps as $key => $column ) { ?>

						<tr class="ima-table-row">

							<!-- <td class="align-center"><?php echo strip_tags( $key + 1 ); ?></td> -->

							<?php foreach ( (array) $column as $col_name => $col_value ) {
								$output_val = is_string( $col_value ) ? strip_tags( $col_value ) : '';

								if ( 'photo' === $col_name ) {
									$photo_url = esc_url( $col_value['sizes']['thumbnail'] );
									$output_val = '<img src="'.$photo_url.'" class="pwp-responsive" />';
								}

								if ( 'map' === $col_name ) {
									$output_val = do_shortcode( '[torque_map map_id="'.(int) $col_value->ID.'"]' );
								}

								if ( 'rent' === $col_name ) {
									setlocale( LC_MONETARY, 'en_US' );
									$output_val = money_format( '$%i', (float) $col_value );
								}
								?>

								<td class="align-center ima-col-<?php echo esc_attr( $col_name ); ?>"><?php echo $output_val; ?></td>

							<?php } ?>

						</tr>

					<?php } ?>
				</table>

			</div>

		</div>

	</div>

</div>