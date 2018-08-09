<?php

require_once( get_template_directory() . '/includes/widgets/torque-widgets-class.php' );

class <torque_child_theme_class_prefix>_Widgets {

  public function __construct() {
    add_filter( Torque_Widgets::$sidebars_filter_handle, array( $this, 'modify_parent_sidebars' ) );
  }

  public function modify_parent_sidebars( $sidebars ) {
    return $sidebars;
  }
}

?>
