<?php

$listing                  = get_field( 'listing' );
$pin                      = get_field( 'pin' );
$building_type            = get_field( 'building_type' );
$number_of_units          = get_field( 'number_of_units' );
$year_built               = get_field( 'year_built' );
$utilities_paid_by_tenant = get_field( 'utilities_paid_by_tenant' );

$__key_details = array(
  'PIN' => $pin,
  'Building Type' => $building_type,
  'Number Of Units' => $number_of_units,
  'Year Built' => $year_built,
  'Utilities Paid By Tenant' => $utilities_paid_by_tenant,
);

global $post;
$post = $listing;
setup_postdata( $post );

$content = get_the_content();
$highlights = get_field( 'listing_highlights' );

?>
<div class="ima-property-info ima-section">

  <div class="torque_listing-title" >
    <div class="featured-image-size" >
      <div class="featured-image" style="background-image: url('<?php echo get_the_post_thumbnail_url( null, 'large'); ?>')" ></div>
    </div>
  </div>
  <div class="torque-listing-content">

    <div class="torque-listing-content-details ima-full-width" >

      <h2>About The Property</h2>

      <div class="ima-columns">
        <div class="ima-column-left">
          <?php if ($content) { ?>
            <h4>Property Overview</h4>
            <div class="the-content" >
              <?php echo $content; ?>
            </div>
          <?php } ?>

          <?php if ($highlights) { ?>
            <h4>Highlights</h4>
            <div class="highlights" >
              <?php echo $highlights; ?>
            </div>
          <?php } ?>
        </div>

        <div class="ima-column-right">
          <h4>Key Details</h4>
          <div class="key-details-wrapper">
            <?php foreach ($__key_details as $key => $value) {
              if ( empty( $value ) ) continue; ?>
              <div class="key-detail" >
                <div class="key-detail-name">
                  <?php echo $key; ?>
                </div>
                <div class="key-detail-value">
                  <?php echo $value; ?>
                </div>
              </div>
            <?php } ?>

            <?php if( have_rows('key_details') ): ?>

              <?php while ( have_rows('key_details') ) : the_row();
                $sub_field_name = get_sub_field('name');
                $sub_field_value = get_sub_field('value');

                $geo_search_values = array( "LATITUDE", "LONGITUDE" );
                $price_search_values = array( "PRICE", "ASKING PRICE" );
                $size_search_values = array( "LOT SIZE", "BUILDING SIZE" );

                /* Skip over Latitude & Longitude ACF keys, as they are no currently required by the client */
                if ( in_array(strtoupper($sub_field_name), $geo_search_values) ) {
                  continue;
                }

                if ( in_array(strtoupper($sub_field_name), $price_search_values) ) {
                  // First, remove any unwanted characters entered by the user
                  $illegal_chars = array( ",", ".", "$", " " );
                  $sub_field_value = str_replace( $illegal_chars, "", $sub_field_value );
                  // Second, format the number as required
                  $sub_field_value = "$" . number_format( trim( $sub_field_value ) );
                }

                if ( in_array(strtoupper($sub_field_name), $size_search_values) ) {
                  // First, remove any unwanted characters entered by the user
                  $illegal_chars = array( ",", "SF", ".", "SQUARE FEET", " " );
                  $sub_field_value = str_replace( $illegal_chars, "", strtoupper($sub_field_value) );
                  // Second, format the number as required
                  $sub_field_value = number_format( trim( $sub_field_value ) ) . " SF";
                }?>
                <div class="key-detail" >
                  <div class="key-detail-name">
                    <?php echo $sub_field_name; ?>
                  </div>
                  <div class="key-detail-value">
                    <?php echo $sub_field_value; ?>
                  </div>
                </div>
              <?php endwhile ?>

            <?php endif; ?>
          </div>
        </div>
      </div>

    </div>

  </div>

</div>

<?php wp_reset_postdata(); ?>
