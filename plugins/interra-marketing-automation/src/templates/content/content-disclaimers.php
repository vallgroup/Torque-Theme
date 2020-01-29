<?php

$disclaimers = get_field( 'disclaimers' );

$pdfs = [];

foreach ( (array) $disclaimers as $post ) {
	$pdfs[ $post->post_title ] = get_field( 'pdf', $post->ID );
}

?>

<div class="ima-disclaimers ima-section">

	<div class="torque-listing-content">

    <div class="torque-listing-content-details">

			<h4>Disclosures</h4>

			<div class="key-details-wrapper">

	      <?php foreach ( $pdfs as $name => $pdf  ) {  ?>

          <div class="key-detail <?php echo (1 < count( $pdfs ) ) ? '' : 'with-border'; ?>">
            <div class="key-detail-name">
              <?php echo esc_html( $name ); ?>
            </div>
            <div class="key-detail-value">
							Go to <a class="ima-link" href="<?php echo esc_url( $pdf 	); ?>" target="_blank" rel="noreferrer noopener">diclosure</a>
            </div>
          </div>

				<?php } ?>

			</div>

	</div>

</div>
