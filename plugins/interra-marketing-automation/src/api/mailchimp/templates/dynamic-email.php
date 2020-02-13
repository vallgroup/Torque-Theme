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

$header_logo_src_white = null !== get_theme_mod( $tab_settings['logo_white_setting'] )
  ? '<img src="' . get_theme_mod( $tab_settings['logo_white_setting'] ) . '" height="70px" width="auto" />'
  : null;
$header_logo_src_dark = null !== get_theme_mod( $tab_settings['logo_setting'] )
  ? '<img src="' . get_theme_mod( $tab_settings['logo_setting'] ) . '" height="70px" width="auto" />'
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
    ? '<img src="' . get_the_post_thumbnail_url( $post_id, 'large') . '" style="width: 100%; max-width: 600px;" />'
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
    ? '<img src="' . get_the_post_thumbnail_url( null, 'large') . '" style="width: 100%; max-width: 600px;" />'
    : null;
  $content                  = get_the_content();

  // highlights
  $highlights               = get_field( 'listing_highlights' );
  $highlights_count         = 0 < substr_count( $highlights, '<li>' )
    ? substr_count( $highlights, '<li>' )
    : false;  

  // determine the number of highlights per column, for the email templates
  $highlights_count_col1    = ceil( (int) $highlights_count / 2 );
  $highlights_count_col2    = floor( (int) $highlights_count / 2 );

  // split the list of highlights into separate arrays; one array for each column
  $highlights               = str_replace( array( '<ul>', '</ul>', '\r\n' ), '',  $highlights );
  $highlights_array         = explode( '</li>', trim( $highlights ) );

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

endif;


/**
 * Footer Data
 */

// logos
$footer_logo_src_white = null !== get_theme_mod( $tab_settings['logo_white_setting'] )
  ? '<img src="' . get_theme_mod( $tab_settings['logo_white_setting'] ) . '" height="85px" width="auto" />'
  : null;
