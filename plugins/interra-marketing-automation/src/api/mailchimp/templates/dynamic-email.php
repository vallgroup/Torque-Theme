<?php global $post_id, $email_templates, $document; ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo esc_html( $document->post_title ); ?></title>
  </head>
  <body>
    <pre><?php // var_dump( $document ) ?></pre>
    <pre><?php // var_dump( $email_templates ) ?></pre>
    <?php 

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
    
    $logo_src_white = get_theme_mod( $tab_settings['logo_white_setting'] );
    $logo_src_dark = get_theme_mod( $tab_settings['logo_setting'] );

    // styling
    $header_bg_color = '';
    $header_height = '';


    /**
     * Body Data
     */

    if ( !empty( $document ) && null !== $post_id ) :

      // $document_id = isset( $document->ID ) && null !== $document->ID
      //   ? $document->ID
      //   : null;

      // project details
      $project_name             = get_field( 'project_name', $post_id );
      $listing                  = get_field( 'listing', $post_id );
      
      // key details
      $pin                      = get_field( 'pin', $post_id );
      $building_type            = get_field( 'building_type', $post_id );
      $number_of_units          = get_field( 'number_of_units', $post_id );
      $year_built               = get_field( 'year_built', $post_id );
      $utilities_paid_by_tenant = get_field( 'utilities_paid_by_tenant', $post_id );
      
      $__key_details = array(
        'PIN' => $pin,
        'Building Type' => $building_type,
        'Number Of Units' => $number_of_units,
        'Year Built' => $year_built,
        'Utilities Paid By Tenant' => $utilities_paid_by_tenant,
      );
      
      // location
      // TODO

      // additional ket details
      $search_detail_names = array(
        'cap rate',
        'building size'
      );
      if ( have_rows( 'key_details', $post_id ) ) :
        while ( have_rows( 'key_details', $post_id ) ) : the_row();
          $sub_field_name =  get_sub_field('name');
          $sub_field_value = get_sub_field('value');

          echo '<p>Key Detail: ' . $sub_field_name . ' -> ' . $sub_field_value . '</p>';

          if ( in_array( strtolower( $sub_field_name ), $search_detail_names ) ) {
            $__key_details[ $sub_field_name ] = $sub_field_value;
          }
        endwhile;
      endif;
      
      // icons
      // TODO

      // gallery
      $pictures                 = get_field( 'pictures', $post_id );

      // property details
      global $post;
      $post = $listing;
      setup_postdata( $post );

      $content                  = get_the_content();
      $highlights               = get_field( 'listing_highlights' );
      // TODO get the fetured image for the project, rather than the property?
      $featured_image           = get_the_post_thumbnail_url( null, 'large');
      
    endif;


    /**
     * Footer Data
     */

    // logo white defined in header data
    // logo dark defined in header data

    $address                    = get_field('address', 'options');
    $phone                      = get_field('phone', 'options');
    // Should probably add the email to the ACF Options?
    $email                      = 'info@interrarealty.com';
    $site_url                   = get_site_url();
    $social_channels            = have_rows('social_media', 'options');

    // 3x contacts in 2 of 3 templates (are these related to the property, or?)
    // TODO

    
    /**
     * Email Template Configuration
     */
    
    // loop each section template, and assign associated variables
    // Eg: header; background-color, logo, height, 

    ?>

    <p>--------- HEADER ---------</p>
    <p><?php // var_dump( $logo_src_white ); ?></p>
    <p><?php // var_dump( $logo_src_dark ); ?></p>

    <p>--------- BODY ---------</p>
    <p>Project/Post ID: <?php echo $post_id; ?></p>
    <p><?php // var_dump( $project_name ); ?></p>
    <p><?php var_dump( $__key_details ); ?></p>
    <p><?php // var_dump( $pictures ); ?></p>
    <p>Property/Post ID: <?php echo get_the_ID(); ?></p>
    <p><?php var_dump( $content ); ?></p>
    <p><?php var_dump( $highlights ); ?></p>
    <p><?php var_dump( $featured_image ); ?></p>

    <p>--------- FOOTER ---------</p>
    <p><?php var_dump( $logo_src_white ); ?></p>
    <p><?php var_dump( $logo_src_dark ); ?></p>
    <p><?php var_dump( $address ); ?></p>
    <p><?php var_dump( $phone ); ?></p>
    <p><?php var_dump( $email ); ?></p>
    <p><?php var_dump( $site_url ); ?></p>
    <p><?php var_dump( $social_channels ); ?></p>
    
    <table><!-- START: MAIN CONTENT TABLE -->
      <tr>
        <td>

          <table><!-- START: HEADER TABLE -->
            <tr>
              <td>
              </td>
            </tr>
          </table><!-- END: HEADER TABLE -->

          <table><!-- START: BODY TABLE -->
            <tr>
              <td>
              </td>
            </tr>
          </table><!-- END: BODY TABLE -->

          <table><!-- START: FOOTER TABLE -->
            <tr>
              <td>
              </td>
            </tr>
          </table><!-- END: FOOTER TABLE -->

        </td>
      </tr>
    </table><!-- END: MAIN CONTENT TABLE -->
  </body>
</html>
