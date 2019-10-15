<?php

require_once( get_template_directory() . '/includes/torque-nav-menus-class.php' );

class The_Cannery_Nav_Menus {

  public function __construct() {
    add_filter( Torque_Nav_Menus::$nav_menus_filter_handle, array( $this, 'modify_parent_nav_menus' ) );
    add_filter( Torque_Nav_Menus::$nav_menus_primary_location_filter_handle, array( $this, 'modify_parent_primary_slug' ) );
  }

  public function modify_parent_nav_menus( $nav_menus ) {
    // do something to nav menus
    return $nav_menus;
  }

  public function modify_parent_primary_slug( $slug ) {
    return $slug;
  }
}

?>
