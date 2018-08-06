<?php

class Torque_Floor_Plan_CPT {

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
	protected $floor_plan_labels = array(
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
			'editor',
      'excerpt',
			'thumbnail',
		),
		'menu_icon'           => 'dashicons-layout',
	);

	/**
	 * Registers the cpt and adds metaboxes
	 */
	function __construct() {
		$this->floor_plan = new PremiseCPT( $this->floor_plan_labels, $this->floor_plan_options );

		pwp_add_metabox(
			array(
				'title'   => 'Floor Number',
				'context' => 'side',
				'priority' => 'high',
			),
			array( $this->floor_plan_labels['post_type_name'] ),
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
		);

		pwp_add_metabox(
			'RSF',
			$this->floor_plan_labels['post_type_name'],
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
		);

		pwp_add_metabox(
			'Floor Plan Downloads',
			array( $this->floor_plan_labels['post_type_name'] ),
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
		);
	}
}
