<?php

require_once( get_template_directory() . '/includes/customizer/torque-customizer-class.php' );
//require_once( get_stylesheet_directory() . '/includes/customizer/tabs/example-tab-upate-class.php');

class The_Cannery_Customizer {

  public function __construct() {
    add_filter( Torque_Customizer::$tabs_filter_handle, array( $this, 'modify_tabs' ) );

    $this->update_existing_tabs();
  }

  public function modify_tabs( $tabs ) {
    return $tabs;
  }

  public function update_existing_tabs() {
    //new NC_Customizer_Tab_Site_Identity();
  }
}

?>
