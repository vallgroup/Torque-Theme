<?php

// require_once( get_template_directory() . '/includes/acf/torque-acf-search-class.php' );

class IMA_ACF {

  public function __construct() {
    add_action('admin_init', array( $this, 'acf_admin_init'), 99);
    add_action('acf/init', array( $this, 'acf_init' ) );

    // hide acf in admin - client doesnt need to see this
    // add_filter('acf/settings/show_admin', '__return_false');

    // add acf fields to wp search
    // if ( class_exists( 'Torque_ACF_Search' ) ) {
    //   add_filter( Torque_ACF_Search::$ACF_SEARCHABLE_FIELDS_FILTER_HANDLE, array( $this, 'add_fields_to_search' ) );
    // }
  }

  public function acf_admin_init() {
    // hide options page
    // remove_menu_page('acf-options');
  }

  public function add_fields_to_search( $fields ) {
    // $fields[] = 'hero_overlay_title';
    // $fields[] = 'hero_overlay_subtitle';
    // $fields[] = 'page_heading';
    // $fields[] = 'page_intro';
    // $fields[] = 'heading';
    // $fields[] = 'content';

    return $fields;
  }

  public function acf_init() {
//

//
  }
}

?>
