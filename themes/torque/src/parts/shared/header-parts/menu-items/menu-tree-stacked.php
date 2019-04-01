<?php

require_once( get_template_directory() . '/includes/torque-nav-menus-class.php');

$menu_items = Torque_Nav_Menus::get_nav_menu_items_as_tree_by_location( Torque_Nav_Menus::get_default_primary_location_slug() );

global $wp;
$current_url = home_url( add_query_arg( array(), $wp->request ) );

if ($menu_items) {

?>
  <div class="torque-menu-items-stacked" >
    <?php

    foreach ($menu_items as $menu_item) {
      torque_build_menu_tree_stacked_html( $menu_item );
    }

    ?>
  </div>
<?php

}


/**
 * Build the html for each item in the menu
 *
 * @param  array  $menu_item an array containing the menu and its children if any
 * @return string            the html to display the menu item
 */
function torque_build_menu_tree_stacked_html( $menu_item ) {
  global $current_url;
  // check if the menu is active
  if (array_key_exists('menu', $menu_item)) {

    $active_class = $menu_item['menu']->url === $current_url || $menu_item['menu']->url === $current_url.'/'
      ? ' active'
      : '';

    $is_parent = isset( $menu_item['children'] ) && ! empty( $menu_item['children'] );

    $parent_class = $is_parent ? ' parent' : '';
    ?>
    <div class="torque-menu-item-wrapper<?php echo $active_class, $parent_class; ?>">
      <a href="<?php echo $menu_item['menu']->url; ?>">
        <div class="torque-menu-item <?php echo $active_class; ?>">
          <?php echo $menu_item['menu']->title; ?>
        </div>
      </a>
      <?php
      // check for children to display
      if ( $is_parent ) {
        ?><div class="torque-menu-item-children-wrapper"><?php
        foreach ( $menu_item['children'] as $child_menu ) {
          torque_build_menu_tree_stacked_html( $child_menu );
        }
        ?></div><?php
      }
      ?>
    </div>
    <?php

  }
}

?>
