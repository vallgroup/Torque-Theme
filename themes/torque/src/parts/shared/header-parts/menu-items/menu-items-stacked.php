<?php

require_once( get_template_directory() . '/includes/torque-nav-menus-class.php');

// if menu items isnt set by the including file,
// get the primary menu items
if ( ! isset($menu_items) ) {
  $menu_items = Torque_Nav_Menus::get_nav_menu_items_by_location( Torque_Nav_Menus::get_default_primary_location_slug() );
}

if ($menu_items) {

  global $wp;
  $current_url = home_url( add_query_arg( array(), $wp->request ) );

?>
  <div class="torque-menu-items-stacked" >
    <?php

    foreach ($menu_items as $menu_item) {

      $active_class = $menu_item->url === $current_url || $menu_item->url === $current_url.'/'
        ? 'active'
        : '';
    ?>

      <div class="torque-menu-item-wrapper <?php echo $active_class; ?>">
        <a href="<?php echo $menu_item->url; ?>">
          <div class="torque-menu-item <?php echo $active_class; ?>">
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
