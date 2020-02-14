<?php 

require( Interra_Marketing_Automation_PATH . '/api/mailchimp/templates/dynamic-email-table-class.php' );
require( Interra_Marketing_Automation_PATH . '/api/mailchimp/templates/dynamic-email-header-class.php' );
require( Interra_Marketing_Automation_PATH . '/api/mailchimp/templates/dynamic-email-body-class.php' );
// require( Interra_Marketing_Automation_PATH . '/api/mailchimp/templates/dynamic-email-footer-class.php' );

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

  $header = Dynamic_Email_Header_Class::get_inst( $tmpl_header );
  $body = Dynamic_Email_Body_Class::get_inst( $tmpl_header, $post_id );
  // $footer = Dynamic_Email_Footer_Class::get_inst( $tmpl_header );

endif;


// colors
$white = '#FFF';
$black = '#000';
$mediumGreen = '#95ca53';
$darkGreen = '#64A557';
$mediumGray = '#696A6D';

/**
 * Body Data
 */

if ( !empty( $document ) && null !== $post_id ) :

  /**
   * Project details
   */

  $project_name             = get_field( 'project_name', $post_id );
  $listing                  = get_field( 'listing', $post_id );

  // featured image
  $project_featured_image   = null !== get_the_post_thumbnail_url( $post_id, 'large')
    ? '<img src="' . get_the_post_thumbnail_url( $post_id, 'large') . '" style="width: 100%; max-width: 600px;" />'
    : null;
  $pictures                 = get_field( 'pictures', $post_id );
  $cta_url                  = get_post_permalink( $post_id );


  /**
   * Property details
   */

  global $post;
  $post = $listing;
  setup_postdata( $post );
  
  $property_address         = null;
  $listing_address          = get_field( 'listing_address' );
  $listing_city             = get_field( 'listing_city' );
  if ( $listing_address && $listing_city ) {
    $property_address       = $listing_address . ', ' . $listing_city;
  }
  
  $content                  = get_the_content();
  $highlights               = get_field( 'listing_highlights' );

endif;


/**
 * Footer Data
 */

// logos
require_once( get_template_directory() . '/includes/customizer/customizer-tabs/tabs/torque-customizer-tab-site-identity-class.php' );
$tab_settings = Torque_Customizer_Tab_Site_Identity::get_settings();

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

                      <?php $header->build_header(); ?>
                      
                      <!-- START: BODY TABLE -->
                      <table id="body-container" align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                        <tbody>
                          <tr>
                            <td style="padding: 0 18px;">

                              <?php if ( 'style-2' === $tmpl_body && $property_address ) { ?>
                              <!-- START: ADDRESS TEXT TABLE -->
                              <table id="body-address-container" style="padding: 9px 0 0 0;" align="center" border="0" cellpadding="0" cellspacing="0" height="auto" width="100%">
                                <tbody>
                                  <tr>
                                    <td style="padding: 9px 18px; background-color: <?php echo $mediumGreen; ?>; text-align: center; text-transform: uppercase; color: <?php echo $white; ?>;">
                                      <p style="font-size: 14px; margin: 0 auto;">
                                        <span><?php echo $property_address; ?></span>
                                      </p>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <!-- END: ADDRESS TEXT TABLE -->
                              <?php } ?>

                              <?php if ( $project_featured_image ) { ?>
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
                              <?php } ?>

                              <?php if ( 'style-3' === $tmpl_body && $property_address ) { ?>
                              <!-- START: ADDRESS TEXT TABLE -->
                              <table id="body-address-container" align="center" border="0" cellpadding="" cellspacing="0" height="auto" width="100%" style="padding: 9px 18px;">
                                <tbody>
                                  <tr>
                                    <td style="padding: 9px 18px; background-color: <?php echo $darkGreen; ?>; text-align: center; color: <?php echo $white; ?>;">
                                      <p style="font-size: 14px; margin: 0 auto;">
                                        <span><?php echo $property_address; ?></span>
                                      </p>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <!-- END: ADDRESS TEXT TABLE -->
                              <?php } ?>

                              <?php if ( 'style-3' === $tmpl_body && null !== $content ) { ?>
                              <!-- START: CONTENT TABLE -->
                              <table id="content-container" align="center" border="0" cellpadding="" cellspacing="0" height="auto" width="100%" style="padding: 9px 18px;">
                                <tbody>
                                  <tr>
                                    <td style="padding: 9px 18px; text-align: center; color: <?php echo $white; ?>;">
                                      <?php echo $content; ?>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <!-- END: ADDRESS TEXT TABLE -->
                              <?php } ?>

                              <?php if ( $highlights ) { ?>
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
                                      <?php }
                                      
                                      echo $highlights; ?>

                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <!-- END: HIGHLIGHTS TABLE -->
                              <? } ?>

                              <?php if ( 'style-1' === $tmpl_body || 'style-2' === $tmpl_body ) { ?>
                              <!-- START: GALLERY TABLE -->
                              <table id="gallery-container" align="center" border="0" cellpadding="0" cellspacing="0" height="auto" width="100%">
                                <tbody>
                                  <tr>
                                    <td style="padding: 9px 0; text-align: left;">

                                      <!-- START: GALLERY TABLE - COL 1 -->
                                      <table id="gallery-col1-container" style="width: 100%; max-width: 281px;" align="left" border="0" cellpadding="0" cellspacing="0" height="auto" width="100%">
                                        <tbody>
                                          <tr>
                                            <td style="padding: 0 9px 9px 0; text-align: left;">
                                              <?php if ( isset( $pictures[0] ) ) {
                                                echo '<img src="' . $pictures[0]['sizes']['medium'] . '" width="100%" height="auto" />';
                                              } ?>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                      <!-- END: GALLERY TABLE - COL 1 -->

                                      <!-- START: GALLERY TABLE - COL 2 -->
                                      <table id="gallery-col2-container" style="width: 100%; max-width: 281px;" align="left" border="0" cellpadding="0" cellspacing="0" height="auto" width="100%">
                                        <tbody>
                                          <tr>
                                            <td style="padding: 0 0 9px 9px; text-align: left;">
                                              <?php if ( isset( $pictures[1] ) ) {
                                                echo '<img src="' . $pictures[1]['sizes']['medium'] . '" width="100%" height="auto" />';
                                              } ?>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                      <!-- END: GALLERY TABLE - COL 2 -->

                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <!-- END: GALLERY TABLE -->
                              <?php } ?>

                              <?php if ( null !== $cta_url ) { ?>
                              <!-- START: CTA TABLE -->
                              <table id="cta-container" align="center" border="0" cellpadding="" cellspacing="0" height="auto" width="100%" style="padding: 9px 18px;">
                                <tbody>
                                  <tr>
                                    <td style="padding: 9px 18px; text-align: center; color: <?php echo $white; ?>;">
                                      <?php if ( 'style-1' === $tmpl_body || 'style-2' === $tmpl_body ) { 
                                        $cta_background = $mediumGreen;
                                      } else {
                                        $cta_background = $darkGreen;
                                      } ?>
                                      <a href="<?php echo $cta_url; ?>" style="color: <?php echo $white; ?>; background-color: <?php echo $cta_background; ?>; text-decoration: none; padding: 12px 22px;">Learn More</a>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <!-- END: ADDRESS TEXT TABLE -->
                              <?php } ?>
                              
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
                              <p>logo_src_white: <?php echo $footer_logo_src_white; ?></p>
                              <p>logo_src_dark: <?php echo $footer_logo_src_dark; ?></p>
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
