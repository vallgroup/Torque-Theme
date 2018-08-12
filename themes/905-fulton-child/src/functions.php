<?php

require_once( get_stylesheet_directory() . '/includes/widgets/905-fulton-child-widgets-class.php');
require_once( get_stylesheet_directory() . '/includes/acf/905-fulton-child-acf-class.php');

/**
 * Child Theme Widgets
 */

if ( class_exists( 'Fulton_Widgets' ) ) {
  new Fulton_Widgets();
}

/**
 * Child Theme ACF
 */

 if ( class_exists( 'Fulton_ACF' ) ) {
   new Fulton_ACF();
 }


// remove admin menus that we dont want
add_action('admin_init', function() {
  remove_menu_page('edit.php');
  remove_menu_page('edit-comments.php');
});

// add allowed pois for theme
add_filter( 'torque_map_pois_allowed', function($n) {
  return 4;
});

// enqueue child styles after parent styles
add_action( 'wp_enqueue_scripts', 'torque_enqueue_child_styles' );
function torque_enqueue_child_styles() {

    $parent_style = 'parent-style';
    $parent_main_style = 'torque-theme-styles';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( $parent_main_style, get_template_directory_uri() . '/bundles/main.css' );
    wp_enqueue_style( '905-fulton-child-style',
        get_stylesheet_directory_uri() . '/bundles/main.css',
        array( $parent_style, $parent_main_style ),
        wp_get_theme()->get('Version')
    );
}

// enqueue child scripts
add_action( 'wp_enqueue_scripts', 'torque_enqueue_child_scripts');
function torque_enqueue_child_scripts() {

    wp_enqueue_script( '905-fulton-child-script',
        get_stylesheet_directory_uri() . '/bundles/bundle.js',
        array( 'torque-theme-scripts' ),
        wp_get_theme()->get('Version'),
        true
    );
}

add_action( 'wp_head', 'torque_google_analytics' );
function torque_google_analytics() {
  ?>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-123762672-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-123762672-1');
  </script>
  <?php
}

?>