$footer_logo_src_dark = null !== get_theme_mod( $tab_settings['logo_setting'] )
  ? '<img src="' . get_theme_mod( $tab_settings['logo_setting'] ) . '" height="85px" width="auto" />'
  : null;

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
  </head>
  <body>
    <!--*|IF:MC_PREVIEW_TEXT|*-->
    <!--[if !gte mso 9]><!----><span class="mcnPreviewText" style="display:none; font-size:0px; line-height:0px; max-height:0px; max-width:0px; opacity:0; overflow:hidden; visibility:hidden; mso-hide:all;">Interra Realty Offer Memorandum - <?php echo esc_html( $document->post_title ); ?></span><!--<![endif]-->
    <!--*|END:IF|*-->
    <center>
      <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="template-wrapper" style="font-size: 16px; font-family: Lato, 'Helvetica Neue', Helvetica, Arial, sans-serif; color: <?php echo $mediumGray; ?>; background-color: <?php echo $white; ?>;">
        <tbody>
          <tr>
            <td align="center" valign="top">

              <!-- START: MAIN CONTENT TABLE -->
              <table id="main-content-container" style="width: 600px; max-width: 600px; border: <?php echo 'style-2' === $tmpl_body ? '1px solid' . $mediumGreen : '0'; ?>;" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td>

                      <!-- START: HEADER TABLE -->
                      <table id="header-container" class="<?php echo $tmpl_header; ?>" align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                        <tbody>
                          <tr>
                            <td>
                              <!-- START: HEADER LOGO TABLE -->
                              <table id="header-logo-container" align="center" border="0" cellpadding="10px" cellspacing="0" height="100%" width="100%">
                                <tbody>
                                  <tr>
                                    <td style="<?php if ( 'style-1' === $tmpl_header ) {
                                      echo 'height: 70px; padding: 10px; background-color: ' . $mediumGray . '; text-align: center;';
                                    } elseif ( 'style-2' === $tmpl_header ) {
                                      echo 'height: 130px; padding: 30px 10px; background-color: ' . $white . '; text-align: center;';
                                    } else {
                                      echo '';
                                    } ?>">
                                    <?php if ( 'style-1' === $tmpl_header ) {
                                      echo $header_logo_src_white;
                                    } else {
                                      echo $header_logo_src_dark;
                                    } ?>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <!-- END: HEADER LOGO TABLE -->
                              <?php if ( 'style-1' === $tmpl_header || 'style-2' === $tmpl_header ) { ?>
                                <!-- START: HEADER TEXT TABLE -->
                                <table id="header-text-container" align="center" border="0" cellpadding="" cellspacing="0" height="100%" width="100%" style="padding: 9px 18px;">
                                  <tbody>
                                    <tr>
                                      <td style="padding: 18px; background-color: <?php echo $mediumGreen; ?>; text-align: center; text-transform: uppercase; color: <?php echo $white; ?>;">
                                        <h1 style="font-size: 33px; margin: 0 auto;">
                                          <span>PRICE REDUCTION</span>
                                        </h1>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                                <!-- END: HEADER TEXT TABLE -->
                              <?php } ?>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <!-- END: HEADER TABLE -->
                      
                      <!-- START: BODY TABLE -->
                      <table id="body-container" class="<?php echo $tmpl_body; ?>" align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                        <tbody>
                          <tr>
                            <td style="padding: 0 18px;">

                              <!-- START: FEATURED IMAGE TABLE -->
                              <table id="featured-image-container" align="center" border="0" cellpadding="10px" cellspacing="0" height="auto" width="100%">
                                <tbody>
                                  <tr>
                                    <td style="padding: 9px 0; background-color: <?php echo $white; ?>; text-align: center;">
                                      <?php echo $project_featured_image; ?>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <!-- END: FEATURED IMAGE TABLE -->

                              <!-- START: HIGHLIGHTS TABLE -->
                              <table id="highlights-container" align="center" border="0" cellpadding="10px" cellspacing="0" height="auto" width="100%">
                                <tbody>
                                  <tr>
                                    <td style="padding: 9px 0; text-align: left;">

                                      <?php if ( 'style-1' === $tmpl_body || 'style-2' === $tmpl_body ) { ?>
                                        <h3 style="font-size: 22px; color: <?php echo $mediumGreen; ?>; text-transform: uppercase; margin: 0 auto;">
                                          Property <span style="color: <?php echo $mediumGray; ?>;">Highlights</span>
                                        </h3>
                                      <?php } else { ?>
                                        <h3 style="font-size: 22px; color: <?php echo $darkGreen; ?>; margin: 0 auto;">
                                          <span>Property Highlights</span>
                                        </h3>
                                      <?php } ?>

                                      <!-- START: HIGHLIGHTS TABLE - COL 1 -->
                                      <table id="highlights-col1-container" style="width: 100%; max-width: 281px;" align="left" border="0" cellpadding="10px" cellspacing="0" height="auto" width="100%">
                                        <tbody>
                                          <tr>
                                            <td style="padding: 9px 0; text-align: left;">
                                              <?php if ( !empty( $highlights_array_col1 ) ) {
                                                echo '<ul>';
                                                foreach ( $highlights_array_col1 as $highlight ) { 
                                                  echo '<li style="line-height: 24px;">' . $highlight . '</li>';
                                                }
                                                echo '</ul>';
                                              } ?>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                      <!-- END: HIGHLIGHTS TABLE - COL 1 -->

                                      <!-- START: HIGHLIGHTS TABLE - COL 2 -->
                                      <table id="highlights-col2-container" style="width: 100%; max-width: 281px;" align="left" border="0" cellpadding="10px" cellspacing="0" height="auto" width="100%">
                                        <tbody>
                                          <tr>
                                            <td style="padding: 9px 0; text-align: left;">
                                              <?php if ( !empty( $highlights_array_col2 ) ) {
                                                echo '<ul>';
                                                foreach ( $highlights_array_col2 as $highlight ) { 
                                                  echo '<li>' . $highlight . '</li>';
                                                }
                                                echo '</ul>';
                                              } ?>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                      <!-- END: HIGHLIGHTS TABLE - COL 2 -->

                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <!-- END: HIGHLIGHTS TABLE -->
                              <p>--------- BODY ---------</p>
                              <p>project_name: <?php echo strip_tags( $project_name ); ?></p>
                              <p>__key_details: <?php var_dump( $__key_details ); ?></p>
                              <p>pictures: <?php // var_dump( $pictures ); ?></p>
                              <p>Property/Post ID: <?php echo get_the_ID(); ?></p>
                              <p>property_location: <?php echo strip_tags( $property_location, '<br><p>' ); ?></p>
                              <p>content: <?php echo $content; ?></p>
                              <p>highlights_array_col1: <?php var_dump( $highlights_array_col1 ); ?></p>
                              <p>highlights_array_col2: <?php var_dump( $highlights_array_col2 ); ?></p>
                              <p>featured_image: <?php echo $featured_image; ?></p>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <!-- END: BODY TABLE -->

                      <!-- START: FOOTER TABLE -->
                      <table id="footer-container" class="<?php echo $tmpl_footer; ?>" align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                        <tbody>
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
                        </tbody>
                      </table>
                      <!-- END: FOOTER TABLE -->

                    </td>
                  </tr>
                </tbody>
              </table>
              <!-- END: MAIN CONTENT TABLE -->
              
            </td>
          </tr>
        </tbody>
      </table>
    </center>
  </body>
</html>
