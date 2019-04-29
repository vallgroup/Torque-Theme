<?php

class Torque_Nav_Menus {

  public static $nav_menus_filter_handle = 'torque_nav_menus';

  public static $nav_menus_primary_location_filter_handle = 'torque_nav_menus_primary_location_slug';

  public static function register_all() {
    register_nav_menus( self::get_menus() );
  }

  public static function register_menu( $menu_slug ) {
    $menus = self::get_menus();

    if (! isset($menus[$menu_slug]) ) {
      return new WP_Error('menu_not_found', 'Couldnt find '.$menu_slug.' in torque menus array');
    }

    $register_menu = array();
    $register_menu[$menu_slug] = $menus[$menu_slug];

    register_nav_menus( $register_menu );
  }

  /**
   * This slug will be used in all header nav menu templates
   * to get the primary menu for the site.
   *
   * We pass it through a filter to allow child themes to easily update this slug
   * if for some reason it has to be different
   */
  public static function get_default_primary_location_slug() {
    return apply_filters( self::$nav_menus_primary_location_filter_handle, 'primary');
  }

  /**
   * Pass menus through a filter so children can add/modify them
   */
  public static function get_menus() {
    $menus = array(
      'primary' => 'Primary Navigation'
    );

    return apply_filters( self::$nav_menus_filter_handle, $menus );
  }

  /**
   * Get nav menu items by location
   */
  public static function get_nav_menu_items_by_location( $location, $args = [] ) {

    $locations = get_nav_menu_locations();

    if ($locations && array_key_exists( $location, $locations )) {
      // Get object id by location
      $object = wp_get_nav_menu_object( $locations[$location] );

      // Get menu items by menu name
      $menu_items = wp_get_nav_menu_items( $object->name, $args );

      // Return menu post objects
      return $menu_items;

    } else {
      return [];
    }
  }

  /**
   * Get nav menu items by location and return them as a tree
   * Example: [
   *   // with children
   *   ID => [
   *     'menu' => Menu Object
   *     'children' => Array of Menu Objects
   *   ],
   *   // without children
   *   ID => [
   *     'menu' => Menu Object
   *   ]
   * ]
   */
  public static function get_nav_menu_items_as_tree_by_location( $location, $args = [] ) {
    $locations = get_nav_menu_locations();
    if ($locations && array_key_exists( $location, $locations )) {
      // Get object id by location
      $object = wp_get_nav_menu_object( $locations[$location] );
      // Get menu items by menu name
      $menu_items = wp_get_nav_menu_items( $object->name, $args );
    $tree = [];
    foreach ( $menu_items as $key => $menu ) {
      if( 0 == $menu->menu_item_parent ) {
        $tree[$menu->ID]['menu'] = $menu;
      } else {
        $tree[$menu->menu_item_parent]['children'][]['menu'] = $menu;
      }
    }
      // Return menu post objects
      return $tree;
    } else {
      return [];
    }
  }
}

?>
