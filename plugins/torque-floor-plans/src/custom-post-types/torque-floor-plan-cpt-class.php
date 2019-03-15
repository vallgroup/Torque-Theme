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

		add_action('init', array($this, 'add_metaboxes'));
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
