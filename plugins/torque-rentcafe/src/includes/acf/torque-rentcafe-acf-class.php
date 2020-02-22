<?php

class Torque_Rentcafe_ACF_Class {

  public function __construct() {
    add_action('admin_init', array( $this, 'acf_admin_init'), 99);
    add_action('acf/init', array( $this, 'acf_init' ) );

    // hide acf in admin - client doesnt need to see this
    // add_filter('acf/settings/show_admin', '__return_false');
  }

  public function acf_admin_init() {
    // hide options page
    // remove_menu_page('acf-options');
  }

  public function acf_init() {

    if ( function_exists('acf_add_local_field_group') ) :
      // add ACF definitions
    endif;
  }

}
?>