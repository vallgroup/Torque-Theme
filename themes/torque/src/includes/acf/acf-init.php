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
