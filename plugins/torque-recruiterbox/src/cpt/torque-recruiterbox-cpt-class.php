<?php
/**
 * Register the torque cpt and it's meta boxes
 */
class Torque_RecruiterBox_CPT {

	/**
	 * register our post type and meta boxes
	 */
	function __construct() {
		// add metaboxes needed from ACF
		add_action( 'acf/init', array( $this, 'acf_init' ) );
	}

	public function acf_init() {

		// UPDATED: 20210421

		// ACF DEFS - START

		if( function_exists('acf_add_local_field_group') ):

			acf_add_local_field_group(array(
				'key' => 'group_607fbc296a6d1',
				'title' => 'Greenhouse Options',
				'fields' => array(
					array(
						'key' => 'field_607fbc297a1fb',
						'label' => 'Greenhouse API Keys',
						'name' => 'recruiterbox_api_keys',
						'type' => 'repeater',
						'instructions' => 'Enter at least one Client Name and API key combination, used to fetch data from Greenhouse.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '100',
							'class' => '',
							'id' => '',
						),
						'collapsed' => '',
						'min' => 1,
						'max' => 0,
						'layout' => 'table',
						'button_label' => 'Add API Key',
						'sub_fields' => array(
							array(
								'key' => 'field_607fbc2981afa',
								'label' => 'Client Name',
								'name' => 'client_name',
								'type' => 'text',
								'instructions' => '',
								'required' => 1,
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
								'readonly' => 0,
								'disabled' => 0,
							),
							array(
								'key' => 'field_607fbc2981be4',
								'label' => 'API Key',
								'name' => 'api_key',
								'type' => 'text',
								'instructions' => '',
								'required' => 1,
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
								'readonly' => 0,
								'disabled' => 0,
							)
						),
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
				'active' => true,
				'description' => '',
			));

			endif;

		// ACF DEFS - END
	}
}

?>
