<?php

/**
 * Requires
 */

require_once( 'includes/utilities/torque-utilities.php' );
require_once( 'includes/customizer/torque-customizer-class.php' );
require_once( 'includes/torque-nav-menus-class.php' );
require_once( 'includes/torque-theme-support-class.php' );

/**
 * Set permalink structure
 *
 * Strangely, pretty permalink structure is required for the REST API...
 */
add_action('init', 'set_permalink');

function set_permalink(){
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure('/%postname%/');
}

/**
 * Add theme support
 */

 if ( class_exists('Torque_Theme_Support') ) {
   Torque_Theme_Support::add_all();
 }


/**
 * Nav Menus
 */

if ( class_exists('Torque_Nav_Menus') ) {
  Torque_Nav_Menus::register_all();
}

/**
 * Customizer
 */

if ( class_exists('Torque_Customizer') ) {
  new Torque_Customizer();
}


/**
 * Actions and Filters
 */

add_filter( 'body_class', array( 'TQ', 'add_slug_to_body_class' ) );

add_action( 'wp_enqueue_scripts', 'torque_custom_script_init' );


/**
 * Scripts
 */

function torque_custom_script_init(){

	wp_enqueue_script( 'torque-theme-scripts',
		get_template_directory_uri().'/bundles/bundle.js',
		array( 'jquery' ),
		wp_get_theme()->get('Version'),
		true
	);

	wp_enqueue_style( 'torque-theme-styles', get_template_directory_uri().'/bundles/main.css' );

}


/**
 * Register ACF Pro Fields with PHP
 */
require_once get_template_directory().'/includes/acf/acf-init.php';
/**
 * Add ACF Pro Options page
 */
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
}





/**
 * Security & cleanup wp admin
 */


//remove wordpress logo from adminbar
function wp_logo_admin_bar_remove() {
	global $wp_admin_bar;

	/* Remove their stuff */
	$wp_admin_bar->remove_menu('wp-logo');
}

add_action('wp_before_admin_bar_render', 'wp_logo_admin_bar_remove', 0);

// Remove default Dashboard widgets
function disable_default_dashboard_widgets() {

	remove_meta_box('dashboard_quick_press', 'dashboard', 'core');
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');
	remove_meta_box('dashboard_primary', 'dashboard', 'core');
	remove_meta_box('dashboard_secondary', 'dashboard', 'core');
}
add_action('admin_menu', 'disable_default_dashboard_widgets');

remove_action('welcome_panel', 'wp_welcome_panel');

/**
 * Custom login
 */

// Add custom css
function my_custom_login() {
	echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . 'statics/css/custom-login-style.css" />';
}
add_action('login_head', 'my_custom_login');

// Link the logo to the home of our website
function my_login_logo_url() {
	return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

// Change the title text
function my_login_logo_url_title() {
	return get_bloginfo( 'name' );
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );
