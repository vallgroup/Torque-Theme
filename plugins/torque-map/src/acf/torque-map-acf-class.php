<?php

class Torque_Map_ACF {

  public function __construct() {
    add_action('acf/init', array( $this, 'acf_init' ) );
  }

  public function acf_init() {
    if( function_exists('acf_add_local_field_group') ):

		acf_add_local_field_group(array(
			'key' => 'group_5d4c4cbe5ba75',
			'title' => 'Google Maps',
			'fields' => array(
				array(
					'key' => 'field_5d4c4cdfad318',
					'label' => 'API Key',
					'name' => 'google_maps',
					'type' => 'text',
					'instructions' => '1. Create Google Maps API Key: https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key<br>
						&nbsp;-- Enable Maps JavaScript API<br>
						&nbsp;-- Enable Geocoding API<br>
						2. Paste API Key below, and save options<br>
						3. Enable Google Bill Account: https://console.cloud.google.com/project/_/billing/enable',
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
			'location' => array(
				array(
					array(
						'param' => 'options_page',
						'operator' => '==',
						'value' => 'acf-options',
					),
				),
			),
			'menu_order' => 10,
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
