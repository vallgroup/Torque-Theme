<?php 

require( Interra_Marketing_Automation_PATH . '/api/mailchimp/templates/dynamic-email-table-class.php' );
require( Interra_Marketing_Automation_PATH . '/api/mailchimp/templates/dynamic-email-header-class.php' );
require( Interra_Marketing_Automation_PATH . '/api/mailchimp/templates/dynamic-email-body-class.php' );
require( Interra_Marketing_Automation_PATH . '/api/mailchimp/templates/dynamic-email-footer-class.php' );

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
  $body = Dynamic_Email_Body_Class::get_inst( $tmpl_body, $post_id );
  $footer = Dynamic_Email_Footer_Class::get_inst( $tmpl_footer, $post_id );

endif;

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
      <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="template-wrapper" style="font-size: 16px; font-family: Lato, 'Helvetica Neue', Helvetica, Arial, sans-serif; color: <?php echo Dynamic_Email_Table_Class::$colors['medium_gray']; ?>; background-color: <?php echo Dynamic_Email_Table_Class::$colors['white']; ?>;">
        <tbody>
          <tr>
            <td align="center" valign="top">

              <!-- START: MAIN CONTENT TABLE -->
              <table id="main-content-container" style="width: 600px; max-width: 600px; border: <?php echo 'style-3' === $tmpl_body ? '1px solid' . Dynamic_Email_Body_Class::$colors['medium_green'] : '0'; ?>;" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td>

                      <!-- START: HEADER TABLE -->
                      <?php $header->build_header(); ?>
                      <!-- END: HEADER TABLE -->

                      <!-- START: BODY TABLE -->
                      <?php $body->build_body(); ?>
                      <!-- END: BODY TABLE -->

                      <!-- START: FOOTER TABLE -->
                      <?php $footer->build_footer(); ?>
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
