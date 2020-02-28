<?php

class Torque_Rentcafe_ACF_Class {

  public function __construct() {
    // run actions on admin init
    // add_action('admin_init', array( $this, 'acf_admin_init'), 99);

    // load ACF defs
    add_action('acf/init', array( $this, 'acf_init' ) );

    // hide acf in admin - client doesnt need to see this
    // add_filter('acf/settings/show_admin', '__return_false');
  }

  public function acf_admin_init() {
    // hide options page
    // remove_menu_page('acf-options');
  }

  public function acf_init() {

    // add ACF definitions
    
    if( function_exists('acf_add_local_field_group') ):

      acf_add_local_field_group(array(
        'key' => 'group_5e5057141af8a',
        'title' => 'RentCafe Options',
        'fields' => array(
          array(
            'key' => 'field_5e507080b133d',
            'label' => 'RentCafe API Token',
            'name' => 'rentcafe_api_token',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '50',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
          ),
          array(
            'key' => 'field_5e57e16ada63f',
            'label' => 'Property Codes',
            'name' => 'property_codes',
            'type' => 'repeater',
            'instructions' => 'Floorplans for the following property codes will be cached and made available in the front-end.',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '50',
              'class' => '',
              'id' => '',
            ),
            'collapsed' => '',
            'min' => 0,
            'max' => 0,
            'layout' => 'table',
            'button_label' => 'Add Property Code',
            'sub_fields' => array(
              array(
                'key' => 'field_5e57e1a0da640',
                'label' => 'Property Code',
                'name' => 'property_code',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                  'width' => '',
                  'class' => '',
                  'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
              ),
            ),
          ),
          array(
            'key' => 'field_5e50572b1b55e',
            'label' => 'Floorplans Response',
            'name' => 'floorplans_response',
            'type' => 'textarea',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'maxlength' => '',
            'rows' => '',
            'new_lines' => '',
          ),
          array(
            'key' => 'field_5e56b5d3101af',
            'label' => 'Availabilities Response',
            'name' => 'availabilities_response',
            'type' => 'textarea',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'maxlength' => '',
            'rows' => '',
            'new_lines' => '',
          ),
        ),
        'location' => array(
          array(
            array(
              'param' => 'options_page',
              'operator' => '==',
              'value' => 'acf-options',
            ),
          ),
        ),
        'menu_order' => 1,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
      ));
      
      endif;
    
    // end ACF definitions 
  }

}
?>