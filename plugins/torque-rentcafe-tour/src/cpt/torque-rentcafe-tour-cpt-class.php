<?php
/**
 * Register the torque cpt and it's meta boxes
 */
class Torque_Rentcafe_Tour_CPT {

	/**
	 * Holds the rentcafe_tour cpt object
	 *
	 * @var Object
	 */
	protected $rentcafe_tour = null;

	/**
	 * Holds the labels needed to build the rentcafe_tour custom post type.
	 *
	 * @var array
	 */
	public static $rentcafe_tour_labels = array(
			'singular'       => 'Rentcafe Tour',
			'plural'         => 'Rentcafe Tours',
			'slug'           => 'torque-rentcafe-tour',
			'post_type_name' => 'torque_rentcafe_tour',
	);

	/**
	 * Holds options for the rentcafe_tour custom post type
	 *
	 * @var array
	 */
	protected $rentcafe_tour_options = array(
		'public'		=> false,
	);

	/**
	 * register our post type and meta boxes
	 */
	function __construct() {
		if ( class_exists( 'PremiseCPT' ) ) {
			new PremiseCPT( self::$rentcafe_tour_labels, $this->rentcafe_tour_options );
      
      // add metaboxes needed from ACF
      add_action( 'acf/init', array( $this, 'acf_init' ) );
		}
	}

	public function acf_init() {
    
		// UPDATED: 20210128
		
		// ACF DEFS - START
		
		if( function_exists('acf_add_local_field_group') ):

			acf_add_local_field_group(array(
				'key' => 'group_60129dca3332d',
				'title' => 'Rentcafe Tour Options',
				'fields' => array(
					array(
						'key' => 'field_60129dd40aba3',
						'label' => 'Marketing API Key',
						'name' => 'marketing_api_key',
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
						'readonly' => 0,
						'disabled' => 0,
					),
					array(
						'key' => 'field_60129de50aba4',
						'label' => 'Company Code',
						'name' => 'company_code',
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
						'readonly' => 0,
						'disabled' => 0,
					),
					array(
						'key' => 'field_60129def0aba5',
						'label' => 'Property ID',
						'name' => 'property_id',
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
						'readonly' => 0,
						'disabled' => 0,
					),
					array(
						'key' => 'field_60129e080aba6',
						'label' => 'Property Code',
						'name' => 'property_code',
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
						'readonly' => 0,
						'disabled' => 0,
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

		// ACF DEFS - END
	}
}

?>
