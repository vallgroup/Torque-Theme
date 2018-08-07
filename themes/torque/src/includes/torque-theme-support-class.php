<?php

class Torque_Theme_Support {

  public static function add_all() {
    $theme_support = self::get_theme_support();
    $post_type_support = self::get_post_type_support();

    // add theme support
    foreach ($theme_support as $feature => $args) {
      if ( sizeof($args) === 0 ) {
        add_theme_support($feature);
      } else {
        add_theme_support($feature, $args);
      }
    }

    // add post type support
    foreach ($post_type_support as $post_type => $feature) {
      add_post_type_support( $post_type, $feature );
    }
  }

  /**
   * Pass theme support through filter so children can add/modify
   */
  public static function get_theme_support() {
    // 'feature'      => 'args'
    //
    // leave args as empty array to not pass any
    $theme_support = array(
      'html5'             => array(
      	'comment-list',
      	'search-form',
      	'comment-form',
      	'gallery',
      	'caption',
      ),
      'post-thumbnails'   => array(),
    );

    return apply_filters('torque_theme_support', $theme_support );
  }

  /**
   * Pass post type support through filter so children can add/modify
   */
  public static function get_post_type_support() {
    // 'post_type'      => 'feature'
    $post_type_support = array(
      'page'      => 'excerpt'
    );

    return apply_filters('torque_post_type_support', $post_type_support );
  }
}

?>
