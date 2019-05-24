<?php
// add_filter('acf/settings/show_admin', '__return_false');
if( !function_exists('tq_theme_prefix_acf_add_local_field_groups') ):
  function tq_theme_prefix_acf_add_local_field_groups() {
    if( function_exists('acf_add_local_field_group') ):
      return;
    endif;

  }
endif;
add_action('acf/init', 'tq_theme_prefix_acf_add_local_field_groups');


/**
 * Intro: Adds a admin menu item to export ACF Fields from PHP to JSON
 * Steps:
 *  1) Un-comment the 'require' below
 *  2) Create folder 'acf-json' in child-theme root dir
 *  3) Run the feature via Custom Fields -> PHP to JSON -> Convert Field Groups
 *  4) Select the JSON file containing the Custom Fields you'd like to import
 *  5) Import via Custom Fields -> Tools -> Import Field Groups
 *  6) When done delete the 'acf-json' folder + contents, and comment 'require' below
 */
//require('acf-php-to-json.php');