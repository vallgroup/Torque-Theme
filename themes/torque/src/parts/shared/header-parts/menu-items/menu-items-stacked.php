<?php

require_once( get_template_directory() . '/includes/torque-nav-menus-class.php');

$menu_items = Torque_Nav_Menus::get_nav_menu_items_by_location( Torque_Nav_Menus::get_default_primary_location_slug() );

if ($menu_items) {

?>
  <div class="torque-menu-items-stacked" >
    <?php

    foreach ($menu_items as $menu_item) {
    ?>

      <div class="torque-menu-item-wrapper">
        <a href="<?php echo $menu_item->url; ?>">
          <div class="torque-menu-item">
            <?php echo $menu_item->title; ?>
          </div>
        </a>
      </div>
    <?php
    }

    ?>
  </div>
<?php

}

?>
