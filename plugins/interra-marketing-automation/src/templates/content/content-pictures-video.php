<?php

$pictures     = get_field( 'pictures' );
$videos       = get_field( 'videos' );
$vr_pictures = get_field( '360_pictures' );
$boxapp_panos = premise_get_value( 'boxapp_panos', 'post' );

$ba_panos_arr = array_map( 'explode_panos', explode( ',', $boxapp_panos ) );

function explode_panos( $n ) {
	return explode( ':', $n );
}

if (
	empty( $pictures ) &&
	empty( $videos ) &&
	empty( $vr_pictures )
) {
	return;
}

?>

<div class="ima-pictures-video ima-section">

	<div class="torque-listing-content">

    <div class="torque-listing-content-details ima-full-width">

			<?php if ( $pictures ) : ?>
			<div class="ima-property-pictures">

				<h4>Gallery</h4>

				<div class="row ima-gallery">

					<?php foreach ($pictures as $picture ) { ?>

						<div class="gallery-col gallery-col-3">
							<div class="gallery-image" style="background-image: url(<?php echo $picture['url']; ?>);"></div>
						</div>

					<?php } ?>
				</div>

			</div>
			<?php endif; ?>

			<?php if ( $videos ) : ?>
			<div class="ima-property-videos">

				<h4>Videos</h4>

				<div class="ima-gallery pwp-scroller pwp-align-center ima-horizontal-scroll">
						<?php foreach ($videos as $video ) {

							$youtube_url = 'https://www.youtube.com/embed/';
							$video_url = $youtube_url . esc_attr( $video['video'] ); ?>

							<div class="video-wrapper">
								<iframe src="<?php echo( $video_url ) ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							</div>

						<?php } ?>
				</div>

			</div>
			<?php endif; ?>

			<?php if ( $boxapp_panos && '00:00' !== $boxapp_panos ) : ?>
			<div class="ima-360-photos">

				<h4>360 Photos</h4>

				<div class="row ima-gallery">

					<?php foreach ( (array) $ba_panos_arr as $pano ) {
						$vr_url = 'https://vr.boxapp.io/?org=interra&worldID=';
						// $pano is an array. Use index 1 to get the pano id
						// index 0 gives you the id of the pano image saved in wordpress
						$pano_id = $pano[1]; ?>
						<div class="gallery-col gallery-col-2">
							<div class="gallery-col">
								<iframe src="<?php echo esc_attr( $vr_url . $pano_id ) ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							</div>

							<div class="ima-clear-float"></div>

							<div class="ima-boxapp-link">
								<p>Enjoy this experience in <a class="ima-link" href="<?php echo esc_attr( $vr_url . $pano_id ) ?>" target="_blank" rel="noopener">Full Screen</a></p>
							</div>
						</div>
					<?php } ?>

				</div>

			</div>
			<?php endif; ?>

		</div>

	</div>

</div>
