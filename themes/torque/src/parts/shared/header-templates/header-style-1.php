<?php

/**
 * Header Template 1:
 *
 * Logo - Burger menu with mobile opening from top of screen (mobile & tablet)
 * Logo - Menu items inline (desktop)
 *
 *
 * Note: styles for this which require a media query
 * can be found in the child theme boilerplate.
 */

$background_color = isset($tq_header_style_1_color) && $tq_header_style_1_color !== ''
  ? $tq_header_style_1_color
  : 'transparent';

$logo_dark_light = isset($tq_header_style_1_logo) && $tq_header_style_1_logo === 'white' ? 'white' : 'dark';

$extra_classes = isset($tq_header_style_1_classes) ? $tq_header_style_1_classes : '';

?>

<header
  id="header-style-1"
  class="torque-header <?php echo $extra_classes; ?>"
  style="background-color: <?php echo $background_color; ?>">

  <div class="row torque-header-content-wrapper torque-navigation-toggle">

    <div class="col2 col3-tablet col4-desktop torque-header-logo-wrapper">
      <?php get_template_part( 'parts/shared/logo', $logo_dark_light); ?>
    </div>

    <div class="col2 col3x2-tablet torque-header-burger-menu-wrapper">
      <?php get_template_part( 'parts/elements/element', 'burger-menu-squeeze'); ?>
    </div>

    <div class="col2 col3-tablet col4x3-desktop torque-header-menu-items-inline-wrapper">
      <?php get_template_part( 'parts/shared/header-parts/menu-items/menu-items', 'inline'); ?>
    </div>

  </div>

  <div class="col1 torque-navigation-toggle torque-header-menu-items-mobile">
    <?php get_template_part( 'parts/shared/header-parts/menu-items/menu-items', 'stacked'); ?>
  </div>

</header>
