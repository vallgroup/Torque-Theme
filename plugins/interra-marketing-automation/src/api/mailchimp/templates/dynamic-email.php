<?php 

global $post_id, $email_templates, $document; 

/**
 * Email Template Vars
 */

if ( !empty( $email_templates ) ) :

  // template section selections
  $tmpl_header = isset( $email_templates['header'] ) && null !== $email_templates['header']
    ? $email_templates['header']
    : null;
  
  $tmpl_body = isset( $email_templates['body'] ) && null !== $email_templates['body']
    ? $email_templates['body']
    : null;
  
  $tmpl_footer = isset( $email_templates['footer'] ) && null !== $email_templates['footer']
    ? $email_templates['footer']
    : null;

  // colors
  $white = '#FFF';
  $mediumGreen = '#95ca53';
  $darkGreen = '#64A557';
  $mediumGray = '#696A6D';

endif;


/**
 * Header Data
 */


// logos
require_once( get_template_directory() . '/includes/customizer/customizer-tabs/tabs/torque-customizer-tab-site-identity-class.php' );
$tab_settings = Torque_Customizer_Tab_Site_Identity::get_settings();

$logo_src_white = null !== get_theme_mod( $tab_settings['logo_white_setting'] )
  ? '<img src="' . get_theme_mod( $tab_settings['logo_white_setting'] ) . '"/>'
  : null;
$logo_src_dark = null !== get_theme_mod( $tab_settings['logo_setting'] )
  ? '<img src="' . get_theme_mod( $tab_settings['logo_setting'] ) . '"/>'
  : null;


/**
 * Body Data
 */

if ( !empty( $document ) && null !== $post_id ) :

  // project details
  $project_name             = get_field( 'project_name', $post_id );
  $listing                  = get_field( 'listing', $post_id );

  // featured image
  $project_featured_image   = null !== get_the_post_thumbnail_url( $post_id, 'large')
    ? '<img src="' . get_the_post_thumbnail_url( $post_id, 'large') . '" />'
    : null;
  
  // key details
  // $pin                      = get_field( 'pin', $post_id );
  // $building_type            = get_field( 'building_type', $post_id );
  // $number_of_units          = get_field( 'number_of_units', $post_id );
  // $year_built               = get_field( 'year_built', $post_id );
  // $utilities_paid_by_tenant = get_field( 'utilities_paid_by_tenant', $post_id );
  
  $__key_details = array(
    // 'PIN' => $pin,
    // 'Building Type' => $building_type,
    // 'Number Of Units' => $number_of_units,
    // 'Year Built' => $year_built,
    // 'Utilities Paid By Tenant' => $utilities_paid_by_tenant,
  );
  
  // location TODO
  $property_location        = 'Shortened Location';

  // additional ket details
  $search_detail_names = array(
    'cap rate',
    'building size'
  );
  if ( have_rows( 'key_details', $post_id ) ) :
    while ( have_rows( 'key_details', $post_id ) ) : the_row();
      $sub_field_name   = get_sub_field('name');
      $sub_field_value  = get_sub_field('value');

      echo '<p>Key Detail: ' . $sub_field_name . ' -> ' . $sub_field_value . '</p>';

      // Get only the $search_detail_names key details
      if ( in_array( strtolower( $sub_field_name ), $search_detail_names ) ) {
        $__key_details[ $sub_field_name ] = $sub_field_value;
      }

    endwhile;
  endif;
  
  // icons for key details
  // TODO

  // gallery
  $pictures                 = get_field( 'pictures', $post_id );

  // property details
  global $post;
  $post = $listing;
  setup_postdata( $post );

  $featured_image           = null !== get_the_post_thumbnail_url( null, 'large')
    ? '<img src="' . get_the_post_thumbnail_url( null, 'large') . '" />'
    : null;
  $content                  = get_the_content();

  // highlights
  $highlights               = get_field( 'listing_highlights' );
  $highlights_count         = 0 < substr_count( $highlights, '<li>' )
    ? substr_count( $highlights, '<li>' )
    : false;  

  $highlights_count_col1    = ceil( (int) $highlights_count / 2 );
  $highlights_count_col2    = floor( (int) $highlights_count / 2 );

  $highlights               = str_replace( array( '<ul>', '</ul>', '\r\n' ), '',  $highlights );
  // $highlights_array         = explode( '\r\n', trim( $highlights ) );
  $highlights_array         = explode( '</li>', trim( $highlights ) );
  var_dump( $highlights_array );

  // highlights col 1 array
  for ( $i=0; $i < $highlights_count_col1; $i++ ) {
    if ( '' !== $highlights_array[$i] ) {
      $highlights_array_col1[] = str_replace( '<li>', '', $highlights_array[$i] );
    }
  }
  // highlights col 2 array
  for ( $i=$highlights_count_col1; $i < $highlights_count; $i++ ) { 
    if ( '' !== $highlights_array[$i] ) {
      $highlights_array_col2[] = str_replace( '<li>', '', $highlights_array[$i] );
    }
  }
  var_dump( $highlights_array_col1 );
  var_dump( $highlights_array_col2 );

endif;


/**
 * Footer Data
 */

