<?php

class Torque_Customizer {

  public static $tabs_filter_handle = 'torque_customizer_tabs';

  public static function get_tabs() {
    $tabs = array(
      'Torque_Customizer_Tab_Site_Identity'   => get_template_directory() . '/includes/customizer/customizer-tabs/tabs/torque-customizer-tab-site-identity-class.php'
    );

    return apply_filters( self::$tabs_filter_handle, $tabs );
  }

  public function __construct() {
    $tabs = self::get_tabs();

    foreach ($tabs as $class => $path) {
      require_once($path);
      new $class();
    }
  }
}

?>
