<?php

$maps     = get_field( 'maps' );

// [torque_map map_id="2955"]
?>

<div class="ima-maps ima-section">

	<div class="torque-listing-content">

    <div class="torque-listing-content-details ima-full-width">

			<h4>Maps</h4>

			<?php foreach ($maps as $map ) {
				$map_obj = $map['map'] ?>

				<h5><?php echo ucwords( esc_html( $map_obj->post_title ) ); ?></h5>

				<p>
					<?php echo do_shortcode( '[torque_map map_id="'.(int) $map_obj->ID.'"]' ); ?>
				</p>

			<?php } ?>

		</div>

	</div>

</div>