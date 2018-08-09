<?php

class Torque_Widgets {

  public static $sidebars_filter_handle = 'torque_sidebars';

  public static $sidebar_defaults = array(
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h4 class="torque-widget-title">',
    'after_title'   => '</h4>',
  );

  public static function get_sidebars() {
    $sidebars = array(
      'primary-sidebar'  => array(
        'name'          => 'Primary Sidebar'
      ),
      'footer-col-1'  => array(
        'name'          => 'Footer Column 1'
      ),
      'footer-col-2'  => array(
        'name'          => 'Footer Column 2'
      ),
      'footer-col-3'  => array(
        'name'          => 'Footer Column 3'
      ),
      'footer-col-4'  => array(
        'name'          => 'Footer Column 4'
      ),
    );

    return apply_filters( self::$sidebars_filter_handle, $sidebars );
  }

  public function __construct() {
    add_action( 'widgets_init', array( $this, 'torque_register_sidebars' ) );
  }

  public function torque_register_sidebars() {
    $sidebars = self::get_sidebars();

    foreach ($sidebars as $id => $sidebar) {
      $sidebar['id'] = $id;
      $sidebar = array_merge( $sidebar, self::$sidebar_defaults );

      register_sidebar( $sidebar );
    }
  }
}

?>
