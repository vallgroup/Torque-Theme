<?php

class Torque_Recaptcha_ACF {

  public function __construct() {
    add_action('acf/init', array( $this, 'acf_init' ) );
  }

  public function acf_init() {
    if( function_exists('acf_add_local_field_group') ):

      acf_add_local_field_group(array(
      	'key' => 'group_5c1d05ce44fb9',
      	'title' => 'reCAPTCHA',
      	'fields' => array(
      		array(
      			'key' => 'field_5c1d05d877fb1',
      			'label' => 'API Key',
      			'name' => 'tq_recaptcha_api_key',
      			'type' => 'password',
      			'instructions' => 'https://www.google.com/recaptcha/admin',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '',
      				'class' => '',
      				'id' => '',
      			),
      			'placeholder' => '',
      			'prepend' => '',
      			'append' => '',
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
      	'menu_order' => 0,
      	'position' => 'normal',
      	'style' => 'default',
      	'label_placement' => 'top',
      	'instruction_placement' => 'label',
      	'hide_on_screen' => '',
      	'active' => 1,
      	'description' => '',
      ));

    endif;
  }
}

?>
