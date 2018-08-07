<?php

class Torque_Nav_Menus {

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
   * Pass menus through a filter so children can add/modify them
   */
  public static function get_menus() {
    $menus = array(
      'primary' => 'Primary Navigation'
    );

    return apply_filters('torque_nav_menus', $menus );
  }
}

?>
