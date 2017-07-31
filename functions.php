<?php
	/**
	 * Torque Theme with Bootstrap 4 on Wordpress functions and definitions
	 *
	 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
	 *
	 * @package 		WordPress
	 * @subpackage 	Torque Theme
	 * @author 			Torque
	 */

/* ========================================================================================================================

	Required external files

	======================================================================================================================== */

	require_once( 'external/torque-utilities.php' );
	require_once( 'external/bs4navwalker.php' );

	/* ========================================================================================================================

	Add html 5 support to wordpress elements

	======================================================================================================================== */
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
		'caption',
	) );

	/* ========================================================================================================================

	Theme specific settings

	======================================================================================================================== */

	add_theme_support('post-thumbnails');

	//add_image_size( 'name', width, height, crop true|false );

	register_nav_menus(array('primary' => 'Primary Navigation'));

	/* ========================================================================================================================

	Actions and Filters

	======================================================================================================================== */

	add_action( 'wp_enqueue_scripts', 'bootstrap_script_init' );
	add_action( 'wp_enqueue_scripts', 'custom_script_init' );

	add_filter( 'body_class', array( 'TQ', 'add_slug_to_body_class' ) );

	/* ========================================================================================================================

	Custom Post Types - include custom post types and taxonomies here e.g.

	e.g. require_once( 'custom-post-types/your-custom-post-type.php' );

	======================================================================================================================== */



	/* ========================================================================================================================

	Scripts

	======================================================================================================================== */

	/**
	 * Add scripts via wp_head()
	 *
	 * @return void
	 * @author Keir Whitaker
	 */

	function bootstrap_script_init() {

		wp_register_script('bootstrap', get_template_directory_uri(). '/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '3.3.7', true);
		wp_enqueue_script('bootstrap');

		wp_register_style( 'bootstrap', get_stylesheet_directory_uri().'/bootstrap/css/bootstrap.min.css', '', '3.3.7', 'all' );
		wp_enqueue_style( 'bootstrap' );

	}

	function custom_script_init(){

		wp_register_script( 'scripts', get_template_directory_uri().'/dist/scripts.min.js', array( 'jquery' ), '0.0.1', true );
		wp_enqueue_script( 'scripts' );

		wp_register_style( 'style', get_stylesheet_directory_uri().'/dist/style.min.css' );
		wp_enqueue_style( 'style' );

	}
	/* ========================================================================================================================

	Security & cleanup wp admin

	======================================================================================================================== */

	//remove wp version
	function theme_remove_version() {
		return '';
	}

	add_filter('the_generator', 'theme_remove_version');

	//remove default footer text
	function remove_footer_admin () {
		echo "";
	}

	add_filter('admin_footer_text', 'remove_footer_admin');

	//remove wordpress logo from adminbar
	function wp_logo_admin_bar_remove() {
		global $wp_admin_bar;

		/* Remove their stuff */
		$wp_admin_bar->remove_menu('wp-logo');
	}

	add_action('wp_before_admin_bar_render', 'wp_logo_admin_bar_remove', 0);

	// Remove default Dashboard widgets
	function disable_default_dashboard_widgets() {

		//remove_meta_box('dashboard_right_now', 'dashboard', 'core');
		remove_meta_box('dashboard_activity', 'dashboard', 'core');
		remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');
		remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');
		remove_meta_box('dashboard_plugins', 'dashboard', 'core');

		remove_meta_box('dashboard_quick_press', 'dashboard', 'core');
		remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');
		remove_meta_box('dashboard_primary', 'dashboard', 'core');
		remove_meta_box('dashboard_secondary', 'dashboard', 'core');
	}
	add_action('admin_menu', 'disable_default_dashboard_widgets');

	remove_action('welcome_panel', 'wp_welcome_panel');

	/* ========================================================================================================================

	Custom login

	======================================================================================================================== */

	// Add custom css
	function my_custom_login() {
		echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/custom-login-style.css" />';
	}
	add_action('login_head', 'my_custom_login');

	// Link the logo to the home of our website
	function my_login_logo_url() {
		return get_bloginfo( 'url' );
	}
	add_filter( 'login_headerurl', 'my_login_logo_url' );

	// Change the title text
	function my_login_logo_url_title() {
		return 'Torque Theme';
	}
	add_filter( 'login_headertitle', 'my_login_logo_url_title' );

