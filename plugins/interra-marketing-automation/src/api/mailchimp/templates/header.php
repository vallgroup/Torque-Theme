<?php

global $style, $document;

require_once( get_template_directory() . '/includes/customizer/customizer-tabs/tabs/torque-customizer-tab-site-identity-class.php' );

$tab_settings = Torque_Customizer_Tab_Site_Identity::get_settings();

$logo_src = get_theme_mod( $tab_settings['logo_white_setting'] );

$listing = get_field('listing', $document->ID);

$address = $listing ? get_field('listing_address', $listing->ID) : '';
$city = $listing ? get_field('listing_city', $listing->ID) : '';

 ?>

<?php if ( 'style-1' === $style ) : ?>

<td valign="top" id="templateHeader">
  <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
    <tbody class="mcnImageBlockOuter">
      <tr>
        <td valign="top" style="padding:9px;background-color: rgba(56, 56, 56, 0.67);" class="mcnImageBlockInner">
          <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
            <tbody>
              <tr>
                <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">
                    <!-- Interra Logo -->
                    <img align="center" alt="" src="<?php echo esc_url( $logo_src ); ?>" width="200" style="max-width:200px !important; height: auto !important; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">
                  </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
  <?php if ( has_post_thumbnail( $document->ID ) ) : ?>
  <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageCardBlock">
    <tbody class="mcnImageCardBlockOuter">
      <tr>
        <td class="mcnImageCardBlockInner" valign="top" style="padding-top:0px; padding-right:18px; padding-bottom:9px; padding-left:18px;">
          <table align="right" border="0" cellpadding="0" cellspacing="0" class="mcnImageCardBottomContent" width="100%" style="background-color: #63A558;">
            <tbody>
              <tr>
                <td class="mcnImageCardBottomImageContent" align="left" valign="top" style="padding-top:0px; padding-right:0px; padding-bottom:0; padding-left:0px;">
                  <img alt="<?php echo $document->post_title; ?> Hero Image" src="<?php echo wp_get_attachment_url( get_post_thumbnail_id( $document->ID ) ); ?>" width="564" style="max-width:4500px;" class="mcnImage">
                </td>
              </tr>
              <tr>
                <td class="mcnTextContent" valign="top" style="padding: 9px 18px;color: #F2F2F2;font-family: Lato, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;font-size: 14px;font-weight: normal;text-align: center;" width="546">
                    <?php echo $address, ' ', $city; ?>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
  <?php endif; ?>
  <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
    <tbody class="mcnDividerBlockOuter">
      <tr>
        <td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
          <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top: 2px none #EAEAEA;">
            <tbody>
              <tr>
                <td>
                  <span></span>
                </td>
              </tr>
            <tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
</td>

<?php endif; ?>

<?php if ( 'style-2' === $style ) : ?>

<td valign="top" id="templateHeader">
  <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
    <tbody class="mcnImageBlockOuter">
      <tr>
        <td valign="top" style="padding:9px; background-color: rgba(56, 56, 56, 0.67);" class="mcnImageBlockInner">
          <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
            <tbody>
              <tr>
                <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">
                  <img align="center" alt="" src="<?php echo esc_url( $logo_src ); ?>" width="200" style="max-width:200px !important; height: auto !important; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">
                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
  <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnBoxedTextBlock" style="min-width:100%;">
      <!--[if gte mso 9]>
  	<table align="center" border="0" cellspacing="0" cellpadding="0" width="100%">
  	<![endif]-->
  	<tbody class="mcnBoxedTextBlockOuter">
      <tr>
        <td valign="top" class="mcnBoxedTextBlockInner">

  				<!--[if gte mso 9]>
  				<td align="center" valign="top" ">
  				<![endif]-->
            <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;" class="mcnBoxedTextContentContainer">
              <tbody>
                <tr>
                  <td style="padding-top:9px; padding-left:18px; padding-bottom:9px; padding-right:18px;">
                    <table border="0" cellspacing="0" class="mcnTextContentContainer" width="100%" style="min-width: 100% !important;background-color: #96CB45;">
                      <tbody>
                        <tr>
                          <td valign="top" class="mcnTextContent" style="padding: 18px;color: #FFFFFF;font-family: Lato, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;font-size: 14px;font-weight: normal;text-align: center;">
                              <h1 class="null" style="text-align: center;">
                                <span style="color:#FFFFFF">PRICE REDUCTION</span>
                              </h1>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
  				<!--[if gte mso 9]>
  				</td>
  				<![endif]-->

  				<!--[if gte mso 9]>
                  </tr>
                  </table>
  				<![endif]-->
        </td>
      </tr>
    </tbody>
  </table>
  <?php if ( has_post_thumbnail( $document->ID ) ) : ?>
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageCardBlock">
      <tbody class="mcnImageCardBlockOuter">
        <tr>
          <td class="mcnImageCardBlockInner" valign="top" style="padding-top:9px; padding-right:18px; padding-bottom:9px; padding-left:18px;">
            <table align="right" border="0" cellpadding="0" cellspacing="0" class="mcnImageCardBottomContent" width="100%">
              <tbody>
                <tr>
                  <td class="mcnImageCardBottomImageContent" align="left" valign="top" style="padding-top:0px; padding-right:0px; padding-bottom:0; padding-left:0px;">
                    <img alt="<?php echo $document->post_title; ?> Hero Image" src="<?php echo wp_get_attachment_url( get_post_thumbnail_id( $document->ID ) ); ?>" width="564" style="max-width:1200px;" class="mcnImage">
                  </td>
                </tr>
                <tr>
                  <td class="mcnTextContent" valign="top" style="padding: 9px 18px;color: #F2F2F2;font-family: Lato, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;font-size: 14px;font-weight: normal;text-align: center;" width="546">
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
  <?php endif; ?>
</td>

<?php endif; ?>