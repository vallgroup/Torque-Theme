<?php

$background_color = $tq_header_style_1_color && $tq_header_style_1_color !== ''
  ? $tq_header_style_1_color
  : 'transparent'

?>

<header
  id="header-style-1"
  class="torque-header"
  style="background-color: <?php echo $background_color; ?>">

  <div class="row torque-header-content-wrapper torque-navigation-toggle">

    <div class="col2 col3-tablet col4-desktop torque-header-logo-wrapper">
      <?php get_template_part( 'parts/shared/logo', 'dark'); ?>
    </div>

    <div class="col2 torque-header-burger-menu-wrapper">
      <?php get_template_part( 'parts/elements/element', 'burger-menu'); ?>
    </div>

    <div class="col2 col3-tablet col4x3-desktop torque-header-menu-items-inline-wrapper">
      <?php get_template_part( 'parts/shared/header-parts/menu-items/menu-items', 'inline'); ?>
    </div>

  </div>

</header>

<div class="col1 torque-navigation-toggle torque-header-menu-items-mobile">
  <?php get_template_part( 'parts/shared/header-parts/menu-items/menu-items', 'stacked'); ?>
</div>
