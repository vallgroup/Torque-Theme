<?php

class Torque_Floor_Plan_CPT {

	public static $METABOXES_FILTER_HOOK = 'torque_floor_plans_cpt_metaboxes';

	/**
	 * Holds the floor plan cpt object
	 *
	 * @var Object
	 */
	protected $floor_plan = null;

	/**
	 * Holds the labels needed to build the floor plan custom post type.
	 *
	 * @var array
	 */
	public static $floor_plan_labels = array(
			'singular'       => 'Floor Plan',
			'plural'         => 'Floor Plans',
			'slug'           => 'floor-plan',
			'post_type_name' => 'floor_plan',
	);

	public static $FLOORPLAN_CATEGORY_ACF_KEY = 'field_5ee16e843395b';

	/**
	 * Holds options for the floor plan custom post type
	 *
	 * @var array
	 */
	protected $floor_plan_options = array(
		'supports' => array(
			'title',
      'excerpt',
			'thumbnail',
		),
		'menu_icon'           => 'dashicons-layout',
	);

	/**
	 * Registers the cpt and adds metaboxes
	 */
	function __construct() {
		$this->floor_plan = new PremiseCPT( self::$floor_plan_labels, $this->floor_plan_options );

		add_action( 'init', array( $this, 'add_metaboxes' ) );
		add_action( 'acf/init', array( $this, 'add_acf_metaboxes' ) );
	}

	// we need to use ACF so we can use the Filtered Loop tabs functionality...
	public function add_acf_metaboxes() {
		if( function_exists('acf_add_local_field_group') ):

			acf_add_local_field_group(array(
				'key' => 'group_5ee16e7bd04f0',
				'title' => 'Floorplan Options',
				'fields' => array(
					array(
						'key' => self::$FLOORPLAN_CATEGORY_ACF_KEY,
						'label' => 'Floorplan Category',
						'name' => 'floorplan_category',
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
							'central-townhomes' => 'Central Townhomes',
							'fairview-townhomes' => 'Fairview Townhomes',
							'lynn-townhomes' => 'Lynn Townhomes',
							'minor-townhomes' => 'Minor Townhomes',
						),
						'default_value' => array(
							0 => 'central-townhomes',
						),
						'allow_null' => 0,
						'multiple' => 0,
						'ui' => 1,
						'ajax' => 0,
						'return_format' => 'value',
						'placeholder' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'floor_plan',
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

	public function add_metaboxes() {
		$maybe_metaboxes = array(
			'floor_number' => array(
				array(
					'title'   => 'Floor Number',
					'context' => 'side',
					'priority' => 'high',
				),
				array( self::$floor_plan_labels['post_type_name'] ),
				array(
					array(
						'type'    => 'number',
						'step'		=> 1,
						'context' => 'post',
						'name'    => 'floor_plan_floor_number',
						'label'   => 'Floor Number',
					),
				),
				'floor_plan_floor_number'
			),

			'rsf' => array(
				'RSF',
				self::$floor_plan_labels['post_type_name'],
				array(
					array(
						'type'    => 'number',
						'step'		=> 1,
						'context' => 'post',
						'name'    => 'floor_plan_rsf',
						'label'   => 'Floor Plan RSF',
					),
				),
				'floor_plan_rsf'
			),

			'downloads' => array (
				'Floor Plan Downloads',
				array( self::$floor_plan_labels['post_type_name'] ),
				array(
					'name_prefix' => 'floor_plan_downloads',
					array(
						'type'     => 'wp_media',
						'context'  => 'post',
						'name'     => '[pdf]',
						'label'    => 'PDF',
					),
				),
				'floor_plan_downloads'
			),
		);

		$metaboxes = apply_filters( self::$METABOXES_FILTER_HOOK, $maybe_metaboxes );

		foreach ($metaboxes as $key => $value) {
			pwp_add_metabox(...$value);
		}
	}
}
