<?php

require_once( get_stylesheet_directory() . '/includes/<torque_child_theme_slug>-nav-menus-class.php');
require_once( get_stylesheet_directory() . '/includes/widgets/<torque_child_theme_slug>-widgets-class.php');
require_once( get_stylesheet_directory() . '/includes/acf/<torque_child_theme_slug>-acf-class.php');

/**
 * Child Theme Nav Menus
 */

 if ( class_exists( '<torque_child_theme_class_prefix>_Nav_Menus' ) ) {
   new <torque_child_theme_class_prefix>_Nav_Menus();
 }

/**
 * Child Theme Widgets
 */

if ( class_exists( '<torque_child_theme_class_prefix>_Widgets' ) ) {
  new <torque_child_theme_class_prefix>_Widgets();
}

/**
 * Child Theme ACF
 */

 if ( class_exists( '<torque_child_theme_class_prefix>_ACF' ) ) {
   new <torque_child_theme_class_prefix>_ACF();
 }




/**
 * Admin settings
 */

 // remove menu items
 function torque_remove_menus(){

   //remove_menu_page( 'index.php' );                  //Dashboard
   //remove_menu_page( 'edit.php' );                   //Posts
   //remove_menu_page( 'upload.php' );                 //Media
   //remove_menu_page( 'edit.php?post_type=page' );    //Pages
   //remove_menu_page( 'edit-comments.php' );          //Comments
   //remove_menu_page( 'themes.php' );                 //Appearance
   //remove_menu_page( 'plugins.php' );                //Plugins
   //remove_menu_page( 'users.php' );                  //Users
   //remove_menu_page( 'tools.php' );                  //Tools
   //remove_menu_page( 'options-general.php' );        //Settings

 }
 add_action( 'admin_menu', 'torque_remove_menus' );




/**
 * Enqueues
 */

// enqueue child styles after parent styles, both style.css and main.css
// so child styles always get priority
add_action( 'wp_enqueue_scripts', 'torque_enqueue_child_styles' );
function torque_enqueue_child_styles() {

    $parent_style = 'parent-styles';
    $parent_main_style = 'torque-theme-styles';

    // make sure parent styles enqueued first
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( $parent_main_style, get_template_directory_uri() . '/bundles/main.css' );

    // enqueue child style
    wp_enqueue_style( '<torque_child_theme_slug>-styles',
        get_stylesheet_directory_uri() . '/bundles/main.css',
        array( $parent_style, $parent_main_style ),
        wp_get_theme()->get('Version')
    );
}

// enqueue child scripts after parent script
add_action( 'wp_enqueue_scripts', 'torque_enqueue_child_scripts');
function torque_enqueue_child_scripts() {

    wp_enqueue_script( '<torque_child_theme_slug>-script',
        get_stylesheet_directory_uri() . '/bundles/bundle.js',
        array( 'torque-theme-scripts' ), // depends on parent script
        wp_get_theme()->get('Version'),
        true       // put it in the footer
    );
}

?>
