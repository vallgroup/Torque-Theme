<?php

$disclaimers     = get_field( 'disclaimers' );

?>

<div class="ima-disclaimers ima-section">

	<div class="torque-listing-content">

    <div class="torque-listing-content-details">

			<h4>Disclosures</h4>

			<div class="key-details-wrapper">

	      <?php foreach ( $disclaimers as $disclaimer  ) {

					$disclaimer_obj = $disclaimer['disclaimer']; ?>

          <div class="key-detail <?php echo (1 < count( $disclaimers ) ) ? '' : 'with-border'; ?>">
            <div class="key-detail-name">
              <?php echo ucwords( esc_html( $disclaimer_obj->post_title ) ); ?>
            </div>
            <div class="key-detail-value">
							Go to <a class="ima-link" href="<?php the_permalink( $disclaimer_obj ); ?>">diclosure</a>
            </div>
          </div>

				<?php } ?>

			</div>

	</div>

</div>