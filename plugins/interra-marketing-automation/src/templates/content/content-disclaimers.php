<?php

$disclaimers = get_field( 'disclaimers' );

$disclosures = get_posts( [
	'post_type' => Interra_Marketing_Automation_CPT::$disclaimer_labels['post_type_name'],
] );

$pdfs = [];

foreach ( $disclosures as $post ) {
	if ( in_array( trim( strtolower( $post->post_title ) ), $disclaimers ) ) {
		$file = get_field('pdf', $post->ID );
		$pdfs[$post->post_title] = $file['url'];
	}
}

?>

<div class="ima-disclaimers ima-section">

	<div class="torque-listing-content">

    <div class="torque-listing-content-details">

			<h4>Disclosures</h4>

			<div class="key-details-wrapper">

	      <?php foreach ( $pdfs as $key => $pdf  ) {  ?>

          <div class="key-detail <?php echo (1 < count( $pdfs ) ) ? '' : 'with-border'; ?>">
            <div class="key-detail-name">
              <?php echo ucwords( esc_html( $key ) ); ?>
            </div>
            <div class="key-detail-value">
							Go to <a class="ima-link" href="<?php echo esc_url( $pdf 	); ?>">diclosure</a>
            </div>
          </div>

				<?php } ?>

			</div>

	</div>

</div>