// logo white/dark defined in header data

$address                    = get_field('address', 'options');
$phone                      = get_field('phone', 'options');
// NB: added email to options page....
$email                      = get_field('email', 'options');
$site_url                   = get_site_url();

// social channels
$social_channels = '';
if ( have_rows('social_media', 'options') ) :
  while ( have_rows('social_media', 'option') ) : the_row();
    $socialchannel = get_sub_field( 'social_channel', 'option' );
    $socialurl = get_sub_field( 'social_url', 'option' );

    $social_channels .= '<ul class="social-icons">';
    $social_channels .= '<li class="social-item">';
    $social_channels .= '<a class="social-link" rel="nofollow noopener noreferrer" href="' . $socialurl . '" target="_blank">';
    $social_channels .= '<i class="social-icon fa fa-' . $socialchannel . '" aria-hidden="true"></i>';
    $social_channels .= '<span class="sr-only hidden">' . ucfirst( $socialchannel ) . '</span>';
    $social_channels .= '</a></li>';
    $social_channels .= '</ul>';
  endwhile;
endif;

// TODO: 3x contacts in 2 of 3 templates (are these related to the broker's assigned to the property, or?)


/**
 * Email Template Configuration
 */

// loop each section template, and assign associated variables
// Eg: header; background-color, logo, height, 

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo esc_html( $document->post_title ); ?></title>

    <style>
      #main-content-container {
        width: 600px;
        max-width: 600px;
      }
    </style>
  </head>
  <body>
    <!--*|IF:MC_PREVIEW_TEXT|*-->
    <!--[if !gte mso 9]><!----><span class="mcnPreviewText" style="display:none; font-size:0px; line-height:0px; max-height:0px; max-width:0px; opacity:0; overflow:hidden; visibility:hidden; mso-hide:all;">Interra Realty Offer Memorandum - <?php echo esc_html( $document->post_title ); ?></span><!--<![endif]-->
    <!--*|END:IF|*-->
    <center>
      <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="template-wrapper">
        <tr>
          <td align="center" valign="top">

            <!-- START: MAIN CONTENT TABLE -->
            <table id="main-content-container" class="<?php echo $tmpl_body; ?>" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
              <tr>
                <td>

                  <!-- START: HEADER TABLE -->
                  <table id="header-container" class="<?php echo $tmpl_header; ?>" align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                    <tr>
                      <td>
                        <p>--------- HEADER ---------</p>
                        <p>logo_src_white: <?php echo $logo_src_white; ?></p>
                        <p>logo_src_dark: <?php echo $logo_src_dark; ?></p>
                      </td>
                    </tr>
                  </table>
                  <!-- END: HEADER TABLE -->
                  
                  <!-- START: BODY TABLE -->
                  <table id="body-container" class="<?php echo $tmpl_body; ?>" align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                    <tr>
                      <td>
                        <p>--------- BODY ---------</p>
                        <p>Project/Post ID: <?php echo $post_id; ?></p>
                        <p>project_name: <?php echo strip_tags( $project_name ); ?></p>
                        <p>project_featured_image: <?php echo $project_featured_image; ?></p>
                        <p>__key_details: <?php var_dump( $__key_details ); ?></p>
                        <p>pictures: <?php // var_dump( $pictures ); ?></p>
                        <p>Property/Post ID: <?php echo get_the_ID(); ?></p>
                        <p>property_location: <?php echo strip_tags( $property_location, '<br><p>' ); ?></p>
                        <p>content: <?php echo $content; ?></p>
                        <p>highlights: <?php echo $highlights; ?></p>
                        <p>highlights_count: <?php echo $highlights_count; ?></p>
                        <p>highlights_col1: <?php echo $highlights_count_col1; ?></p>
                        <p>highlights_col2: <?php echo $highlights_count_col2; ?></p>
                        <p>highlights_array_col1: <?php echo $highlights_array_col1; ?></p>
                        <p>highlights_array_col2: <?php echo $highlights_array_col2; ?></p>
                        <p>featured_image: <?php echo $featured_image; ?></p>
                      </td>
                    </tr>
                  </table>
                  <!-- END: BODY TABLE -->

                  <!-- START: FOOTER TABLE -->
                  <table id="footer-container" class="<?php echo $tmpl_footer; ?>" align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                    <tr>
                      <td>
                        <p>--------- FOOTER ---------</p>
                        <p>logo_src_white: <?php echo $logo_src_white; ?></p>
                        <p>logo_src_dark: <?php echo $logo_src_dark; ?></p>
                        <p>address: <?php echo strip_tags( $address, '<br><p>' ); ?></p>
                        <p>phone: <?php echo strip_tags( $phone ); ?></p>
                        <p>email: <?php echo strip_tags( $email ); ?></p>
                        <p>site_url: <?php echo $site_url; ?></p>
                        <p>social_channels: <?php var_dump( $social_channels ); ?></p>
                      </td>
                    </tr>
                  </table>
                  <!-- END: FOOTER TABLE -->

                </td>
              </tr>
            </table>
            <!-- END: MAIN CONTENT TABLE -->
            
          </td>
        </tr>
      </table>
    </center>
  </body>
</html>
