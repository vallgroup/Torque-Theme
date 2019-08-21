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
    if( function_exists('acf_add_local_field_group') ):

      // Loan Amortization
      acf_add_local_field_group(array(
        'key' => 'group_5d5d57d8c1ceb',
        'title' => 'Loan Amortization Details',
        'fields' => array(
          array(
            'key' => 'field_5d5d57fc8de43',
            'label' => 'Term',
            'name' => 'term',
            'type' => 'select',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'choices' => array(
              30 => '30 years',
              15 => '15 years',
            ),
            'default_value' => array(
              0 => 30,
            ),
            'allow_null' => 0,
            'multiple' => 0,
            'ui' => 0,
            'return_format' => 'array',
            'ajax' => 0,
            'placeholder' => '',
          ),
          array(
            'key' => 'field_5d5d58af8de44',
            'label' => 'Down Payment',
            'name' => 'down_payment',
            'type' => 'number',
            'instructions' => 'Please enter a number as a percentage',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => 30,
            'placeholder' => 25,
            'prepend' => '',
            'append' => '%',
            'min' => 0,
            'max' => 100,
            'step' => '',
          ),
          array(
            'key' => 'field_5d5d66808de45',
            'label' => 'Property Value',
            'name' => 'property_value',
            'type' => 'number',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => 0,
            'placeholder' => '9,999,999',
            'prepend' => '$',
            'append' => '',
            'min' => '',
            'max' => '',
            'step' => '',
          ),
          array(
            'key' => 'field_5d5d66d98de46',
            'label' => 'Interest Rate',
            'name' => 'interest_rate',
            'type' => 'number',
            'instructions' => 'Please enter the interest rate as a percentage',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => 6,
            'placeholder' => 6,
            'prepend' => '',
            'append' => '%',
            'min' => 0,
            'max' => '',
            'step' => '',
          ),
        ),
        'location' => array(
          array(
            array(
              'param' => 'post_type',
              'operator' => '==',
              'value' => 'torque_listing',
            ),
          ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'left',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => 'Enter details for loan amortization chart & UI',
      )); // Loan Amortization

    endif;
  }
}

?>
