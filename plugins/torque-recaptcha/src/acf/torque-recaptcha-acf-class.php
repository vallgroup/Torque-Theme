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
						'key' => 'field_5e39e646cs09dcu2a4652',
						'label' => 'Version',
						'name' => 'tq_recaptcha_version',
						'type' => 'select',
						'instructions' => 'https://developers.google.com/recaptcha/docs/versions',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '50',
							'class' => '',
							'id' => '',
						),
						'choices' => array(
							'v2_checkbox' => 'v2 Checkbox',
							'v2_invisible' => 'v2 Invisible',
							'v3' => 'v3',
						),
						'default_value' => array(
							0 => 'v2_checkbox',
						),
						'allow_null' => 0,
						'multiple' => 0,
						'ui' => 1,
						'ajax' => 0,
						'return_format' => 'value',
						'placeholder' => '',
					),
      		array(
      			'key' => 'field_5c1d05d877fb1',
      			'label' => 'Site Key',
      			'name' => 'tq_recaptcha_api_key',
      			'type' => 'text',
      			'instructions' => 'https://www.google.com/recaptcha/admin',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '50',
      				'class' => '',
      				'id' => '',
      			),
      			'placeholder' => '',
      			'prepend' => '',
      			'append' => '',
					),
      		array(
      			'key' => 'field_5c1d05d872kjx21',
      			'label' => 'Secret Key',
      			'name' => 'tq_recaptcha_secret_key',
      			'type' => 'text',
      			'instructions' => 'https://www.google.com/recaptcha/admin',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '50',
      				'class' => '',
      				'id' => '',
      			),
      			'placeholder' => '',
      			'prepend' => '',
      			'append' => '',
					),
					array(
      			'key' => 'field_5e39e646cs09dckj324f8',
      			'label' => 'Form CSS Selector',
      			'name' => 'tq_recaptcha_form_selector',
      			'type' => 'text',
      			'instructions' => 'Eg: .contact-page form.contact-form',
      			'required' => 0,
						'conditional_logic' => array(
							array(
								array(
									'field' => 'field_5e39e646cs09dcu2a4652',
									'operator' => '==',
									'value' => 'v2_invisible',
								),
							),
							array(
								array(
									'field' => 'field_5e39e646cs09dcu2a4652',
									'operator' => '==',
									'value' => 'v3',
								),
							),
						),
      			'wrapper' => array(
      				'width' => '50',
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
